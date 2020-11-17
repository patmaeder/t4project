<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\AJAXController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GradeOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        
        $result = DB::select("select * from homestead.grades where userID = '".$user->id."' order by semester", [1]);

        $semester = [];
        $count = 0;

        foreach ($result as $item) {
          
            $s = 'array'.$item->semester;

            if (isset($$s)) {

                array_push($$s, [$item->subject => ['grade' => $item->grade, 'ECTS' => $item->ECTS, 'id' => $item->id]]);


            } else {

                global $$s;
                $$s = [];
                array_push($$s, [$item->subject => ['grade' => $item->grade, 'ECTS' => $item->ECTS, 'id' => $item->id]]);
                $count++;
            }

        };

        if ($count != 0) {

            for ($i = 1; $i <= $count; $i++) {
            
                $arrayName = 'array'.$i;
    
                $semester[$i] = $$arrayName;
            }

        } else {

            $semester[1] = [];
        }

        return view('gradeOverview.gradeOverview', ['semesters' => $semester]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'semester' => ['numeric'],
            'subject' => ['string'],
            'grade' => ['numeric'],
            'ECTS' => ['numeric'],
        ]);

        $user = auth()->user();
        $data["userID"] = $user->id;

        Grade::create($data);

        $id = DB::getPdo()->lastInsertId();;

        return response()->json(['id' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
