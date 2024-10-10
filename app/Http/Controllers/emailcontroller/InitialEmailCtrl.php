<?php

namespace App\Http\Controllers\emailcontroller;


use App\Mail\ClientEmail;
use Illuminate\Http\Request;
use App\Models\InitialApplication;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\InitAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InitialEmailCtrl extends Controller
{
    //
    public function reattachEmail(Request $request)
    {
//    $remarks = $request->input('reject_remarks');
   $fac_id = $request->input('fac_id');

   $application = InitialApplication::where('fac_id', $fac_id)->first();

   if (!$application) {
       return redirect()->back()->with('error', 'Application not found.');
   }

   $clientEmail = $application->user->email;

   $attachment = InitAttachment::where('initapp_id', $application->initapp_id)->first();

   if ($attachment) {
       $attachment->is_validated = 0; 
       $attachment->save();
   }

//    $application->reject_remarks = $remarks;
   $application->application_status = 'For Reattachment';
   $application->save();

   $details = [
       'subject' => 'Application Rejected',
       'title' => 'Requirements',
       'body' => "We regret to inform you that you did not pass the evaluation due to the following reason(s):\n\nPlease review and reattach the required documents at your earliest convenience.\n\nThank you for your attention."
   ];

   Mail::to($clientEmail)->send(new ClientEmail($details));

   return redirect()->route('initialtransact')->with('success', 'Email sent successfully!');
    }

    public function paymentEmail(Request $request)
    {
    $fac_id = $request->input('fac_id');

    $application = InitialApplication::where('fac_id', $fac_id)->first();

    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    $clientEmail = $application->user->email;

    $attachment = InitAttachment::where('initapp_id', $application->initapp_id)->first();

    if ($attachment) {
        $attachment->is_validated = 1;
        $attachment->save();
    }

    $application->application_status = 'For Payment';
    $application->save();

    $details = [
        'subject' => 'Order of Payment',
        'title' => 'Good Day!',
        'body' => "We are glad to inform you that you have passed our evaluation of your requirements.\n\nYou may now be able to download your Order of Payment on the website:\n\nAfter logging in, go to:\n\nInitial Transaction List -> Download -> Order of Payment\n\nKindly do the payments directly at our cashier section and upload the Official Receipt and signed Order of Payment at our website.\n\nThank you"
    ];

    Mail::to($clientEmail)->send(new ClientEmail($details));

    return redirect()->route('initialtransact')->with('success', 'Updated Status and Email sent successfully!');
    }
    public function paymentInspection(Request $request)
    {
    $fac_id = $request->input('fac_id'); // Retrieve fac_id from the request

    // Find the initial application using fac_id
    $application = InitialApplication::where('fac_id', $fac_id)->first();
    // Check if the application exists
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }
    $clientEmail = $application->user->email;
   
    $application->acceptance_date = now();
    $application->application_status = 'For Scheduling';
    $application->is_paid = 1;
    $application->save();

       
        $details = [
            'subject' => 'Subject for Scheduling of Inspection',
            'title' => 'Good Day!',
            'body' => "We are glad to inform you that your application is now ready for inspection.\n\nThank you"
        ];

        Mail::to($clientEmail)->send(new ClientEmail($details));

        return redirect()->route('initialtransact')->with('success', 'Email sent successfully!');
    }
    public function issuanceEmail(Request $request)
    {
        $fac_id = $request->input('fac_id'); // Retrieve fac_id from the request

    // Find the initial application using fac_id
    $application = InitialApplication::where('fac_id', $fac_id)->first();
    // Check if the application exists
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }
        $clientEmail = $application->user->email;

        $application->application_status = 'For Issuance';
        $application->save();

        $details = [
            'subject' => 'Subject for Issuance of Permit',
            'title' => 'Good day!',
            'body' => "Your application status is currently undergoing the issuance of your Permit. \n\n We will get back to you for the availability of your Permit. \n\nThank you"
        ];

        Mail::to($clientEmail)->send(new ClientEmail($details));

        return redirect()->route('initialtransact')->with('success', 'Email sent successfully!');
    }
    public function initialpermit(Request $request)
    {
        $fac_id = $request->input('fac_id'); 
    
        $application = InitialApplication::where('fac_id', $fac_id)->first();
        $facility = Facility::where('fac_id', $fac_id)->first();

        if (!$application || !$facility) {
            return redirect()->route('initialtransact')->with('error', 'Facility or Application not found.');
        }

        $clientEmail = $application->user->email;


        $facility->initial_permit = 1;
        $facility->save();

        $application->application_status = 'Initial Permit Available';
        $application->save();
       
        $details = [
            'subject' => 'Available Initial Permit',
            'title' => 'Congratulations',
            'body' => "You may now be able to get your Initial Permit at the DOH CHD XII Office. \n\nThank you"
        ];

        Mail::to($clientEmail)->send(new ClientEmail($details));

        return redirect()->route('initialtransact')->with('success', 'Updated Application Status and Email sent successfully!');
    }

}
