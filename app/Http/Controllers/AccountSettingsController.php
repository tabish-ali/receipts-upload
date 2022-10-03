<?php

namespace App\Http\Controllers;

use App\Models\AccountSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountSettingsController extends Controller
{
    public function setAccountSettings(Request $request)
    {
        if (Auth::user()) {
            $settings = (object)$request->settings;
            $account_settings = AccountSettings::latest()->first();
            if (isset($account_settings)) {
                $account_settings->name = $settings->name;
                $account_settings->number = $settings->number;
                $account_settings->save();
            } else {
                AccountSettings::create(['name' => $settings->name, 'number' => $settings->number]);
            }
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'failed']);
        }
    }

    public function settingsView(Request $request)
    {
        return view('dashboard.settings');
    }

    public function getSettings(Request $request)
    {
        $account_settings = AccountSettings::latest()->first();
        return response()->json(['settings' => $account_settings]);
    }
}
