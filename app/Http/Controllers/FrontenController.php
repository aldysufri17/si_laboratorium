<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:admin');

    }
    public function index(){
        return view('frontend.front');
    }
    public function show(){
        return view('frontend.end');
    }
}
