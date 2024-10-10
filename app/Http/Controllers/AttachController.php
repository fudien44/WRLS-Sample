<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Facility;
use App\Models\opctrlno;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\InitialPermit;
use App\Models\InitAttachment;
use App\Models\OperAttachment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OperationalPermit;
use App\Models\InitialApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\OperationalApplications;
use Illuminate\Support\Facades\Storage;

class AttachController extends Controller
{
    //
    /**
     * Mark an attachment as validated.
     */
    public function validateinitAttachment(Request $request)
    {
        $request->validate([
            'attachment_id' => 'required|exists:tbl_initattachment,initattach_id',
            'field' => 'required|in:application_form,cert_pot,sanitary_survey,watersite_clearance,engineers_report,plans_specs'
        ]);

        $attachment = InitAttachment::findOrFail($request->input('attachment_id'));
        $field = $request->input('field');
        $fieldName = 'is_' . $field . '_validated';

        // Update the appropriate field
        $attachment->$fieldName = true;
        $attachment->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' approved successfully',
            'field' => $field
        ]);
    }

    /**
     * Mark an attachment as rejected.
     */
    public function rejectinitAttachment(Request $request)
    {
        $request->validate([
            'attachment_id' => 'required|exists:tbl_initattachment,initattach_id',
            'field' => 'required|in:application_form,cert_pot,sanitary_survey,watersite_clearance,engineers_report,plans_specs'
        ]);

        $attachment = InitAttachment::findOrFail($request->input('attachment_id'));
        $field = $request->input('field');
        $fieldName = 'is_' . $field . '_validated';

        // Update the appropriate field
        $attachment->$fieldName = false;
        $attachment->save();

        return response()->json([
            'success' => false,
            'message' => ucfirst(str_replace('_', ' ', $request->input('field'))) . ' rejected',
            'field' => $request->input('field')
        ]);
    }

    //operational attachment validation

    public function validateoperAttachment(Request $request)
    {
        $request->validate([
            'attachment_id' => 'required|exists:tbl_operateattachment,operattach_id',
            'field' => 'required|in:application_form,letter_intent,cert_completion,cert_pot,cert_training,xerox_init_permit'
        ]);

        $attachment = OperAttachment::findOrFail($request->input('attachment_id'));
        $field = $request->input('field');
        $fieldName = 'is_' . $field . '_validated';

        // Update the appropriate field
        $attachment->$fieldName = true;
        $attachment->save();

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' approved successfully',
            'field' => $field
        ]);
    }

    /**
     * Mark an attachment as rejected.
     */
    public function rejectoperAttachment(Request $request)
    {
        $request->validate([
            'attachment_id' => 'required|exists:tbl_operateattachment,operattach_id',
            'field' => 'required|in:application_form,letter_intent,cert_completion,cert_pot,cert_training,xerox_init_permit'
        ]);

        $attachment = OperAttachment::findOrFail($request->input('attachment_id'));
        $field = $request->input('field');
        $fieldName = 'is_' . $field . '_validated';

        // Update the appropriate field
        $attachment->$fieldName = false;
        $attachment->save();

        return response()->json([
            'success' => false,
            'message' => ucfirst(str_replace('_', ' ', $request->input('field'))) . ' rejected',
            'field' => $request->input('field')
        ]);
    }


