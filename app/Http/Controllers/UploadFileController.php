<?php

namespace App\Http\Controllers;

use File;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InitAttachment;
use App\Models\InitialApplications;

class UploadFileController extends Controller
{
    function upload()
    {
        return view('/testing/uploadfile');
    }

    function uploadPost(Request $request)
    {
        $initapp_id = 10001;

        $request->validate([
            'file' => 'required|mimes:pdf|extensions:pdf|max:3072',
        ]);

        $initapplication = InitialApplications::with('client')->find($initapp_id);
        $userprofile = UserProfile::with('useraccount')->find($initapplication['user_id']);

        $file = $request->file("file");
        $changedName = Str::replaceArray(' ', ['_'], $userprofile['firstname'] . '_' . $userprofile['mi'] . '_' . $userprofile['lastname']);
        $path = "upload" . '\\' . $changedName;


        if (!file_exists($path)) {
            File::makeDirectory($path);
            $file->move($path . '/', $file->getClientOriginalName());
            $request['letter'] = $path . '\\' . ($file->getClientOriginalName());
        } else {
            $file->move($path . '/', ($changedName . '-' . $file->getClientOriginalName()));
            $request['letter'] = $path . '\\' . ($changedName . '-' . $file->getClientOriginalName());
        }

        $request['initapp_id'] = $initapp_id;
        $request['application_form'] = null;
        $request['cert_pot'] = null;
        $request['sanitary_survey'] = null;
        $request['watersite_clearance'] = null;
        $request['engineers_report'] = null;
        $request['plans_specs'] = null;

        $validatedData = $request->validate([
            'initapp_id' => 'required|int|unique:tbl_initattachment,initapp_id',
            'letter' => 'string|nullable',
            'application_form' => 'nullable',
            'cert_pot' => 'nullable',
            'sanitary_surver' => 'nullable',
            'watersite_clearance' => 'nullable',
            'engineers_report' => 'nullable',
            'plans_specs' => 'nullable',
        ]);

        // $initattachment = new InitAttachment([
        //     'initapp_id' => $validatedData['$initapp_id'],
        //     'letter' => $validatedData['$letter'],
        //     'application_form' => $validatedData['$application_form'],
        //     'cert_pot' => $validatedData['$cert_pot'],
        //     'sanitary_survey' => $validatedData['$initapp_id'],
        //     'watersite_clearance' => $validatedData['$initapp_id'],
        //     'engineers_report' => $validatedData['$initapp_id'],
        //     'plans_specs' => $validatedData['$initapp_id'],
        // ]);

        // $check_initattachmendID = InitAttachment::where('initapp_id', $initattachment['$initapp_id']);
        // if ($check_initattachmendID) {
        //     echo "Continued the transaction";
        // } else {
            // echo $validatedData['initapp_id'];
        // }


        if ($initapplication) {
            // echo $file->getClientOriginalName();
            InitAttachment::create($validatedData);
            // InitAttachment::save($initattachment);
            // $initattachment->save();
            echo "Successfully saved attachment";
            // return redirect('/uploadfile');

        } else {
            echo "Failed to save initial attachment";
        }
    }
}
