<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\AJAXController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EditUserInformationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= auth()->user();
        return view('auth.editProfile', ['user' => $user]);
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
        $user = auth()->user();
        $Response = DB::select("select * from homestead.users where not id = '".$id."'", [1]);
        $otherUsernames = [];
        foreach($Response as $object) {
            array_push($otherUsernames, $object->username);
        }
        $otherEMails = [];
        foreach($Response as $object) {
            array_push($otherEMails, $object->email);
        }
       
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 
                'string', 
                'max:255',
                Rule::NotIn($otherUsernames),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::NotIn($otherEMails),
            ],
        ]);

        User::where('id', $id)->update($data);

        return redirect('/home')->with('success', 'Profil wurde erfolgreich bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Events = DB::delete("delete from homestead.events where userID = '".$id."';");

        $user= User::findOrFail($id);
        $user->delete();

        return redirect('/');
    }
}