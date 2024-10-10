<?php

namespace App\Http\Controllers;

use App\Models\OperAttachment;
use PDO;
use File;
use Illuminate\Http\Request;
use App\Models\InitAttachment;
use GuzzleHttp\Promise\Promise;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{
    public function getInitAttachment($id)
    {
        $initattachments = InitAttachment::where('initapp_id', $id)->first();
        if ($initattachments) {
            return response()->json([
                'status' => 200,
                'message' => $initattachments
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Error with retrieving the attachments from the database'
            ]);
        }
        // foreach ($initattachments as $initattachment) {
        //     if ($initattachment->initapp_id == $id) {
        //         $result = $initattachment;
        //         break;
        //     }
        // }

        // if (isset($result)) {
        //     return response()->json([
        //         'status' => 200,
        //         'message' => $result
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'Error with retrieving the attachments from the database'
        //     ]);
        // }
    }
    public function getOpAttachment($id)
    {
        $operattachments = OperAttachment::where('operateapp_id', $id)->first();
        if ($operattachments) {
            return response()->json([
                'status' => 200,
                'message' => $operattachments
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Error with retrieving the attachments from the database'
            ]);
        }
        // foreach ($initattachments as $initattachment) {
        //     if ($initattachment->initapp_id == $id) {
        //         $result = $initattachment;
        //         break;
        //     }
        // }

        // if (isset($result)) {
        //     return response()->json([
        //         'status' => 200,
        //         'message' => $result
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'Error with retrieving the attachments from the database'
        //     ]);
        // }
    }

    public function getAttachments(Request $request)
    {
        $initapp_id=$request->initapp_id;
        $opapp_id = $request->opapp_id;

        $initattachments = InitAttachment::where('initapp_id', $initapp_id)->first();

        $operattachments = OperAttachment::where('operateapp_id', $opapp_id)->first();

        $data = ["initattachment"=>$initattachments, "operattachment"=> $operattachments];

        if($initapp_id){
            $initchecklist = DB::table('tbl_facinspect')
            ->join('tbl_initapplication', 'tbl_facinspect.inspection_id', 'tbl_initapplication.inspection_id')
            ->select('tbl_facinspect.inspection_form')
            ->whereRaw('tbl_initapplication.initapp_id = ?', $initapp_id)
            ->first();
            $data["initchecklist"]=$initchecklist->inspection_form;
        }

        if($opapp_id){
            $operchecklist = DB::table('tbl_facinspect')
            ->join('tbl_operatepplication', 'tbl_facinspect.inspection_id', 'tbl_operatepplication.inspection_id')
            ->select('tbl_facinspect.inspection_form')
            ->whereRaw('tbl_operatepplication.operateapp_id = ?', $opapp_id)
            ->first();
            $data["operchecklist"]=$operchecklist->inspection_form;
        }

        return response()->json([
            'status' => 200,
            'message' => $data
        ]);
    }

    // public function viewInitAttachment(Request $request)
    // {
    //     // return response()->json([
    //     //     'status'=>200,
    //     //     'message'=>'Ok'
    //     // ]);
    //     $attachment = $request->input('attachment');

    //     // return response()->json([
    //     //     'status'=>200,
    //     //     'message'=>$attachment
    //     // ]);

    //     // return redirect()->route('/testing/viewtestfile')->with(['attachment'=>$attachment]);
    //     return view('/testing/viewtestfile', ['filePath' => $attachment]);
    // }
}
