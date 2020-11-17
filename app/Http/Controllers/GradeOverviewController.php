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
        $semester = [1 => ['Mathematik' => ['grade' => 1.5, 'ECTS' => 5], 'Deutsch' => ['grade' => 2, 'ECTS' => 4]], 2 => ['BK' => ['grade' => 1.5, 'ECTS' => 5]]];

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
