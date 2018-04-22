<?php

namespace App\Http\Controllers;
use Auth;
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
	
			$profile = user::find(Auth::user()->id)->profile;

    	return response()
    		->json([
    			'profile' => $profile
    		]);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
			'user_id' => 'required|max:255',
    		'image' => 'required|image',
    	]);

    	if(!$request->hasFile('image') && !$request->file('image')->isValid()) {
    		return abort(404, 'Profile Image not uploaded!');
    	}

    	$filename = $this->getFileName($request->image);
    	$request->image->move(base_path('public/images'), $filename);
		$profile = new Profile($request->only('user_id'));
    	$profile->image = $filename;
    	$request->user()->profile()
    		->save($profile);


    	return response()
    	    ->json([
    	        'saved' => true,
    	        'id' => $profile->id,
                'message' => 'You have successfully Updated your Profile Picture'
    	    ]);
	}
	private function getFileName($file)
    {
    	return str_random(32).'.'.$file->extension();
	}
	
	public function update($id, Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'image' => 'image',
        ]);
        $profile = $request->user()->profile()
            ->findOrFail($id);
        // upload image
        if ($request->hasfile('image') && $request->file('image')->isValid()) {
            $filename = $this->getFileName($request->image);
            $request->image->move(base_path('/public/images'), $filename);
            // remove old image
            File::delete(base_path('/public/images/'.$profile->image));
            $profile->image = $filename;
        }
        $profile->save();
        
        return response()
            ->json([
                'saved' => true,
                'id' => $profile->id,
                'message' => 'You have successfully updated profile!'
            ]);

}

}