//initial attachments controller
public function handleInitialApplicationFormUpload(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'initapp_id' => 'required|integer|exists:tbl_initapplication,initapp_id',
        'application_form' => 'required|file|mimes:pdf|max:3072', // Make it required
    ]);

    $initapp_id = $validated['initapp_id'];
    $initialApplication = InitialApplication::findOrFail($initapp_id);

    // Define the folder where the PDFs will be stored
    $facilityFolder = "attachments/initial/{$initialApplication->facilityInfo->fac_name}";

    // Retrieve the uploaded file
    $file = $request->file('application_form');

    // Optional: Delete existing file if necessary
    $existingFile = InitAttachment::where('initapp_id', $initapp_id)->value('application_form');
    if ($existingFile) {
        Storage::disk('public')->delete($existingFile);
    }

    // Store the new file
    $path = $file->store($facilityFolder, 'public');

    // Update or create the attachment entry in the database
    InitAttachment::updateOrCreate(
        ['initapp_id' => $initapp_id],
        ['application_form' => $path,
        'is_application_form_validated' => null]
    );

    return redirect()->route('initialtransact')->with('success', 'Application form uploaded successfully!');
}
public function handleReuploadInitial(Request $request)
    {

        // Validate the request
        $validated = $request->validate([
            'initapp_id' => 'required|integer|exists:tbl_initapplication,initapp_id',
            'application_form' => 'nullable|file|mimes:pdf|max:3072',
            'cert_pot' => 'nullable|file|mimes:pdf|max:3072',
            'sanitary_survey' => 'nullable|file|mimes:pdf|max:3072',
            'watersite_clearance' => 'nullable|file|mimes:pdf|max:3072',
            'engineers_report' => 'nullable|file|mimes:pdf|max:3072',
            'plans_specs' => 'nullable|file|mimes:pdf|max:3072'
        ]);

        $initapp_id = $validated['initapp_id'];
        $initialApplication = InitialApplication::findOrFail($initapp_id);
        $initialApplication->application_status = 'In Process';
        $initialApplication->save();

        // Save attachments
        $attachments = [
            'application_form',
            'cert_pot',
            'sanitary_survey',
            'watersite_clearance',
            'engineers_report',
            'plans_specs'
        ];

        $attachmentData = ['initapp_id' => $initapp_id];
        $facilityFolder = "attachments/initial/{$initialApplication->facilityInfo->fac_name}";

        foreach ($attachments as $attachment) {
            if ($request->hasFile($attachment)) {
                $existingFile = InitAttachment::where('initapp_id', $initapp_id)->value($attachment);
                if ($existingFile) {
                    Storage::disk('public')->delete($existingFile);
                }

                // Store the new file
                $file = $request->file($attachment);
                $path = $file->store($facilityFolder, 'public');
                $attachmentData[$attachment] = $path;


                 // Set the is_attachment_validated field to null
            $attachmentData['is_' . $attachment . '_validated'] = null;
            }
        }
        

        InitAttachment::updateOrCreate(['initapp_id' => $initapp_id], $attachmentData);

        return redirect()->route('initialtransact')->with('success', 'Attachments re-uploaded successfully!');
    }

    public function generatePdfinitial(Request $request, $fac_id)
    {
        
        
        // Get the authenticated user ID
        $userId = auth()->id();
        
        // Retrieve the facility and initial application data for the authenticated user
        $facility = Facility::where('user_id', $userId)->where('fac_id', $fac_id)->first();

        
        $initialApplication = InitialApplication::where('user_id', $userId)->where('fac_id', $fac_id)->first();

       
        // image path and types
        $pathbagongpilipinas = public_path() . '/images/bagong_pilipinas.png';
        $pathdoh = public_path() . '/images/doh.png';
        $pathdohsoccs = public_path() . '/images/dohsoccsksargen.png';

        $type = [
            pathinfo($pathbagongpilipinas, PATHINFO_EXTENSION),
            pathinfo($pathdoh, PATHINFO_EXTENSION),
            pathinfo($pathdohsoccs, PATHINFO_EXTENSION),
        ];

        $dataimage = [
            base64_encode(file_get_contents($pathbagongpilipinas)), 
            base64_encode(file_get_contents($pathdoh)), 
            base64_encode(file_get_contents($pathdohsoccs)), 
        ];

        $imageBagongPilipinas = 'data:image/' . $type[0] . ';base64,' . $dataimage[0];
        $imageDoh = 'data:image/' . $type[1] . ';base64,' . $dataimage[1];
        $imageDohsoccs = 'data:image/' . $type[2] . ';base64,' . $dataimage[2];
        $waterSourceTypes = [
            '1' => 'Point Source (Deep Well)',
        '2' => 'Communal Faucet System/Stand Post',
        '3' => 'Waterworks System (Water District)',
        ];
        $data = [
            // facility------------------------------------
            'fac_name' => $facility->fac_name,
            'fac_address' => $facility->fac_address,
            'owner_name' => $facility->owner_name,
            'owner_address' => $facility->owner_address,
            'telephone_number' => $facility->telephone_number,
            'area_to_serve' => $facility->area_to_serve,
            'water_source_type' => $facility->water_source_type,
            'application_status' => $initialApplication->application_status,
            'submission_date' => $initialApplication->submission_date,
            'remarks' => $initialApplication->remarks,
            'waterSourceTypes' => $waterSourceTypes,
            
           //images-----------------------------------------
            'imageBagongPilipinas' => $imageBagongPilipinas,
            'imageDoh' => $imageDoh,
            'imageDohsoccs' => $imageDohsoccs,
        ];

        
        $pdf = Pdf::loadView('print.initapplicationform', $data);
        $pdf->setPaper('a4', 'portrait');

       
        return $pdf->download('Initial Application Form.pdf');
    }

    public function generateOrderofPayment(Request $request, $fac_id)
    {
        
        
        // Get the authenticated user ID
        $userId = auth()->id();
   $userRole = Auth::user()->role_id;
        
        // $facID = $request->input('fac_id');
        // Retrieve the facility and initial application data for the authenticated user
        $facility = Facility::where('fac_id', $fac_id)
        ->when($userRole !== 4 && $userRole !== 2 && $userRole !== 3, function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        })
        ->first();
 
    if (!$facility) {
        return redirect()->back()->withErrors(['error' => 'Facility not found or unauthorized access.']);
    }
        
        // $initialApplication = InitialApplication::where('user_id', $userId)->where('fac_id', $fac_id)->first();

       
        // image path and types
        $pathbagongpilipinas = public_path() . '/images/bagong_pilipinas.png';
        $pathdoh = public_path() . '/images/doh.png';
        $pathdohsoccs = public_path() . '/images/dohsoccsksargen.png';

        $type = [
            pathinfo($pathbagongpilipinas, PATHINFO_EXTENSION),
            pathinfo($pathdoh, PATHINFO_EXTENSION),
            pathinfo($pathdohsoccs, PATHINFO_EXTENSION),
        ];

        $dataimage = [
            base64_encode(file_get_contents($pathbagongpilipinas)), 
            base64_encode(file_get_contents($pathdoh)), 
            base64_encode(file_get_contents($pathdohsoccs)), 
        ];

        $imageBagongPilipinas = 'data:image/' . $type[0] . ';base64,' . $dataimage[0];
        $imageDoh = 'data:image/' . $type[1] . ';base64,' . $dataimage[1];
        $imageDohsoccs = 'data:image/' . $type[2] . ';base64,' . $dataimage[2];
        $waterSourceTypes = [
            '1' => 'Point Source (Deep Well)',
        '2' => 'Communal Faucet System/Stand Post',
        '3' => 'Waterworks System (Water District)',
        ];
        $data = [
            // facility------------------------------------
            'fac_name' => $facility->fac_name,
            'fac_address' => $facility->fac_address,
            'owner_name' => $facility->owner_name,
            'owner_address' => $facility->owner_address,
            'telephone_number' => $facility->telephone_number,
            'area_to_serve' => $facility->area_to_serve,
            'water_source_type' => $facility->water_source_type,
            // 'application_status' => $initialApplication->application_status,
            // 'submission_date' => $initialApplication->submission_date,
            // 'remarks' => $initialApplication->remarks,
            'waterSourceTypes' => $waterSourceTypes,
            
           //images-----------------------------------------
            'imageBagongPilipinas' => $imageBagongPilipinas,
            'imageDoh' => $imageDoh,
            'imageDohsoccs' => $imageDohsoccs,
        ];

        
        $pdf = Pdf::loadView('print.order_payment.init_wrs', $data);
        $pdf->setPaper('a4', 'portrait');

       
        return $pdf->download('Order of Payment Form.pdf');
    }

    public function handlePaymentupload(Request $request)
{
    $userId = Auth::id();

    // Validate the request 
    $validated = $request->validate([
        'order_payment' => 'nullable|file|mimes:pdf|max:3072',
        'attach_OR' => 'nullable|file|mimes:pdf|max:3072',
        'fac_id' => 'required|integer',
        'initapp_id' => 'required|integer',
    ]);

    $initapp_id = $validated['initapp_id'];
        $initialApplication = InitialApplication::findOrFail($initapp_id);
        $facilityFolder = $initialApplication->facilityInfo->fac_name;
    // Retrieve or create the OrderPayment instance
    $orderPayment = OrderPayment::where('initapp_id', $request->initapp_id)->first() ?? new OrderPayment();

    // Handle order_payment file upload
    if ($request->hasFile('order_payment')) {
        $file = $request->file('order_payment');
        $path = $file->store("attachments/orderpayment/{$facilityFolder}", 'public');
        $orderPayment->order_payment = $path;
    }

    // Handle attach_OR file upload
    if ($request->hasFile('attach_OR')) {
        $file = $request->file('attach_OR');
        $path = $file->store("attachments/officialreceipt/{$facilityFolder}", 'public');
        $orderPayment->attach_OR = $path;
    }
    $initialApplication->application_status = 'In Process of Payment';
    $initialApplication->save();

    // Save the OrderPayment model
    $orderPayment->initapp_id = $request->initapp_id;
    $orderPayment->save();

    return redirect()->route('initialtransact')->with('success', 'Order of Payment uploaded successfully!');
}

