<?php

namespace App\Http\Controllers;

use App\Models\InitialPermit;
use App\Models\User;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Models\InitAttachment;
use App\Models\OperAttachment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InitialApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\OperationalApplications;
use App\Models\OrderPayment;
use Illuminate\Support\Facades\Storage;

class initappController extends Controller
{
    public function showForm()
    {
        return view('initial.initial_wrs');
    }

    public function indextable()
    {
       
        $user = Auth::user();

    // Check if the user is an admin
    $isAdmin = $user->role_id === 4; 

    // Query for initial data
    $datainitialQuery = Facility::with(['initialApplication.initAttach'])
        ->join('tbl_initapplication', 'tbl_facility.fac_id', '=', 'tbl_initapplication.fac_id');
        

    // If the user is not an admin, filter by their user_id
    if (!$isAdmin) {
        $datainitialQuery->where('tbl_facility.user_id', $user->user_id);
    }
    $datainitial = $datainitialQuery->orderBy('tbl_initapplication.submission_date', 'desc')->get();

    // Query for dataAttachment
    $dataAttachmentQuery = InitAttachment::with(['initialApplication.facilityInfo'])
        ->join('tbl_initapplication', 'tbl_initattachment.initapp_id', '=', 'tbl_initapplication.initapp_id')
        ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id');

    if (!$isAdmin) {
        $dataAttachmentQuery->where('tbl_facility.user_id', $user->user_id);
    }

    $dataAttachment = $dataAttachmentQuery->get();

    // Query for orderPaymentattach
    $orderPaymentattachQuery = OrderPayment::with(['initialApplication.facilityInfo'])
        ->join('tbl_initapplication', 'tbl_orderpayment.initapp_id', '=', 'tbl_initapplication.initapp_id')
        ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id');

    if (!$isAdmin) {
        $orderPaymentattachQuery->where('tbl_facility.user_id', $user->user_id);
    }

    $orderPaymentattach = $orderPaymentattachQuery->get();

     // Query for initialPermit
     $dataInitialPermitQuery = InitialPermit::with(['initialApplication.facilityInfo'])
     ->join('tbl_initapplication', 'tbl_initialpermit.initapp_id', '=', 'tbl_initapplication.initapp_id');
    


 $dataInitialPermit = $dataInitialPermitQuery->get();

    $waterSourceTypes = [
        '1' => 'Point Source (Deep Well)',
        '2' => 'Communal Faucet System/Stand Post',
        '3' => 'Waterworks System (Water District)',
    ];
    // Pass data to the view
    return view('/transaction/transact_init', compact('datainitial', 'dataAttachment', 'waterSourceTypes', 'orderPaymentattach', 'dataInitialPermit'));
    }

    public function handleForm(Request $request)
    {
        $userId = auth()->id(); 
        
    if (!User::where('user_id', $userId)->exists()) {
        return redirect()->back()->withErrors(['error' => 'User does not exist.']);
    }

  
    
        // Validate form data
        $validated = $request->validate([
            'fac_name' => 'required|string|max:255',
            'fac_address' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_address' => 'required|string|max:255',
             'telephone_number' => 'nullable|string|max:15',
            // 'telephone_number' => ['required', 'regex:/^09\d{9}$/'],
            'area_to_serve' => 'required|string|max:255',
            'water_source_type' => 'required|string',
            'cert_pot' => 'nullable|file|mimes:pdf|max:3072',
            'sanitary_survey' => 'nullable|file|mimes:pdf|max:3072',
            'watersite_clearance' => 'nullable|file|mimes:pdf|max:3072',
            'engineers_report' => 'nullable|file|mimes:pdf|max:3072',
            'plans_specs' => 'nullable|file|mimes:pdf|max:3072'
            
        ]);

        // Create Facility record
        $facility = Facility::create([
            'user_id' => $userId,
            'fac_name' => $validated['fac_name'],
            'fac_address' => $validated['fac_address'],
            'owner_name' => $validated['owner_name'],
            'owner_address' => $validated['owner_address'],
            'telephone_number' => $validated['telephone_number'],
            'area_to_serve' => $validated['area_to_serve'],
            'water_source_type' => $validated['water_source_type'],
            'initial_permit' => 0,
            'operation_permit' => 0,
            // Add other required fields with default or null values
        ]);

        // Create InitialApplication record
        $initialApplication = InitialApplication::create([
            'fac_id' => $facility->fac_id,
            'user_id' => $userId,
            'submission_date' => now(),
            'reject_remarks' => $request->reject_remarks,
            'application_status' => 'In Process',
            // Add other required fields with default or null values
        ]);

        // Save attachments
        $attachments = [
            'cert_pot',
            'sanitary_survey',
            'watersite_clearance',
            'engineers_report',
            'plans_specs'
         
        ];

        $attachmentData = ['initapp_id' => $initialApplication->initapp_id];
        $facilityFolder = "attachments/initial/{$facility->fac_name}";

        foreach ($attachments as $attachment) {
            if ($request->hasFile($attachment)) {
                $file = $request->file($attachment);
                $path = $file->store($facilityFolder, 'public');

                $attachmentData[$attachment] = $path;
            }
        }

          // Create the InitAttachment record
    $initAttachment = InitAttachment::create($attachmentData);

        // Set all is_validated fields to null
    $initAttachment->update([
        'is_validated' => null,
        'is_application_form_validated' => null,
        'is_cert_pot_validated' => null,
        'is_sanitary_survey_validated' => null,
        'is_watersite_clearance_validated' => null,
        'is_engineers_report_validated' => null,
        'is_plans_specs_validated' => null,
    ]);

        // return response()->json(['success' => true, 'message' => 'Form saved successfully!']);
        // return redirect()->route('initial-wrs.show')->with('success', 'Form saved successfully!');
        return redirect()->route('initialtransact')->with('success', 'Form saved successfully!');
    }

    public function delete($fac_id)
{
    $userId = Auth::id();
    $userRole = Auth::user()->role_id; // Assuming you have a 'role_id' attribute on the User model

    // Find the facility by ID, allow access for the admin or the owner
    $facility = Facility::where('fac_id', $fac_id)
        ->when($userRole !== 4, function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        })
        ->first();

    if (!$facility) {
        return redirect()->back()->withErrors(['error' => 'Facility not found.']);
    }

    // Find related initial application
    $initialApplication = InitialApplication::where('fac_id', $fac_id)->first();

    if ($initialApplication) {
        // Find and delete related order payments
        $orderPayments = OrderPayment::where('initapp_id', $initialApplication->initapp_id)->get();
        foreach ($orderPayments as $orderPayment) {
            $orderPayment->delete();
        }

         // Find and delete related initial permits
         $initialPermits = InitialPermit::where('initapp_id', $initialApplication->initapp_id)->get();
         foreach ($initialPermits as $initialPermit) {
             $initialPermit->delete();
         }

        // Find and delete related attachments
        $initAttachment = InitAttachment::where('initapp_id', $initialApplication->initapp_id)->first();

        if ($initAttachment) {
            // Delete the files from storage
            $attachments = ['cert_pot', 'sanitary_survey', 'watersite_clearance', 'engineers_report', 'plans_specs'];

            foreach ($attachments as $attachment) {
                if ($initAttachment->$attachment) {
                    Storage::disk('public')->delete($initAttachment->$attachment);
                }
            }

            // Delete the attachment record
            $initAttachment->delete();
        }

        // Delete the initial application record
        $initialApplication->delete();
    }
    $facility->delete();

    return redirect()->route('initialtransact')->with('success', 'Initial Transaction has been deleted successfully!');
}
}
    


