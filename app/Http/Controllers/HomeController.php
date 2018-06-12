<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsFeedContent = Auth::user()->newsFeed();
        return view('home', compact('newsFeedContent'));
    }

    public function activity()
    {
        $activityContent = Auth::user()->activityFeed();
        return view('activity', compact('activityContent'));
    }
}