public function generateInitialPermit(Request $request, $fac_id)
{
   // Get the authenticated user ID
   $userId = auth()->id();
   $userRole = Auth::user()->role_id;


   
   // Find the facility by ID, allow access for the admin or the owner
   $facility = Facility::where('fac_id', $fac_id)
       ->when($userRole !== 4 && $userRole !== 2 && $userRole !== 3, function ($query) use ($userId) {
           return $query->where('user_id', $userId);
       })
       ->first();

   if (!$facility) {
       return redirect()->back()->withErrors(['error' => 'Facility not found or unauthorized access.']);
   }

   $application = InitialApplication::where('fac_id', $fac_id)->first();

    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }
    $application->application_status = 'For Issuance';
    $application->save();

    $data = [
        'owner_address' => $facility->owner_address,
        'owner_name' => $facility->owner_name,
        'scopeOfWork' => $request->input('scope'),
    ];

    $pdf = Pdf::loadView('print.initialpermit', $data);
    return $pdf->stream('Initial_Permit.pdf');
}
public function InitialPermitupload(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'initial_permit' => 'nullable|file|mimes:pdf|max:3072',
        'initapp_id' => 'required|integer|exists:tbl_initapplication,initapp_id',
    ]);

    $initapp_id = $validated['initapp_id'];
    $initialApplication = InitialApplication::findOrFail($initapp_id);
    $facilityFolder = $initialApplication->facilityInfo->fac_name;

    // Retrieve or create the InitialPermit instance
    $initialpermit = InitialPermit::where('initapp_id', $initapp_id)->first() ?? new InitialPermit();

    // Handle initial_permit file upload
    if ($request->hasFile('initial_permit')) {
        $file = $request->file('initial_permit');

        // If there's an existing file, delete it
        if ($initialpermit->initial_permit) {
            Storage::disk('public')->delete($initialpermit->initial_permit);
        }

        // Store the new file
        $path = $file->store("attachments/initialpermit/{$facilityFolder}", 'public');
        $initialpermit->initial_permit = $path;
    }
    $initialApplication->application_status = 'Initial Permit Available';
    $initialApplication->save();
    // Save the InitialPermit model
    $initialpermit->initapp_id = $initapp_id;
    $initialpermit->save();

    return redirect()->back()->with('success', 'Initial Permit uploaded successfully!');
}

