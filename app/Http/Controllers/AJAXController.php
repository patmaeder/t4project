<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AJAXController extends Controller
{
    public function index(Request $request)
    {
        $date = new \DateTime();

        $identifier = $request->get('identifier');

        switch ($identifier) {

            case 0:
                if (isset($_COOKIE["month"])) {
            
                    $date->setTimestamp(strtotime( $_COOKIE["month"]." month"));
                    
                    return response()->json($this->createResponse($date));
        
                } else {
        
                    $date->setTimestamp(strtotime("now"));
        
                    return response()->json($this->createResponse($date));
                } 

                break;
            
            case 1:
                if (isset($_COOKIE["month"])) {

                    $value = $_COOKIE["month"]-1;
                    setcookie("month", $value);
                    
                    $date->setTimestamp(strtotime( $value." month"));
        
                    return response()->json($this->createResponse($date));
        
                } else {
        
                    setcookie("month", "-1");
        
                    $date->setTimestamp(strtotime("-1 month"));
        
                    return response()->json($this->createResponse($date));
                }

                break;
            
            case 2:
                if (isset($_COOKIE["month"])) {

                    $value = $_COOKIE["month"]+1;
                    setcookie("month", $value);
                    
                    $date->setTimestamp(strtotime( $value." month"));
        
                    return response()->json($this->createResponse($date));
        
                } else {
        
                    setcookie("month", "+1");
        
                    $date->setTimestamp(strtotime("+1 month"));
        
                    return response()->json($this->createResponse($date));
                }

                break;
        }
        
    }

    public function createResponse($date) 
    {
        $day = $date->format("d");
        $month = $date->format("m");
        $year = $date->format("Y");

        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $monthAsString = $this->getMonthAsString($month)." ".$year;

        $firstDay = new \DateTime;
        $firstDay->setTimestamp($date->getTimestamp() - 86400*$day +86400);

        $lastDay = new \DateTime;
        $lastDay->setTimestamp($firstDay->getTimestamp() + 86400*$days -86400);

        //Selecting Events for specific User 
        $sessionID = session()->getID();
        $user = DB::select("select username from homestead.users JOIN homestead.sessions on (users.id = user_id) where sessions.id = '".$sessionID."'", [1]);

        $events = DB::select("select * from homestead.events where username = '".$user["0"]->username."' and date between '".$firstDay->format('Y-m-d')."' and '".$lastDay->format('Y-m-d')."' order by date, time;", [1]);

        $response = ["date" => $date->format('d.m.Y'), "firstDay" => $firstDay->format('d.m.Y'), "lastDay" => $lastDay->format('d.m.Y'), "month" => $monthAsString, "days" => $days, "firstWeekday" => $firstDay->format("N"), "lastDat" => $lastDay->format("d"), "events" => $events];

        return $response;
    }

    public function getMonthAsString($month) {
        
        switch ($month) {

            case 1:
                return "Januar";
                break;
            case 2:
                return "Februar";
                break;
            case 3:
                return "März";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mai";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "August";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Dezember";
                break;
        }
    }
}
