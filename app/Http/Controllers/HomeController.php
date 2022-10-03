<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountSettings;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $account_settings = AccountSettings::latest()->first();
        if ($account_settings) {
            return view('home', ['settings' => $account_settings]);
        } else {
            return view('no_settings');
        }
    }
}
