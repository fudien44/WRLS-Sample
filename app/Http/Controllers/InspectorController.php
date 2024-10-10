<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\UserProfile;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FacilityInspection;
use App\Models\InitialApplication;
use Illuminate\Support\Facades\DB;
use App\Models\InitialApplications;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\OperationalApplications;
use Illuminate\Support\Facades\Session;

class InspectorController extends Controller
{
    public function index()
    {
        $data = InitialApplication::with('user')->get();

        $compactdata = compact('data');

        $opapps = OperationalApplications::with('user')->get();
        // return view('inspector', ['initapps' => $initapps, 'opapps'=>$opapps]);
        // return view('inspector', ['initapps' => $initapps]);
        // $initapps = InitialApplication::all();
        // return $initapps->toJson();
        return $compactdata;
    }

    //Retrieve inital application to display in its own DataTable
    public function initapps()
    {
        // $data = InitialApplication::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $data = InitialApplication::with('Client')->get();
        // $initapplication = InitialApplication::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $userprofile = UserProfile::with('UserAccount');
        $data = DB::table('users')
            ->join('tbl_initapplication', 'users.user_id', '=', 'tbl_initapplication.user_id')
            ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'users.gender', 'users.email', 'tbl_initapplication.*', 'tbl_facility.*')
            ->whereRaw('LOWER(`application_status`) LIKE ? and is_paid = ?', [trim(strtolower('For scheduling')) . '%', 1])
            // ->orWhereRaw('LOWER(`application_status`) LIKE ? and is_paid = ?', [trim(strtolower('Failed inspection')) . '%', 1])
            ->orWhereRaw('LOWER(`application_status`) LIKE ? and is_paid = ?', [trim(strtolower('For reinspection')) . '%', 1])
            ->orWhereRaw('LOWER(`application_status`) LIKE ? and is_paid = ?', [trim(strtolower('pending')) . '%', 0])
            ->get();
        return compact('data');
    }

    //Update the application status or remarks of the initial application record
    public function setInitAppInspection(Request $request, $id)
    {

        $initFacility = InitialApplication::find($id);

        //To check whether the facility with the provided id exists
        if ($initFacility) {

            $incomingFields = $request->validate([
                'application_status' => 'required',
                'inspection_date' => 'required',
                'inspector_name' => 'required',
            ]);

            //Checks whether the application has a prior inspection record or not
            //If it doesn't, it creates an entirely new inspection record in the facinspect table
            if ($initFacility->inspection_id == null || $initFacility->inspection_id == '') {
                $inspectiondata = [
                    'fac_id' => $initFacility->fac_id,
                    'inspector_name' => $incomingFields['inspector_name'],
                    'inspection_date' => $incomingFields['inspection_date'],
                    'inspection_status' => 'Pending Inspection',
                    'reinspection_status' => null,
                    'reinspection_date' => null,
                    'inspection_form' => null,
                    'inspection_type' => 'Initial Inspection',
                    'reject_remarks' => null,
                ];

                //To save the data inside the database
                $facilityinspection = FacilityInspection::create($inspectiondata);

                $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);

                $initFacility->application_status = $incomingFields['application_status'];
                $initFacility->late_remarks = $request['late_remarks'];
                $initFacility->late_date = $request['late_date'];
                $initFacility->inspection_id = $facilityinspection->inspection_id != '' || $facilityinspection->inspection_id != null ? $facilityinspection->inspection_id : null;
                $initFacility->inspector_date_action = Carbon::now()->format('Y-m-d');

                $initFacility->save();

                return response()->json([
                    'status' => 200,
                    // 'message'=>$facilityinspection->inspection_id
                    'message' => 'Facility status updated successfully',
                ]);
            }
            //If it does have a prior inspection record, it will check whether it needs to categorize it as a
            // reinspection type or create an entirely new record in the facinspect table
            else {

                $incomingFields = $request->validate([
                    'application_status' => 'required',
                    'inspection_date' => 'required',
                    'inspector_name' => 'required',
                    'reinspection_date' => 'required'
                ]);

                $facilityinspection = FacilityInspection::find($initFacility->inspection_id);

                //This one updates the old inspection record and adds a reinspection date
                if ($facilityinspection->reinspection_date == null || $facilityinspection->reinspection_date == '') {

                    $inspectiondata = [
                        'inspection_id' => $initFacility->inspection_id,
                        'fac_id' => $initFacility->fac_id,
                        'inspector_name' => $incomingFields['inspector_name'],
                        'inspection_status' => 'Failed Inspection',
                        'reinspection_status' => 'Pending Reinspection',
                        'reinspection_date' => $incomingFields['reinspection_date'],
                        'inspection_form' => null,
                        'inspection_type' => 'Reinspection',
                        'reject_remarks' => null,
                    ];

                    //To save the data inside the database
                    $facilityinspection->update($inspectiondata);

                    $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);

                    $initFacility->application_status = $incomingFields['application_status'];
                    $initFacility->late_remarks = $request['late_remarks'];
                    $initFacility->late_date = $request['late_date'];
                    $initFacility->inspector_date_reaction = Carbon::now()->format('Y-m-d');

                    $initFacility->save();

                    return response()->json([
                        'status' => 200,
                        // // 'message'=>$incomingFields['reinspection_date']
                        'message' => 'Inspection date saved successfully',
                    ]);
                }
                //This one assigns a new inspection id to this application
                else {
                    $incomingFields = $request->validate([
                        'application_status' => 'required',
                        'inspection_date' => 'required',
                        'inspector_name' => 'required',
                    ]);

                    $inspectiondata = [
                        'fac_id' => $initFacility->fac_id,
                        'inspector_name' => $incomingFields['inspector_name'],
                        'inspection_date' => $incomingFields['inspection_date'],
                        'inspection_status' => 'Pending Inspection',
                        'reinspection_status' => null,
                        'reinspection_date' => null,
                        'inspection_form' => null,
                        'inspection_type' => 'Initial Inspection',
                        'reject_remarks' => null,
                    ];

                    //To save the data inside the database
                    $facilityinspection = FacilityInspection::create($inspectiondata);

                    $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);

                    $initFacility->application_status = $incomingFields['application_status'];
                    $initFacility->late_remarks = $request['late_remarks'];
                    $initFacility->late_date = $request['late_date'];
                    $initFacility->inspection_id = $facilityinspection->inspection_id != '' || $facilityinspection->inspection_id != null ? $facilityinspection->inspection_id : null;

                    $initFacility->save();

                    return response()->json([
                        'status' => 200,
                        // 'message'=>$facilityinspection->inspection_id
                        'message' => 'Inspection date saved successfully',
                    ]);
                }
            }

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Failed to update facility status. Facility ID currently does not exist in the list for review.',
            ]);
        }
    }

    public function rejectInitAppInspection(Request $request, $id)
    {

        $initFacility = InitialApplication::find($id);

        //To check whether the facility with the provided id exists
        if ($initFacility) {

            $incomingFields = $request->validate([
                'application_status' => 'required',
            ]);

            $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);
            $request['reject_remarks'] = strip_tags($request['reject_remarks']);

            $initFacility->application_status = $incomingFields['application_status'];
            $initFacility->reject_remarks = $request['reject_remarks'];
            $initFacility->late_remarks = $request['late_remarks'];
            $initFacility->late_date = $request['late_date'];
            $initFacility->inspector_date_rejected = Carbon::now()->format('Y-m-d');

            $initFacility->save();

            return response()->json([
                'status' => 200,
                // 'message'=>$facilityinspection->inspection_id
                'message' => 'Application has been rejected',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Failed to update facility status. Facility ID currently does not exist in the list for review.',
            ]);
        }
    }

    //Retrieve inital application to display in its own DataTable
    public function opapps()
    {
        // $data = OperationalApplications::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $data = OperationalApplications::with('Client')->get();
        // $opapplication = OperationalApplications::whereRaw('LOWER(`application_status`) LIKE ? ', [trim(strtolower('For review')) . '%'])->with('Client')->get();
        // $userprofile = UserProfile::with('UserAccount');
        $data = DB::table('users')
            ->join('tbl_operatepplication', 'users.user_id', '=', 'tbl_operatepplication.user_id')
            ->join('tbl_facility', 'tbl_operatepplication.fac_id', '=', 'tbl_facility.fac_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'users.gender', 'users.email', 'tbl_operatepplication.*', 'tbl_facility.*')
            ->whereRaw('LOWER(`application_status`) LIKE ?', [trim(strtolower('For scheduling')) . '%'])
            // ->orWhereRaw('LOWER(`application_status`) LIKE ?', [trim(strtolower('Failed inspection')) . '%'])
            ->orWhereRaw('LOWER(`application_status`) LIKE ?', [trim(strtolower('For reinspection')) . '%'])
            ->orWhereRaw('LOWER(`application_status`) LIKE ?', [trim(strtolower('pending')) . '%'])
            ->get();
        return compact('data');
    }

    //Update the application status or remarks of the initial application record
    public function setOpAppInspection(Request $request, $id)
    {

        $opFacility = OperationalApplications::find($id);

        //To check whether the facility with the provided id exists
        if ($opFacility) {

            $incomingFields = $request->validate([
                'application_status' => 'required',
                'inspection_date' => 'required',
                'inspector_name' => 'required',
            ]);

            //Checks whether the application has a prior inspection record or not
            //If it doesn't, it creates an entirely new inspection record in the facinspect table
            if ($opFacility->inspection_id == null || $opFacility->inspection_id == '') {
                $inspectiondata = [
                    'fac_id' => $opFacility->fac_id,
                    'inspector_name' => $incomingFields['inspector_name'],
                    'inspection_date' => $incomingFields['inspection_date'],
                    'inspection_status' => 'Pending Inspection',
                    'reinspection_status' => null,
                    'reinspection_date' => null,
                    'inspection_form' => null,
                    'inspection_type' => 'Initial Inspection',
                    'reject_remarks' => null,
                ];
                error_log("No prior record");

                //To save the data inside the database
                $facilityinspection = FacilityInspection::create($inspectiondata);

                $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);

                $opFacility->application_status = $incomingFields['application_status'];
                $opFacility->late_remarks = $request['late_remarks'];
                $opFacility->late_date = $request['late_date'];
                $opFacility->inspection_id = $facilityinspection->inspection_id != '' || $facilityinspection->inspection_id != null ? $facilityinspection->inspection_id : null;
                $opFacility->inspector_date_action = Carbon::now()->format('Y-m-d');

                $opFacility->save();

                return response()->json([
                    'status' => 200,
                    // 'message'=>$facilityinspection->inspection_id
                    'message' => 'Facility status updated successfully',
                ]);
            }
            //If it does have a prior inspection record, it will check whether it needs to categorize it as a
            // reinspection type or create an entirely new record in the facinspect table
            else {

                $incomingFields = $request->validate([
                    'application_status' => 'required',
                    'inspection_date' => 'required',
                    'inspector_name' => 'required',
                    'reinspection_date' => 'required'
                ]);

                $facilityinspection = FacilityInspection::find($opFacility->inspection_id);

                //This one updates the old inspection record and adds a reinspection date
                if ($facilityinspection->reinspection_date == null || $facilityinspection->reinspection_date == '') {

                    $inspectiondata = [
                        'inspection_id' => $opFacility->inspection_id,
                        'fac_id' => $opFacility->fac_id,
                        'inspector_name' => $incomingFields['inspector_name'],
                        'inspection_status' => 'Failed Inspection',
                        'reinspection_status' => 'Pending Reinspection',
                        'reinspection_date' => $incomingFields['reinspection_date'],
                        'inspection_form' => null,
                        'inspection_type' => 'Reinspection',
                        'reject_remarks' => null,
                    ];

                    //To save the data inside the database
                    $facilityinspection->update($inspectiondata);

                    $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);

                    $opFacility->application_status = $incomingFields['application_status'];
                    $opFacility->late_remarks = $request['late_remarks'];
                    $opFacility->late_date = $request['late_date'];
                    $opFacility->inspector_date_reaction = Carbon::now()->format('Y-m-d');

                    $opFacility->save();

                    return response()->json([
                        'status' => 200,
                        // // 'message'=>$incomingFields['reinspection_date']
                        'message' => 'Inspection date saved successfully',
                    ]);
                }
                //This one assigns a new inspection id to this application
                else {
                    $incomingFields = $request->validate([
                        'application_status' => 'required',
                        'inspection_date' => 'required',
                        'inspector_name' => 'required',
                    ]);

                    $inspectiondata = [
                        'fac_id' => $opFacility->fac_id,
                        'inspector_name' => $incomingFields['inspector_name'],
                        'inspection_date' => $incomingFields['inspection_date'],
                        'inspection_status' => 'Pending Inspection',
                        'reinspection_status' => null,
                        'reinspection_date' => null,
                        'inspection_form' => null,
                        'inspection_type' => 'Initial Inspection',
                        'reject_remarks' => null,
                    ];

                    //To save the data inside the database
                    $facilityinspection = FacilityInspection::create($inspectiondata);

                    $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);

                    $opFacility->application_status = $incomingFields['application_status'];
                    $opFacility->late_remarks = $request['late_remarks'];
                    $opFacility->late_date = $request['late_date'];
                    $opFacility->inspection_id = $facilityinspection->inspection_id != '' || $facilityinspection->inspection_id != null ? $facilityinspection->inspection_id : null;

                    $opFacility->save();

                    return response()->json([
                        'status' => 200,
                        // 'message'=>$facilityinspection->inspection_id
                        'message' => 'Inspection date saved successfully',
                    ]);
                }
            }

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Failed to update facility status. Facility ID currently does not exist in the list for review.',
            ]);
        }
    }

    public function rejectOpAppInspection(Request $request, $id)
    {

        $opFacility = OperationalApplications::find($id);

        //To check whether the facility with the provided id exists
        if ($opFacility) {

            $incomingFields = $request->validate([
                'application_status' => 'required',
            ]);

            $incomingFields['application_status'] = strip_tags($incomingFields['application_status']);
            $request['reject_remarks'] = strip_tags($request['reject_remarks']);

            $opFacility->application_status = $incomingFields['application_status'];
            $opFacility->reject_remarks = $request['reject_remarks'];
            $opFacility->late_remarks = $request['late_remarks'];
            $opFacility->late_date = $request['late_date'];
            $opFacility->inspector_date_rejected = Carbon::now()->format('Y-m-d');

            $opFacility->save();

            return response()->json([
                'status' => 200,
                // 'message'=>$facilityinspection->inspection_id
                'message' => 'Application has been rejected',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Failed to update facility status. Facility ID currently does not exist in the list for review.',
            ]);
        }
    }
    //Operational Application

    public function applicationlist()
    {
        $initapps = InitialApplication::with('Client')->get();
        $opapps = OperationalApplications::with('Client')->get();
        return view('inspector', ['initapps' => $initapps, 'opapp' => $opapps]);
    }

    public function pendingInspection()
    {
        Session::forget('success');
        Session::forget('fail');

        $initialapplication = DB::table('users')
            ->join('tbl_initapplication', 'users.user_id', '=', 'tbl_initapplication.user_id')
            ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id')
            ->join('tbl_facinspect', 'tbl_initapplication.fac_id', '=', 'tbl_facinspect.fac_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'users.gender', 'users.email', 'tbl_initapplication.*', 'tbl_facility.*', 'tbl_facinspect.*')
            ->whereRaw('LOWER(`inspection_status`) LIKE ? and is_paid = ?', [trim(strtolower('Pending inspection')) . '%', 1])
            ->orWhereRaw('LOWER(`reinspection_status`) LIKE ? and is_paid = ?', [trim(strtolower('Pending reinspection')) . '%', 1])
            ->get();

        $operationalapplication = DB::table('users')
            ->join('tbl_operatepplication', 'users.user_id', '=', 'tbl_operatepplication.user_id')
            ->join('tbl_facility', 'tbl_operatepplication.fac_id', '=', 'tbl_facility.fac_id')
            ->join('tbl_facinspect', 'tbl_operatepplication.fac_id', '=', 'tbl_facinspect.fac_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'users.gender', 'users.email', 'tbl_operatepplication.*', 'tbl_facility.*', 'tbl_facinspect.*')
            ->whereRaw('LOWER(`inspection_status`) LIKE ?', [trim(strtolower('Pending inspection')) . '%'])
            ->orWhereRaw('LOWER(`reinspection_status`) LIKE ?', [trim(strtolower('Pending reinspection')) . '%'])
            ->get();


        // error_log($initialapplication);
        // error_log($operationalapplication);

        $initial_application = [];
        $operational_application = [];

        //Current day of the month
        $currentDate = Carbon::now();
        foreach ($initialapplication as $initapp) {
            if (
                $initapp->inspection_status == "Pending Inspection" &&
                ($initapp->reinspection_status ==
                    "" || $initapp->reinspection_status == null)
            ) {
                $dateSplit = explode('-', $initapp->inspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $inspection_date = Carbon::parse($formattedDate);

                $countdownDays = getBusinessDaysCountdown(
                    $inspection_date,
                    $currentDate
                );

                if ($countdownDays > 0) {
                    array_push($initial_application, $initapp);
                }
            } else if (
                $initapp->inspection_status == "Failed Inspection" &&
                $initapp->reinspection_status == "Pending Reinspection"
            ) {
                $dateSplit = explode('-', $initapp->reinspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $reinspection_date = Carbon::parse($formattedDate);

                $countdownDays = getBusinessDaysCountdown(
                    $reinspection_date,
                    $currentDate
                );
                if ($countdownDays > 0) {
                    array_push($initial_application, $initapp);
                }
            }
        }

        foreach ($operationalapplication as $opapp) {
            if (
                $opapp->inspection_status == "Pending Inspection" &&
                ($opapp->reinspection_status ==
                    "" || $opapp->reinspection_status == null)
            ) {
                $dateSplit = explode('-', $opapp->inspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $inspection_date = Carbon::parse($formattedDate);

                $countdownDays = getBusinessDaysCountdown(
                    $inspection_date,
                    $currentDate
                );

                if ($countdownDays > 0) {
                    array_push($operational_application, $opapp);
                }
            } else if (
                $opapp->inspection_status == "Failed Inspection" &&
                $opapp->reinspection_status == "Pending Reinspection"
            ) {
                $dateSplit = explode('-', $opapp->reinspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $reinspection_date = Carbon::parse($formattedDate);

                $countdownDays = getBusinessDaysCountdown(
                    $reinspection_date,
                    $currentDate
                );

                if ($countdownDays > 0) {
                    array_push($operational_application, $opapp);
                }
            }
        }
        $data = ['initial_application' => $initial_application, 'operational_application' => $operational_application];
        // $data = ['initial_application' => $initialapplication, 'operational_application' => $operationalapplication];

        return $data;
    }

    public function overdueInspection()
    {
        Session::forget('success');
        Session::forget(keys: 'fail');

        $initialapplication = DB::table('users')
            ->join('tbl_initapplication', 'users.user_id', '=', 'tbl_initapplication.user_id')
            ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id')
            ->join('tbl_facinspect', 'tbl_initapplication.fac_id', '=', 'tbl_facinspect.fac_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'users.gender', 'users.email', 'tbl_initapplication.*', 'tbl_facility.*', 'tbl_facinspect.*')
            ->whereRaw('LOWER(`inspection_status`) LIKE ? and is_paid = ?', [trim(strtolower('Pending inspection')) . '%', 1])
            ->orWhereRaw('LOWER(`reinspection_status`) LIKE ? and is_paid = ?', [trim(strtolower('Pending reinspection')) . '%', 1])
            ->get();

        $operationalapplication = DB::table('users')
            ->join('tbl_operatepplication', 'users.user_id', '=', 'tbl_operatepplication.user_id')
            ->join('tbl_facility', 'tbl_operatepplication.fac_id', '=', 'tbl_facility.fac_id')
            ->join('tbl_facinspect', 'tbl_operatepplication.fac_id', '=', 'tbl_facinspect.fac_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'users.gender', 'users.email', 'tbl_operatepplication.*', 'tbl_facility.*', 'tbl_facinspect.*')
            ->whereRaw('LOWER(`inspection_status`) LIKE ?', [trim(strtolower('Pending inspection')) . '%'])
            ->orWhereRaw('LOWER(`reinspection_status`) LIKE ?', [trim(strtolower('Pending reinspection')) . '%'])
            ->get();


        $initial_application = [];
        $operational_application = [];

        //Current day of the month
        $currentDate = Carbon::now();
        foreach ($initialapplication as $initapp) {
            if (
                $initapp->inspection_status == "Pending Inspection" &&
                ($initapp->reinspection_status ==
                    "" || $initapp->reinspection_status == null)
            ) {
                $dateSplit = explode('-', $initapp->inspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $inspection_date = Carbon::parse($formattedDate)->addDay();

                $overdueDays = getBusinessDaysOverdueCount(
                    $inspection_date,
                    $currentDate
                );

                if ($overdueDays > 0) {
                    array_push($initial_application, $initapp);
                }
            } else if (
                $initapp->inspection_status == "Failed Inspection" &&
                $initapp->reinspection_status == "Pending Reinspection"
            ) {
                error_log("for reinspection");
                $dateSplit = explode('-', $initapp->reinspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $inspection_date = Carbon::parse($formattedDate)->addDay();

                $overdueDays = getBusinessDaysOverdueCount(
                    $inspection_date,
                    $currentDate
                );

                if ($overdueDays > 0) {
                    array_push($initial_application, $initapp);
                }
            }
        }

        foreach ($operationalapplication as $opapp) {
            if (
                $opapp->inspection_status == "Pending Inspection" &&
                ($opapp->reinspection_status ==
                    "" || $opapp->reinspection_status == null)
            ) {
                $dateSplit = explode('-', $opapp->inspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $inspection_date = Carbon::parse($formattedDate)->addDay();

                $overdueDays = getBusinessDaysOverdueCount(
                    $inspection_date,
                    $currentDate
                );

                if ($overdueDays > 0) {
                    array_push($operational_application, $opapp);
                }
            } else if (
                $opapp->inspection_status == "Failed Inspection" &&
                $opapp->reinspection_status == "Pending Reinspection"
            ) {
                $dateSplit = explode('-', $opapp->reinspection_date);
                $formattedDate =
                    $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                $inspection_date = Carbon::parse($formattedDate)->addDay();

                $overdueDays = getBusinessDaysOverdueCount(
                    $inspection_date,
                    $currentDate
                );

                if ($overdueDays > 0) {
                    array_push($operational_application, $opapp);
                }
            }
        }
        $data = ['initial_application' => $initial_application, 'operational_application' => $operational_application];
        // $data = ['initial_application' => $initialapplication, 'operational_application' => $operationalapplication];

        return $data;
    }

    public function facilitiesList()
    {
        $initialapplication = DB::table('users')
            ->join('tbl_initapplication', 'users.user_id', '=', 'tbl_initapplication.user_id')
            ->join('tbl_facility', 'tbl_initapplication.fac_id', '=', 'tbl_facility.fac_id')
            ->join('tbl_facinspect', 'tbl_initapplication.inspection_id', '=', 'tbl_facinspect.inspection_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'tbl_initapplication.*', 'tbl_facility.*', 'tbl_facinspect.inspection_date', 'tbl_facinspect.reinspection_date', 'tbl_facinspect.date_successful')
            // ->whereRaw('inspection_status = ? OR reinspection_status = ?', [strtolower('Finished inspection'), strtolower('Finished reinspection')])
            ->get();

        $operationalapplication = DB::table('users')
            ->join('tbl_operatepplication', 'users.user_id', '=', 'tbl_operatepplication.user_id')
            ->join('tbl_facility', 'tbl_operatepplication.fac_id', '=', 'tbl_facility.fac_id')
            ->join('tbl_facinspect', 'tbl_operatepplication.inspection_id', '=', 'tbl_facinspect.inspection_id')
            ->select('users.fname', 'users.mname', 'users.lname', 'tbl_operatepplication.*', 'tbl_facility.*', 'tbl_facinspect.inspection_date', 'tbl_facinspect.reinspection_date', 'tbl_facinspect.date_successful')
            // ->whereRaw('inspection_status = ? OR reinspection_status = ?', [strtolower('Finished inspection'), strtolower('Finished reinspection')])
            ->get();

        $data = ['initial_application' => $initialapplication, 'operational_application' => $operationalapplication];
        return $data;
    }

    function updateInspection($inspectionID, Request $request)
    {
        // error_log($request);
        if ($request->inspectResult == "Passed") {
            $validate = $request->validate([
                'checklist' => 'required|mimes:pdf|extensions:pdf|max:3072',
                'inspectionDate' => 'required|date',
                'inspectResult' => 'required|string'
            ]);

            $inspection = FacilityInspection::find($inspectionID);

            if ($inspection) {
                if (strtolower($inspection->inspection_status) == strtolower("Pending inspection")) {
                    $initapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_initapplication', 'tbl_facinspect.inspection_id', '=', 'tbl_initapplication.inspection_id')
                        ->join('users', 'tbl_initapplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();

                    $opapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_operatepplication', 'tbl_facinspect.inspection_id', '=', 'tbl_operatepplication.inspection_id')
                        ->join('users', 'tbl_operatepplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();


                    $initapp = InitialApplication::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    $opapp = OperationalApplications::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    if ($initapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $initapp_data->fname . '_' . $initapp_data->mname . '_' . $initapp_data->lname);
                    }
                    if ($opapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $opapp_data->fname . '_' . $opapp_data->mname . '_' . $opapp_data->lname);
                    }

                    $checklist = $request->file("checklist");
                    $path = "upload" . '\\' . $clientname;

                    if (!file_exists($path)) {
                        File::makeDirectory($path);
                        $checklist->move($path . '/', $checklist->getClientOriginalName());
                        $inspection->inspection_form = $path . '\\' . ($checklist->getClientOriginalName());
                    } else {
                        $checklist->move($path . '/', ($clientname . '-' . $checklist->getClientOriginalName()));
                        $inspection->inspection_form = $path . '\\' . ($clientname . '-' . $checklist->getClientOriginalName());
                    }

                    $inspection->date_successful = $request->inspectionDate;
                    $inspection->inspection_status = "Finished Inspection";

                    $application_type = "";

                    if ($initapp) {
                        $initapp->application_status = "Awaiting issuance of initial permit";
                        $application_type = "initial";

                        if ($request->inspectionRemarks) {
                            $inspection->reject_remarks = $request->inspectionRemarks;
                            $initapp->reject_remarks = $request->inspectionRemarks;
                        }
                        $initapp->save();
                    }

                    if ($opapp) {
                        $opapp->application_status = "Awaiting issuance of operational permit";
                        $application_type = "operational";

                        if ($request->inspectionRemarks) {
                            $inspection->reject_remarks = $request->inspectionRemarks;
                            $opapp->reject_remarks = $request->inspectionRemarks;
                        }
                        $opapp->late_remarks = $request->late_remarks;
                        $opapp->save();
                    }
                    $inspection->save();

                    return redirect()->back()->with(Session::put('success', "Successfully submitted the inspector checklist. Application is now finished in the " . $application_type . " application process."));
                } else {
                    $initapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_initapplication', 'tbl_facinspect.inspection_id', '=', 'tbl_initapplication.inspection_id')
                        ->join('users', 'tbl_initapplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();

                    $opapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_operatepplication', 'tbl_facinspect.inspection_id', '=', 'tbl_operatepplication.inspection_id')
                        ->join('users', 'tbl_operatepplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();


                    $initapp = InitialApplication::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    $opapp = OperationalApplications::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    if ($initapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $initapp_data->fname . '_' . $initapp_data->mname . '_' . $initapp_data->lname);
                    }
                    if ($opapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $opapp_data->fname . '_' . $opapp_data->mname . '_' . $opapp_data->lname);
                    }

                    $checklist = $request->file("checklist");
                    $path = "upload" . '\\' . $clientname;

                    if (!file_exists($path)) {
                        File::makeDirectory($path);
                        $checklist->move($path . '/', $checklist->getClientOriginalName());
                        $inspection->inspection_form = $path . '\\' . ($checklist->getClientOriginalName());
                    } else {
                        $checklist->move($path . '/', ($clientname . '-' . $checklist->getClientOriginalName()));
                        $inspection->inspection_form = $path . '\\' . ($clientname . '-' . $checklist->getClientOriginalName());
                    }

                    $inspection->date_successful = $request->inspectionDate;
                    $inspection->reinspection_status = "Finished Reinspection";

                    $application_type = "";

                    if ($initapp) {
                        $initapp->application_status = "Awaiting issuance of initial permit";
                        $application_type = "initial";

                        if ($request->inspectionRemarks) {
                            $inspection->reject_remarks = $request->inspectionRemarks;
                            $initapp->reject_remarks = $request->inspectionRemarks;
                        }
                        $initapp->save();
                    }

                    if ($opapp) {
                        $opapp->application_status = "Awaiting issuance of operational permit";
                        $application_type = "operational";

                        if ($request->inspectionRemarks) {
                            $inspection->reject_remarks = $request->inspectionRemarks;
                            $opapp->reject_remarks = $request->inspectionRemarks;
                        }
                        $opapp->late_remarks = $request->late_remarks;
                        $opapp->save();
                    }
                    $inspection->save();

                    return redirect()->back()->with(Session::put('success', "Successfully submitted the inspector checklist. Application is now finished in the " . $application_type . " application process."));
                }
            } else {
                return redirect()->back();
            }
        } else {
            $validate = $request->validate([
                'checklist' => 'required|mimes:pdf|extensions:pdf|max:3072',
                'inspectionDate' => 'required|date',
                'inspectResult' => 'required|string',
                'inspectionRemarks' => 'required|string'
            ]);

            $inspection = FacilityInspection::find($inspectionID);

            if ($inspection) {
                if (strtolower($inspection->inspection_status) == strtolower("Pending inspection")) {
                    $initapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_initapplication', 'tbl_facinspect.inspection_id', '=', 'tbl_initapplication.inspection_id')
                        ->join('users', 'tbl_initapplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();

                    $opapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_operatepplication', 'tbl_facinspect.inspection_id', '=', 'tbl_operatepplication.inspection_id')
                        ->join('users', 'tbl_operatepplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();

                    $initapp = InitialApplication::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    $opapp = OperationalApplications::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    if ($initapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $initapp_data->fname . '_' . $initapp_data->mname . '_' . $initapp_data->lname);
                    }
                    if ($opapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $opapp_data->fname . '_' . $opapp_data->mname . '_' . $opapp_data->lname);
                    }

                    $checklist = $request->file("checklist");
                    $path = "upload" . '\\' . $clientname;

                    if (!file_exists($path)) {
                        // error_log("File doesn't exists!");
                        File::makeDirectory($path);
                        $checklist->move($path . '/', $checklist->getClientOriginalName());
                        $inspection->inspection_form = $path . '\\' . ($checklist->getClientOriginalName());
                    } else {
                        // error_log("File exists!");
                        $checklist->move($path . '/', ($clientname . '-' . $checklist->getClientOriginalName()));
                        $inspection->inspection_form = $path . '\\' . ($clientname . '-' . $checklist->getClientOriginalName());
                    }

                    $inspection->date_successful = $request->inspectionDate;
                    $inspection->inspection_status = "Failed Inspection";
                    $inspection->reject_remarks = $validate["inspectionRemarks"];

                    $application_type = "";

                    if ($initapp) {
                        $initapp->application_status = "For Reinspection";
                        $application_type = "initial";
                        if ($validate["inspectionRemarks"] != "") {
                            $inspection->reject_remarks = $validate["inspectionRemarks"];
                            $initapp->reject_remarks = $validate["inspectionRemarks"];
                        }
                        $initapp->save();
                    }

                    if ($opapp) {
                        $opapp->application_status = "For Reinspection";
                        $application_type = "operational";

                        if ($validate["inspectionRemarks"] != "") {
                            $inspection->reject_remarks = $validate["inspectionRemarks"];
                            $opapp->reject_remarks = $validate["inspectionRemarks"];
                        }
                        $opapp->save();
                    }
                    $inspection->save();


                    return redirect()->back()->with(Session::put('fail', "Successfully submitted the inspector checklist. Applicant has failed the " . $application_type . " application process."));
                } else {
                    $initapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_initapplication', 'tbl_facinspect.inspection_id', '=', 'tbl_initapplication.inspection_id')
                        ->join('users', 'tbl_initapplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();

                    $opapp_data = DB::table('tbl_facinspect')
                        ->join('tbl_operatepplication', 'tbl_facinspect.inspection_id', '=', 'tbl_operatepplication.inspection_id')
                        ->join('users', 'tbl_operatepplication.user_id', '=', 'users.user_id')
                        ->select('users.fname', 'users.mname', 'users.lname')
                        ->whereRaw('tbl_facinspect.inspection_id = ?', $inspection->inspection_id)
                        ->first();

                    $initapp = InitialApplication::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    $opapp = OperationalApplications::where('inspection_id', $inspection->inspection_id)
                        ->first();

                    if ($initapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $initapp_data->fname . '_' . $initapp_data->mname . '_' . $initapp_data->lname);
                    }
                    if ($opapp_data) {
                        $clientname = Str::replaceArray(' ', ['_'], $opapp_data->fname . '_' . $opapp_data->mname . '_' . $opapp_data->lname);
                    }

                    $checklist = $request->file("checklist");
                    $path = "upload" . '\\' . $clientname;

                    if (!file_exists($path)) {
                        // error_log("File doesn't exists!");
                        File::makeDirectory($path);
                        $checklist->move($path . '/', $checklist->getClientOriginalName());
                        $inspection->inspection_form = $path . '\\' . ($checklist->getClientOriginalName());
                    } else {
                        // error_log("File exists!");
                        $checklist->move($path . '/', ($clientname . '-' . $checklist->getClientOriginalName()));
                        $inspection->inspection_form = $path . '\\' . ($clientname . '-' . $checklist->getClientOriginalName());
                    }

                    $inspection->date_successful = $request->inspectionDate;
                    $inspection->reinspection_status = "Failed Reinspection";
                    $inspection->reject_remarks = $validate["inspectionRemarks"];

                    $application_type = "";

                    if ($initapp) {
                        $initapp->application_status = "Failed Inspection";
                        $application_type = "initial";
                        if ($validate["inspectionRemarks"] != "") {
                            $inspection->reject_remarks = $validate["inspectionRemarks"];
                            $initapp->reject_remarks = $validate["inspectionRemarks"];
                        }
                        $initapp->save();
                    }

                    if ($opapp) {
                        $opapp->application_status = "Failed Inspection";
                        $application_type = "operational";

                        if ($validate["inspectionRemarks"] != "") {
                            $inspection->reject_remarks = $validate["inspectionRemarks"];
                            $opapp->reject_remarks = $validate["inspectionRemarks"];
                        }
                        $opapp->save();
                    }
                    $inspection->save();


                    return redirect()->back()->with(Session::put('fail', "Successfully submitted the inspector checklist. Applicant has failed the " . $application_type . " application process."));
                }
            } else {
                return redirect()->back();
            }
        }
    }

    function getChecklist(Request $request)
    {
        //Get the request data and decode it
        $inspectionData = json_decode($request->input('data'), true);

        if ($inspectionData) {
            // $name_split = Str::of($inspectionData["owner_name"])->explode(' ');
            // $formatted_name = $name_split[0] . '_' . $name_split[1] . '_' . $name_split[2][0] . '_' . $name_split[3];

            Session::put('checklist', $inspectionData);
            // $filename = 'checklist' . '-' . date('m-d-Y') . '_' . $formatted_name;
            $filename = 'checklist' . '-' . date('m-d-Y') . '_' . $inspectionData["owner_name"];
            $pdf = PDF::loadView('print.inspector-checklist');
            return $pdf->stream($filename . '.pdf');
        }
    }
}


//For computing total days before inspection day
function getBusinessDaysCountdown($inspection_date, $current_Date)
{
    $workingDays = 0;
    for (
        $current_Date;
        $inspection_date >= $current_Date;
        $current_Date = Carbon::parse($current_Date)->addDays(1)
    ) {

        $day = Carbon::parse($current_Date)->dayOfWeek();

        if ($day !== 0 && $day !== 6) {
            // Exclude Sundays (0) and Saturdays (6)
            $workingDays++;

            // Optional: Check for holidays (replace with your logic)
            // if (isHoliday(current_Date)) {
            //   workingDays--;
            // }
        }
    }
    return $workingDays;
}

//For computing total days overdue for inspection
function getBusinessDaysOverdueCount($inspection_date, $current_Date)
{
    $workingDays = 0;
    for (
        $inspection_date;
        $inspection_date <= $current_Date;
        $inspection_date = Carbon::parse($inspection_date)->addDay()
    ) {

        $day = Carbon::parse($inspection_date)->dayOfWeek();

        if ($day !== 0 && $day !== 6) {
            // Exclude Sundays (0) and Saturdays (6)
            $workingDays++;

            // Optional: Check for holidays (replace with your logic)
            // if (isHoliday(current_Date)) {
            //   workingDays--;
            // }
        }
    }
    return $workingDays;
}