//operational Attachments methods

public function handleOperationalApplicationFormUpload(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'operateapp_id' => 'required|integer|exists:tbl_operatepplication,operateapp_id',
        'application_form' => 'required|file|mimes:pdf|max:3072', // Make it required
    ]);

    $operateapp_id = $validated['operateapp_id'];
    $operationalApplication = OperationalApplications::findOrFail($operateapp_id);

    // Define the folder where the PDFs will be stored
    $facilityFolder = "attachments/operational/{$operationalApplication->facilityInfo->fac_name}";

    // Retrieve the uploaded file
    $file = $request->file('application_form');

    // Optional: Delete existing file if necessary
    $existingFile = OperAttachment::where('operateapp_id', $operateapp_id)->value('application_form');
    if ($existingFile) {
        Storage::disk('public')->delete($existingFile);
    }

    // Store the new file
    $path = $file->store($facilityFolder, 'public');

    // Update or create the attachment entry in the database
    OperAttachment::updateOrCreate(
        ['operateapp_id' => $operateapp_id],
        ['application_form' => $path,
        'is_application_form_validated' => null]
    );

    return redirect()->route('operationaltransact')->with('success', 'Application form uploaded successfully!');
}

public function generateOperaForm(Request $request, $fac_id)
{
    
    // set_time_limit(300);
    
    // Get the authenticated user ID
    $userId = auth()->id();
    
    // $facID = $request->input('fac_id');
    // Retrieve the facility and initial application data for the authenticated user
    $facility = Facility::where('user_id', $userId)->where('fac_id', $fac_id)->first();

    // $facility = $facilities->first();
    
    $operaApplication = OperationalApplications::where('user_id', $userId)->where('fac_id', $fac_id)->first();

   
    // image path and types
    $pathbagongpilipinas = public_path() . '/images/bagong_pilipinas.png';
    $pathdoh = public_path() . '/images/doh.png';
    $pathdohsoccs = public_path() . '/images/dohsoccsksargen.png';

    $type = [
        pathinfo($pathbagongpilipinas, PATHINFO_EXTENSION),
        pathinfo($pathdoh, PATHINFO_EXTENSION),
        pathinfo($pathdohsoccs, PATHINFO_EXTENSION),
    ];

    $dataimage = [
        base64_encode(file_get_contents($pathbagongpilipinas)), 
        base64_encode(file_get_contents($pathdoh)), 
        base64_encode(file_get_contents($pathdohsoccs)), 
    ];

    $imageBagongPilipinas = 'data:image/' . $type[0] . ';base64,' . $dataimage[0];
    $imageDoh = 'data:image/' . $type[1] . ';base64,' . $dataimage[1];
    $imageDohsoccs = 'data:image/' . $type[2] . ';base64,' . $dataimage[2];
    $waterSourceTypes = [
        'water_district' => 'Water District',
        'deep_well' => 'Deep Well',
    ];
    $data = [
        // facility------------------------------------
        'fac_name' => $facility->fac_name,
        'fac_address' => $facility->fac_address,
        'owner_name' => $facility->owner_name,
        'owner_address' => $facility->owner_address,
        'telephone_number' => $facility->telephone_number,
        'latitude' => $facility->latitude,
        'longitude' => $facility->longitude,
        'area_to_serve' => $facility->area_to_serve,
        'water_source_type' => $facility->water_source_type,
        'application_status' => $operaApplication->application_status,
        'submission_date' => $operaApplication->submission_date,
        'remarks' => $operaApplication->remarks,
        'waterSourceTypes' => $waterSourceTypes,
        
       //images-----------------------------------------
        'imageBagongPilipinas' => $imageBagongPilipinas,
        'imageDoh' => $imageDoh,
        'imageDohsoccs' => $imageDohsoccs,
    ];

    
    $pdf = Pdf::loadView('print.operapplication', $data);
    $pdf->setPaper('a4', 'portrait');

   
    return $pdf->stream('Operational Application Form.pdf');
}

