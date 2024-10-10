<?php

namespace App\Http\Controllers\emailcontroller;

use App\Mail\ClientEmail;
use App\Models\Facility;
use App\Models\OperationalApplications;
use App\Models\OperAttachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OperationalEmailCtrl extends Controller
{
    public function reattachEmail(Request $request)
    {
        // $remarks = $request->input('reject_remarks'); // Retrieve the remarks input
        $fac_id = $request->input('fac_id'); // Retrieve fac_id from the request
    
        // Find the initial application using fac_id
        $application = OperationalApplications::where('fac_id', $fac_id)->first();
        // Check if the application exists
        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        $clientEmail = $application->user->email;



        $attachment = OperAttachment::where('operateapp_id', $application->operateapp_id)->first();

         if ($attachment) {
            $attachment->is_validated = 0;
            $attachment->save();
        }
        // $application->reject_remarks = $remarks;
        $application->application_status = 'For Reattachment';
        $application->save();
    
    
            $details = [
                'subject' => 'Application for Operational: Reject Application',
                'title' => 'Application for Operational Missing Requirements',
                'body' => "We regret to inform you that you did not pass the evaluation due to:\n\nPlease review the changes at your earliest convenience.\n\nThank you for your attention."
            ];
    
            Mail::to($clientEmail)->send(new ClientEmail($details));
    
            return redirect()->route('operationaltransact')->with('success', 'Update Application Status and Email sent successfully!');
    }

    public function forInspection(Request $request)
    {
    $fac_id = $request->input('fac_id'); // Retrieve fac_id from the request

    $application = OperationalApplications::where('fac_id', $fac_id)->first();
    echo($application);
    
    // Check if the application exists
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }
    $clientEmail = $application->user->email;
    $attachment = OperAttachment::where('operateapp_id', $application->operateapp_id)->first();
   
    if ($attachment) {
        $attachment->is_validated = 1;
        $attachment->save();
    }
   
   
    $application->acceptance_date = now();
    $application->application_status = 'For Scheduling';
    $application->save();

       
        $details = [
            'subject' => 'Operational: Subject for Scheduling of Inspection',
            'title' => 'Good Day!',
            'body' => "We are glad to inform you that your application is now ready for inspection.\n\nThank you"
        ];

        Mail::to($clientEmail)->send(new ClientEmail($details));

        return redirect()->route('operationaltransact')->with('success', 'Update Application Status and Email sent successfully!');
    }
    public function issuanceEmail(Request $request)
    {
        $fac_id = $request->input('fac_id');
        $application = OperationalApplications::where('fac_id', $fac_id)->first();
        
        $clientEmail = $application->user->email;

        $application->application_status = 'For Issuance';
        $application->save();

        $details = [
            'subject' => 'Subject for Issuance of Permit',
            'title' => 'Good day!',
            'body' => "Your application status is currently undergoing the issuance of your Permit. \n\n We will get back to you for the availability of your Permit. \n\nThank you"
        ];

        Mail::to($clientEmail)->send(new ClientEmail($details));

        return redirect()->route('operationaltransact')->with('success', 'Update Application Status and Email sent successfully!');
    }

    public function operationalpermit(Request $request)
    {
        $fac_id = $request->input('fac_id'); 
        $application = OperationalApplications::where('fac_id', $fac_id)->first();
        $facility = Facility::where('fac_id', $fac_id)->first();
        $clientEmail = $application->user->email;

        $facility->operation_permit = 1;
        $facility->save();

        $application->application_status = 'Operational Permit Available';
        $application->save();
       
        $details = [
            'subject' => 'Available Operational Permit',
            'title' => 'Congratulations',
            'body' => "You may now be able to get your Operational Permit at the DOH CHD XII Office. \n\nThank you"
        ];

        Mail::to($clientEmail)->send(new ClientEmail($details));

        return redirect()->route('operationaltransact')->with('success', 'Update Application Status and Email sent successfully!');
    }
    //
}
