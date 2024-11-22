<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct() {
    }

    public function index() {
        return view('dashboard');
    }
}
