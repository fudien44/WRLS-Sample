<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Facility;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\FacilityInspection;
use Illuminate\Support\Facades\DB;
use App\Models\InitialApplications;

class AlertNotification extends Controller
{
    public function getAlerts()
    {
        $facilities = FacilityInspection::with('facility')->whereRaw('inspection_status =? or reinspection_status =?', ['Pending Inspection', 'Pending Reinspection'])->get();

        $overdues = [];
        $countdowns = [];
        $data = [];

        if (count($facilities) > 0) {
            foreach ($facilities as $facinspect) {
                if (
                    ($facinspect->inspection_date != null &&
                        $facinspect->inspection_date != "" && $facinspect->inspection_status != "Finished Inspection") || ($facinspect->reinspection_date != null &&
                        $facinspect->reinspection_date != "" && $facinspect->reinspection_status != "Finished Reinspection")
                ) {
                    // $client = Users::find($facinspect->facility->user_id);
                    $client = DB::table('users')->whereRaw('user_id =?', $facinspect->facility->user_id)->first();
                    $dateSplit = explode('-', $facinspect->inspection_date);
                    $formattedDate =
                        $dateSplit[1] . "/" . $dateSplit[2] . "/" . $dateSplit[0];

                    //Current day of the month
                    $currentDate = Carbon::now();

                    if ($formattedDate <= $currentDate) {

                        $inspection_date = Carbon::parse($formattedDate);

                        $countdownDays = getBusinessDaysCountdown(
                            $inspection_date,
                            $currentDate
                        );

                        if ($countdownDays >= 0) {

                            $actionDate = Carbon::parse($inspection_date)->format('d');
                            $actionMonth = Carbon::parse($inspection_date)->monthOfYear();
                            $actionYear = Carbon::parse($inspection_date)->format('Y');


                            switch ($actionMonth) {
                                case 1:
                                    $monthToString = "January";
                                    break;
                                case 2:
                                    $monthToString = "February";
                                    break;
                                case 3:
                                    $monthToString = "March";
                                    break;
                                case 4:
                                    $monthToString = "April";
                                    break;
                                case 5:
                                    $monthToString = "May";
                                    break;
                                case 6:
                                    $monthToString = "June";
                                    break;
                                case 7:
                                    $monthToString = "July";
                                    break;
                                case 8:
                                    $monthToString = "August";
                                    break;
                                case 9:
                                    $monthToString = "September";
                                    break;
                                case 10:
                                    $monthToString = "October";
                                    break;
                                case 11:
                                    $monthToString = "November";
                                    break;
                                case 12:
                                    $monthToString = "December";
                                    break;
                            }

                            $date_actiontakenFormat =
                                $monthToString . ' ' . $actionDate . ', ' . $actionYear;

                            // error_log($facinspect->facility);
                            array_push($countdowns, [
                                'inspection_id' => $facinspect->inspection_id,
                                'facility_name' => $facinspect->facility->fac_name,
                                'date_inspection' => $date_actiontakenFormat,
                                'countdownDays' => $countdownDays,
                                'address' => $facinspect->facility->fac_address,
                                'client' => $client->fname . ' ' . $client->mname[0] . '. ' . $client->lname,
                                'owner' => $facinspect->facility->owner_name
                            ]);
                        }
                    } else {
                        $inspection_date = Carbon::parse($formattedDate)->addDay();

                        $overdueDays = getBusinessDaysOverdueCount(
                            $inspection_date,
                            $currentDate
                        );

                        if ($overdueDays >= 0) {
                            $inspection_date = $facinspect->inspection_date;

                            $actionDate = Carbon::parse($inspection_date)->format('d');
                            $actionMonth = Carbon::parse($inspection_date)->monthOfYear();
                            $actionYear = Carbon::parse($inspection_date)->format('Y');


                            switch ($actionMonth) {
                                case 1:
                                    $monthToString = "January";
                                    break;
                                case 2:
                                    $monthToString = "February";
                                    break;
                                case 3:
                                    $monthToString = "March";
                                    break;
                                case 4:
                                    $monthToString = "April";
                                    break;
                                case 5:
                                    $monthToString = "May";
                                    break;
                                case 6:
                                    $monthToString = "June";
                                    break;
                                case 7:
                                    $monthToString = "July";
                                    break;
                                case 8:
                                    $monthToString = "August";
                                    break;
                                case 9:
                                    $monthToString = "September";
                                    break;
                                case 10:
                                    $monthToString = "October";
                                    break;
                                case 11:
                                    $monthToString = "November";
                                    break;
                                case 12:
                                    $monthToString = "December";
                                    break;
                            }

                            $date_actiontakenFormat =
                                $monthToString . ' ' . $actionDate . ', ' . $actionYear;

                            array_push($overdues, [
                                'inspection_id'=>$facinspect->inspection_id,
                                'facility_name' => $facinspect->facility->fac_name,
                                'date_inspection' => $date_actiontakenFormat,
                                'overdueDays'=>$overdueDays,
                                'address' => $facinspect->facility->fac_address,
                                'client' => $client->fname . ' ' . $client->mname[0] . '. ' . $client->lname,
                                'owner' => $facinspect->facility->owner_name
                            ]);
                        }
                    }
                }

            }
        }
        $data = [
            'overdues' => $overdues,
            'countdowns' => $countdowns
        ];

        return $data;
    }
}
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