public function handleReuploadOperation(Request $request)
{

    // Validate the request
    $validated = $request->validate([
        'operateapp_id' => 'required|integer|exists:tbl_operatepplication,operateapp_id',
        'application_form' => 'nullable|file|mimes:pdf|max:3072',
        'letter_intent' => 'nullable|file|mimes:pdf|max:3072',
        'cert_completion' => 'nullable|file|mimes:pdf|max:3072',
        'cert_pot' => 'nullable|file|mimes:pdf|max:3072',
        'cert_training' => 'nullable|file|mimes:pdf|max:3072',
        'xerox_init_permit' => 'nullable|file|mimes:pdf|max:3072'
    ]);

    $operateapp_id = $validated['operateapp_id'];
    $operationalApplication = OperationalApplications::findOrFail($operateapp_id);
    $operationalApplication->application_status = 'In Process';
    $operationalApplication->save();


    // Save attachments
    $attachments = [
            'application_form',
        'letter_intent',
        'cert_completion',
        'cert_pot',
        'cert_training',
        'xerox_init_permit'
    ];

    $attachmentData = ['operateapp_id' => $operateapp_id];
    $facilityFolder = "attachments/operational/{$operationalApplication->facilityInfo->fac_name}";

    foreach ($attachments as $attachment) { 
        if ($request->hasFile($attachment)) {
            $existingFile = OperAttachment::where('operateapp_id', $operateapp_id)->value($attachment);
            if ($existingFile) {
                Storage::disk('public')->delete($existingFile);
            }

            // Store the new file
            $file = $request->file($attachment);
            $path = $file->store($facilityFolder, 'public');
            $attachmentData[$attachment] = $path;

             // Set the is_attachment_validated field to null
             $attachmentData['is_' . $attachment . '_validated'] = null;
        }
    }
    

    OperAttachment::updateOrCreate(['operateapp_id' => $operateapp_id], $attachmentData);

    return redirect()->route('operationaltransact')->with('success', 'Attachments re-uploaded successfully!');
}

