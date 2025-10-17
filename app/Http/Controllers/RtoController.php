<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RtoController extends Controller
{
    public function dashboard()
    {
        return view('rto.dashboard');
    }
}