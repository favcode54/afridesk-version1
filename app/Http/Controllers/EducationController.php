<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Education;
use App\User;
use File;

class EducationController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function index()
    {
       
        
        $education = user::find(Auth::user()->id)->education;
       
    	// $education = Education::orderBy('created_at', 'desc')
    	// 	->get(['id','user_id','institution_name', 'degree', 'course', 'start_date', 'end_date']);

    	return response()
    		->json([
    			'education' => $education
    		]);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            		'institution_name' => 'required|max:255',
                    'degree' => 'required|max:255',
                    'course' => 'required|max:255',
                    'start_date' => 'required|max:255',
                    'end_date' => 'required|max:255',
                    'user_id' => 'required|min:1'
            	]);
        
        
            	$education = new education($request->only('user_id','institution_name', 'degree', 'course', 'start_date', 'end_date'));
            
        
            	$request->user()->education()
            		->save($education);

        	return response()
    	    ->json([
    	        'saved' => true,
    	        'id' => $education->id,
                'message' => 'You have successfully created education!'
    	    ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'institution_name' => 'required|max:255',
            'degree' => 'required|max:255',
            'course' => 'required|max:255',
            'start_date' => 'required|max:255',
            'end_date' => 'required|max:255'
        ]);

        // $education = $request->user()->education()
        // ->findOrFail($id);

        $education = Education::findOrFail($id);
        // $education->update($request->all());
        $education->institution_name = $request->institution_name;
        $education->degree = $request->degree;
        $education->course = $request->course;
        $education->start_date = $request->start_date;
        $education->end_date = $request->end_date;

        $education->save();

       
 
        return response()
        ->json([
            'saved' => true,
            'id' => $education->id,
            'message' => 'You have successfully updated recipe!'
        ]);

}


}