public function generateOperationalPermit(Request $request, $fac_id)
{


$userId = auth()->id();
$userRole = Auth::user()->role_id;
$application = OperationalApplications::where('fac_id', $fac_id)->first();

$facility = Facility::where('fac_id', $fac_id)
->when($userRole !== 4, function ($query) use ($userId) {
   return $query->where('user_id', $userId);
})
->first();

if (!$facility) {
return redirect()->back()->withErrors(['error' => 'Facility not found.']);
}
if (!$application) {
return redirect()->back()->withErrors(['error' => 'Application not found.']);
}


$currentYear = Carbon::now()->year;

// Retrieve or generate the control number
$controlNumber = opctrlno::firstOrCreate(
['fac_id' => $facility->fac_id, 'year' => $currentYear],
['number' => opctrlno::where('year', $currentYear)->max('number') + 1]
);
// Format the control number as YYYY-0000
$formattedControlNumber = sprintf('%04d-%04d', $controlNumber->year, $controlNumber->number);



$application->operatectrl_no =$formattedControlNumber;
$application->save();



// image path and types
$pathbagongpilipinas = public_path() . '/images/bagong_pilipinas.png';
$pathdoh = public_path() . '/images/doh.png';
$pathdohsoccs = public_path() . '/images/dohsoccsksargen.png';

$type = [
 pathinfo($pathbagongpilipinas, PATHINFO_EXTENSION),
 pathinfo($pathdoh, PATHINFO_EXTENSION),
 pathinfo($pathdohsoccs, PATHINFO_EXTENSION),
];

$dataimage = [
 base64_encode(file_get_contents($pathbagongpilipinas)), 
 base64_encode(file_get_contents($pathdoh)), 
 base64_encode(file_get_contents($pathdohsoccs)), 
];

$imageBagongPilipinas = 'data:image/' . $type[0] . ';base64,' . $dataimage[0];
$imageDoh = 'data:image/' . $type[1] . ';base64,' . $dataimage[1];
$imageDohsoccs = 'data:image/' . $type[2] . ';base64,' . $dataimage[2];

$data = [
    'fac_name' => $facility->fac_name,
    'fac_address' => $facility->fac_address,
    'owner_name' => $facility->owner_name,
    'owner_address' => $facility->owner_address,
    'area_to_serve' => $facility->area_to_serve,
    'water_source_type' => $facility->water_source_type,
    'waterSourceTypes' => [
        '1' => 'Point Source (Deep Well)',
        '2' => 'Communal Faucet System/Stand Post',
        '3' => 'Waterworks System (Water District)',
    ],
    'imageBagongPilipinas' => $imageBagongPilipinas,
        'imageDoh' => $imageDoh,
        'imageDohsoccs' => $imageDohsoccs,
        'controlNumber' => $formattedControlNumber,
        'population' => $request->input('population'),
        'lots' => $request->input('lots'),


];


$pdf = Pdf::loadView('print.operationalpermit', $data);
return $pdf->stream('Operational Permit.pdf');
}

public function operationalPermitupload(Request $request)
{
$validated = $request->validate([
    'operatectrl_no' => 'nullable',
    'operate_permit' => 'nullable|file|mimes:pdf|max:3072',
    'operateapp_id' => 'required|integer|exists:tbl_operatepplication,operateapp_id',
]);

$operateapp_id = $validated['operateapp_id'];
$operationApplication = OperationalApplications::findOrFail($operateapp_id);
$facilityFolder = $operationApplication->facilityInfo->fac_name;

$operationalpermit = OperationalPermit::where('operateapp_id', $operateapp_id)->first() ?? new OperationalPermit();


if ($request->hasFile('operate_permit')) {
    $file = $request->file('operate_permit');


    if ($operationalpermit->operate_permit) {
        Storage::disk('public')->delete($operationalpermit->operate_permit);
    }

    $path = $file->store("attachments/operationalpermit/{$facilityFolder}", 'public');


    $operationalpermit->operate_permit = $path;
}

$operationalpermit->operateapp_id = $operateapp_id;
$operationalpermit->save();

return redirect()->back()->with('success', 'Operational Permit uploaded successfully!');
}


}
