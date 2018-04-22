<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'AuthController@register');
Route::resource('education', 'EducationController');
Route::resource('experience', 'ExperienceController');
Route::resource('profile', 'ProfileController');
Route::get('/search',function(){
    $query = Input::get('query');
    $skills = \App\Skilllist::where('skill','like','%'.$query.'%')->get();
    return response()->json($skills);
   });