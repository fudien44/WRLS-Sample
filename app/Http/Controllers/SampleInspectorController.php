<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InitialApplications;
use App\Models\OperationalApplications;

class SampleInspectorController extends Controller
{
    public function index()
    {
        $initapps = InitialApplications::with('Client')->get();
        $opapps = OperationalApplications::with('Client')->get();
        return view('sample', ['initapps' => $initapps, 'opapps'=>$opapps]);
        // return view('inspector', ['initapps' => $initapps]);
    }
}
