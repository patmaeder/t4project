<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    if (Auth::check()) {
       
        return redirect('home');

    }else {

        return view('welcome');
    }
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::resource('calendar', EventController::class);

//Route::get('calendar', [EventController::class, "index"])->middleware('auth');

//Route::get('calendar/new', function () {
//    return view('calendar.newEvent');
//})->middleware('auth');

//Route::post('calender/new', [EventController::class, "newEvent"])->middleware('auth');