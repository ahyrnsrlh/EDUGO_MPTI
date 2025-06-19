<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Google;

class SettingController extends Controller
{
    public function googleSetting()
    {
        $google = Google::first();
        return view('backend.admin.setting.google.index', compact('google'));
    }

    public function updateGoogleSettings(Request $request)
    {
        $request->validate([
            'google_analytics' => 'nullable|string',
            'google_adsense' => 'nullable|string',
        ]);
        
        Google::updateOrCreate(['id' => 1], [
            'google_analytics' => $request->google_analytics,
            'google_adsense' => $request->google_adsense,
        ]);
        return redirect()->back()->with('success', 'Google settings updated successfully!');
    }
}
