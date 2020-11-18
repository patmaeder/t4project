<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $id = $user->id;

        $date = new \DateTime();
        $date->setTimestamp(strtotime("now"));
      
        $events = DB::select("select * from homestead.events where userID = '".$user->id."' and date >='".$date->format("m/d/Y")."' and time >='".$date->format("H:i:s")."' limit 4", [1]);

        $maxSemester = DB::select("select max(semester) as max from homestead.grades where userID = '".$user->id."'", [1]);
        $max = $maxSemester['0']->max;
        $grades = DB::select("select * from homestead.grades where userID = '".$user->id."' and semester ='".$max."'", [1]);

        $avg = 0;
        $count = 0;
        $ects = 0;

        foreach ($grades as $item) {
            
            if ($item->grade != null) {

                $avg = $avg + $item->grade;
                $count ++;
            }

            if ($item->ECTS != null) {

                $ects = $ects + $item->ECTS;
            }
        } 

        $avg = $avg/$count;

        $semester = ['avg' => $avg, 'ects' => $ects];

        return view('home', ['events' => $events, 'semesters' => $semester]);
    }
}
