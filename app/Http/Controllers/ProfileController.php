<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function index()
    {
    	$education = Education::orderBy('created_at', 'desc')
    		->get(['id', 'name', 'image']);

    	return response()
    		->json([
    			'education' => $education
    		]);
    }
}
