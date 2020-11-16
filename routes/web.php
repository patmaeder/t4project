<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AJAXController;
use App\Http\Controllers\EditUserInformationController;
use App\Http\Controllers\GradeOverviewController;


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

Route::resource('calendar', EventController::class)->middleware('auth');

Route::resource('ajax', AJAXController::class)->middleware('auth');

Route::resource('edit', EditUserInformationController::class)->middleware('auth');

Route::resource('grades', GradeOverviewController::class)->middleware('auth');

