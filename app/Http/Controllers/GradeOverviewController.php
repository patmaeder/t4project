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

        if (count($result) > 0) {

            foreach ($result as $item) {
          
                $s = $item->semester;
                $Name = 'array'.$item->semester;

                if (isset($$Name)) {
    
                    array_push($$Name, [$item->subject => ['grade' => $item->grade, 'ECTS' => $item->ECTS, 'id' => $item->id]]);
    
                } else {
                        
                    global $$Name;
                    $$Name = [];
                    array_push($$Name, [$item->subject => ['grade' => $item->grade, 'ECTS' => $item->ECTS, 'id' => $item->id]]);

                    if ($s > $count) {
                        $count = $s;
                    }
                }
            };

            for ($i = 1; $i <= $count; $i++) {
            
                $arrayName = 'array'.$i;

                if (isset($$arrayName)) {

                    $semester[$i] = $$arrayName;

                } else {

                    $$arrayName = [];
                    $semester[$i] = $$arrayName;
                }
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
            'semester' => ['numeric', 'required'],
            'subject' => ['string', 'required'],
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
        $data = $request->validate([
            'subject' => ['string', 'required'],
            'grade' => ['numeric'],
            'ECTS' => ['numeric'],
        ]);

        Grade::where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grade= Grade::findOrFail($id);

        $user = auth()->user();

        if($grade->userID == $user->id) {

            $grade->delete();
            return response()->json(["success"]);
        }
    }
}
