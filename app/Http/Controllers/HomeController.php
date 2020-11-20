<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Event;
use App\Models\User;
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
      
        $events = DB::select("select * from homestead.events where userID = '".$user->id."' and date >='".$date->format("Y-m-d")."' order by date", [1]);
        $events = array_slice($events , 0 , 4);


        $maxSemester = DB::select("select max(semester) as max from homestead.grades where userID = '".$user->id."'", [1]);
        $max = $maxSemester['0']->max;
        $grades = DB::select("select * from homestead.grades where userID = '".$user->id."' and semester ='".$max."'", [1]);

        $notes = DB::select("select notes from homestead.users where id = '".$user->id."'", [1]);

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

        if ($count > 0) {

            $avg = $avg/$count;
        }

        $semester = ['avg' => $avg, 'ects' => $ects];

        return view('home', ['events' => $events, 'semesters' => $semester, 'notes' => $notes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'notes' => ['string'],
        ]);

        $user = auth()->user();
        $id = $user->id;
        
        User::where('id', $id)->update($data);
    }
}