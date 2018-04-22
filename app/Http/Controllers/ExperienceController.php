<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Experience;
use App\User;
use File;

class ExperienceController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function index()
    {

        $experience = user::find(Auth::user()->id)->experience;
    	// $experience = Experience::orderBy('created_at', 'desc')
    	// 	->get(['id','user_id','compamy_name', 'role_title', 'city', 'country', 'description', 'start_date', 'end_date']);

    	return response()
    		->json([
    			'experience' => $experience
    		]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            		'compamy_name' => 'required|max:255',
                    'role_title' => 'required|max:255',
                    'city' => 'required|max:255',
                    'country' => 'required|max:255',
                    'description' => 'required|max:3000',
                    'start_date' => 'required|max:255',
                    'end_date' => 'required|max:255',
                    'user_id' => 'required|min:1'
            	]);
        
        
            	$experience = new experience($request->only('user_id','compamy_name', 'role_title', 'city', 'country', 'description', 'start_date', 'end_date'));
            
        
            	$request->user()->experience()
            		->save($experience);

        	return response()
    	    ->json([
    	        'saved' => true,
    	        'id' => $experience->id,
                'message' => 'You have successfully created experience!'
    	    ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'compamy_name' => 'required|max:255',
            'role_title' => 'required|max:255',
            'city' => 'required|max:255',
            'country' => 'required|max:255',
            'description' => 'required|max:3000',
            'start_date' => 'required|max:255',
            'end_date' => 'required|max:255',
        ]);

        // $experience = $request->user()->experience()
        // ->findOrFail($id);

        $experience = Experience::findOrFail($id);
        // $experience->update($request->all());
        $experience->compamy_name = $request->compamy_name;
        $experience->role_title = $request->role_title;
        $experience->city = $request->city;
        $experience->country = $request->country;
        $experience->description = $request->description;
        $experience->start_date = $request->start_date;
        $experience->end_date = $request->end_date;

        $experience->save();

        return response()
        ->json([
            'saved' => true,
            'id' => $experience->id,
            'message' => 'You have successfully updated Ypor Professional Experience!'
        ]);

}
}
