<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::check()
            ) {     
            $user = \Illuminate\Support\Facades\Auth::user();  
        }
    }
}