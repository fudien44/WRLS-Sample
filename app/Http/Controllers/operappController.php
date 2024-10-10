<?php

namespace App\Http\Controllers;

use App\Models\opctrlno;
use Carbon\Carbon;
use App\Models\Facility;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\OperAttachment;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\Clock\now;
use App\Models\OperationalPermit;
use Illuminate\Support\Facades\Auth;
use App\Models\OperationalApplications;
use Illuminate\Support\Facades\Storage;

class operappController extends Controller
{
    public function showForm()
    {
        // $fac_name = Facility::all();
        $fac_name = Facility::where('initial_permit', 1)->where('user_id', auth()->id())->get();
        return view('operational.operational_wrs', compact('fac_name'));
    }

    public function indextable()
    {
        $user = Auth::user();

    $isAdmin = $user->role_id === 4;

    $dataoperQuery = Facility::with(['operateApplication.operattach'])
        ->where('tbl_facility.initial_permit', 1)
        ->join('tbl_operatepplication', 'tbl_facility.fac_id', '=', 'tbl_operatepplication.fac_id');
        

    if (!$isAdmin) {
        $dataoperQuery->where('tbl_facility.user_id', $user->user_id);
    }

    $dataoper = $dataoperQuery->orderBy('tbl_operatepplication.submission_date', 'desc')->get();

    $operaAttachmentQuery = OperAttachment::with(['operateApplication.facilityInfo'])
        ->join('tbl_operatepplication', 'tbl_operateattachment.operateapp_id', '=', 'tbl_operatepplication.operateapp_id')
        ->join('tbl_facility', 'tbl_operatepplication.fac_id', '=', 'tbl_facility.fac_id');

    if (!$isAdmin) {
        $operaAttachmentQuery->where('tbl_facility.user_id', $user->user_id);
    }

    $operaAttachment = $operaAttachmentQuery->get();

     $dataOperationPermitQuery = OperationalPermit::with(['operateApplication.facilityInfo'])
     ->join('tbl_operatepplication', 'tbl_operationalpermit.operateapp_id', '=', 'tbl_operatepplication.operateapp_id');
    


 $dataOperationPermit = $dataOperationPermitQuery->get();

    $waterSourceTypes = [
        '1' => 'Point Source (Deep Well)',
        '2' => 'Communal Faucet System/Stand Post',
        '3' => 'Waterworks System (Water District)',
    ];

    // Pass data to the view
    return view('/transaction/transact_oper', compact('dataoper', 'waterSourceTypes', 'operaAttachment', 'dataOperationPermit'));
    }

    public function handleForm(Request $request)
    {

        $userId = auth()->id();
        // Validate form data
        $validated = $request->validate([
            'facility_type' => 'required',
            'facility_id' => 'required_if:facility_type,existing',
            'fac_name' => 'required_if:facility_type,new|string|max:255',
        'fac_address' => 'required_if:facility_type,new|string|max:255',
        'owner_name' => 'required_if:facility_type,new|string|max:255',
        'owner_address' => 'required_if:facility_type,new|string|max:255',
        'telephone_number' => 'nullable|string|max:15',
        'area_to_serve' => 'required_if:facility_type,new|string|max:255',
        'water_source_type' => 'required_if:facility_type,new|string',
        'letter_intent' => 'nullable|file|mimes:pdf|max:3072',
        'cert_completion' => 'nullable|file|mimes:pdf|max:3072',
        'cert_pot' => 'nullable|file|mimes:pdf|max:3072',
        'cert_training' => 'nullable|file|mimes:pdf|max:3072',
        'xerox_init_permit' => 'nullable|file|mimes:pdf|max:3072'
           
        ]);

      

        // Determine if it's an existing or new facility
    $isExisting = $request->input('facility_type') === 'existing';

    if ($isExisting) {
        // Find the existing facility using the provided ID
        $facility = Facility::findOrFail($request->input('facility_id'));
        $facility->update([
            'fac_name' => $validated['fac_name'],
            'fac_address' => $validated['fac_address'],
            'owner_name' => $validated['owner_name'],
            'owner_address' => $validated['owner_address'],
            'telephone_number' => $validated['telephone_number'],
            'area_to_serve' => $validated['area_to_serve'],
            'water_source_type' => $validated['water_source_type'],
        ]);
    } else {
        // Create a new facility record
        $facility = Facility::create([
            'user_id' => $userId,
            'fac_name' => $validated['fac_name'],
            'fac_address' => $validated['fac_address'],
            'owner_name' => $validated['owner_name'],
            'owner_address' => $validated['owner_address'],
            'telephone_number' => $validated['telephone_number'],
            'area_to_serve' => $validated['area_to_serve'],
            'water_source_type' => $validated['water_source_type'],
            'initial_permit' => 1,
            'operation_permit' => 0,
        ]);
    }
    

        // Create OperationalApplication record
        $operateApplication = OperationalApplications::create([
            'fac_id' => $isExisting ? $request->input('facility_id') : $facility->fac_id,
            'user_id' => $userId,
            'submission_date' => now(),
            'remarks' => $request->remarks,
            'application_status' => 'In Process',
            // Add other required fields with default or null values
        ]);

        if (!$operateApplication) {
            return redirect()->route('operationaltransact')->with('error', 'Failed to create Operational Application!');
        }

        // Save attachments
        $attachments = [
            'letter_intent',
            'cert_completion',
            'cert_pot',
            'cert_training',
            'xerox_init_permit'
            
        ];

        $attachmentData = ['operateapp_id' => $operateApplication->operateapp_id];

        $facilityFolder = "attachments/operational/{$facility->fac_name}";

        foreach ($attachments as $attachment) {
            if ($request->hasFile($attachment)) {
                $file = $request->file($attachment);
                $path = $file->store($facilityFolder, 'public');

                $attachmentData[$attachment] = $path;
            }
        }
        if (empty($attachmentData)) {
            return redirect()->route('operationaltransact')->with('error', 'No attachments found to save!');
        }

        OperAttachment::create($attachmentData);

        // return response()->json(['success' => true, 'message' => 'Form saved successfully!']);
        return redirect()->route('operationaltransact')->with('success', 'Operational Application Form saved successfully!');
    }

    public function delete($fac_id)
    {
        $userId = Auth::id();
    $userRole = Auth::user()->role_id;

    // Find the facility by ID
    $facility = Facility::where('fac_id', $fac_id)
        ->when($userRole !== 4, function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        })
        ->first();

    if (!$facility) {
        return redirect()->back()->withErrors(['error' => 'Facility not found.']);
    }


    // Find related initial application
    $operationalApplication = OperationalApplications::where('fac_id', $fac_id)->first();

    if ($operationalApplication) {
        // Find and delete related order payments
      
        // Find and delete related attachments
        $operAttachment = OperAttachment::where('operateapp_id', $operationalApplication->operateapp_id)->first();

        if ($operAttachment) {
            // Delete the files from storage
            $attachments = ['letter_intent', 'cert_completion', 'cert_pot', 'cert_training', 'xerox_init_permit'];

            foreach ($attachments as $attachment) {
                if ($operAttachment->$attachment) {
                    Storage::disk('public')->delete($operAttachment->$attachment);
                }
            }

            // Delete the attachment record
            $operAttachment->delete();
        }

        // Delete the operational application record
        $operationalApplication->delete();
    }

    // Finally, delete the facility
    // $facility->delete();

    return redirect()->route('operationaltransact')->with('success', 'Operational Transaction has been deleted successfully!');
    }

}
