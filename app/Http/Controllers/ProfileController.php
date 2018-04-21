<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;
use File;
class ProfileController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function index()
    {
    	$profile = Profile::orderBy('created_at', 'desc')
            ->get(['id', 'user_id', 'profile_image']);

    	return response()
    		->json([
    			'profile' => $profile
    		]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'profile_image' => 'required|image',
    	]);

    	if(!$request->hasFile('profile_image') && !$request->file('profile_image')->isValid()) {
    		return abort(404, 'Profile Image not uploaded!');
    	}

    	$filename = $this->getFileName($request->profile_image);
    	$request->profile_image->move(base_path('public/image'), $filename);

    	$profile->profile_image = $filename;

    	$request->user()->profile()
    		->save($profile);


    	return response()
    	    ->json([
    	        'saved' => true,
    	        'id' => $profile->id,
                'message' => 'You have successfully Updated your Profile Picture'
    	    ]);
    }

}
