<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use App\Models\InitAttachment;
use App\Models\OperAttachment;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function showTable()
    {
       
        $user = Auth::user();
        

        $datainitial = Facility::with(['initialApplication.initAttach'])
            ->where('tbl_facility.user_id', $user->user_id)
            ->join('tbl_initapplication', 'tbl_facility.fac_id', '=', 'tbl_initapplication.fac_id')
            ->orderBy('tbl_initapplication.submission_date', 'desc')
            ->paginate(5);

        $dataAttachment = InitAttachment::with(['initialApplication.facilityInfo'])
        ->join('tbl_initapplication', 'tbl_initattachment.initapp_id', '=', 'tbl_initapplication.initapp_id')
        ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id')
        ->where('tbl_facility.user_id', $user->user_id)
        ->get();

        $dataopera = Facility::with(['operateApplication.operattach'])
            ->where('tbl_facility.user_id', $user->user_id)
            ->where('tbl_facility.initial_permit', 1)
            ->join('tbl_operatepplication', 'tbl_facility.fac_id', '=', 'tbl_operatepplication.fac_id')
            ->orderBy('tbl_operatepplication.submission_date', 'desc')
            ->paginate(5);

        $operaAttachment = OperAttachment::with(['operateApplication.facilityInfo'])
        ->join('tbl_operatepplication', 'tbl_operateattachment.operateapp_id', '=', 'tbl_operatepplication.operateapp_id')
        ->join('tbl_facility', 'tbl_operatepplication.fac_id', '=', 'tbl_facility.fac_id')
        ->where('tbl_facility.user_id', $user->user_id)
        ->get();

        $waterSourceTypes = [
            'water_district' => 'Water District',
            'deep_well' => 'Deep Well',
        ];

        // Pass data to the view
        return view('/transaction_list', compact('datainitial','dataAttachment', 'waterSourceTypes', 'operaAttachment', 'dataopera'));
    }
}
