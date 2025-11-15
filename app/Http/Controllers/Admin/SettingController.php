<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        // Use a collection to easily pass settings to the view
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'anomaly_threshold' => 'required|numeric|min:1|max:5',
            // Add validation for other settings here
        ]);

        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            // Bust the cache for the setting we just updated
            Cache::forget('settings.' . $key);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}