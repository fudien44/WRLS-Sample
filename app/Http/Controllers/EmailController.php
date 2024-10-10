<?php

namespace App\Http\Controllers;

use App\Mail\SampleEmail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationNotificationEmail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'application_status' => 'required',
            'application_type'=>'required',
            'reject_remarks' => 'nullable',
            'inspection_date' => 'nullable|string',
            'inspector_date_rejected' => 'nullable|string'
        ]);

        $recipient = $validatedData['email']; // Change to the recipient's email address
        // $recipient = 'blabla@gmail.com';

        $emailSent = Mail::to($recipient)->send(new ApplicationNotificationEmail($validatedData['name'], $validatedData['email'], $validatedData['application_status'], $validatedData['application_type'], $validatedData['reject_remarks'], $request->inspection_date != "" ? $validatedData['inspection_date'] : "", $request->inspector_date_rejected != "" ? $validatedData['inspector_date_rejected'] : ""));

        if ($emailSent instanceof \Illuminate\Mail\SentMessage) {
            return response()->json(['message' => 'Email sent successfully to ' . $recipient]);
        } else {
            return response()->json(['message' => 'Email was not sent successfully to ' . $recipient]);
        }
    }
}
