<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\AJAXController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('calendar.calendar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar.newEvent');
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
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required', 'string'],
            'description' => [],
        ]);

        $user = auth()->user();
        $data["username"] = $user->username;

        Event::create($data);

        return redirect('/calendar')->with('success', 'Eintrag wurde erfolgreich angelegt');
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
        $event= Event::findOrFail($id);

        $user = auth()->user();

        if($event->username == $$user->username) {

            return view('calendar.editEvent', ['event' => $event]);

        }else {

            return redirect('/calendar')->with('error', 'Dieser Kalendereintrag existiert nicht');
        }
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
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required', 'string'],
            'description' => [],
        ]);

        Event::where('id', $id)->update($data);

        return redirect('/calendar')->with('success', 'Eintrag wurde erfolgreich bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event= Event::findOrFail($id);
        $event->delete();

        return redirect('/calendar')->with('success', 'Eintrag wurde erfolgreich gelöscht');
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
