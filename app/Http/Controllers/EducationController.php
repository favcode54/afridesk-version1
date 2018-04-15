<?php

namespace App\Http\Controllers;

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
    	$education = Education::orderBy('created_at', 'desc')
    		->get(['institution_name', 'degree', 'course', 'start_date', 'end_date']);

    	return response()
    		->json([
    			'education' => $education
    		]);
    }
}
