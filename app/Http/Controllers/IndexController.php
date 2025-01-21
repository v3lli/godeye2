<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    //
    public function index()
    {
        $username = 'eMeKavelli';
        $bearerToken = env('VITE_BEARER_TOKEN');
    }
}
