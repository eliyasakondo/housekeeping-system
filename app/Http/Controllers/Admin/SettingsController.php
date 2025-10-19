<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Get saved settings from JSON file
        $savedSettings = $this->getSavedSettings();
        
        $settings = [
            'app_name' => $savedSettings['app_name'] ?? config('app.name', 'Housekeeping Manager'),
            'app_url' => config('app.url', 'http://127.0.0.1:8000'),
            'logo' => $this->getLogo(),
            'favicon' => $this->getFavicon(),
            'primary_color' => $savedSettings['primary_color'] ?? '#667eea',
            'secondary_color' => $savedSettings['secondary_color'] ?? '#764ba2',
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'nullable|string|max:255',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if (Storage::disk('public')->exists('branding/logo.png')) {
                Storage::disk('public')->delete('branding/logo.png');
            }
            
            $logoPath = $request->file('logo')->storeAs(
                'branding',
                'logo.' . $request->file('logo')->getClientOriginalExtension(),
                'public'
            );
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if (Storage::disk('public')->exists('branding/favicon.ico')) {
                Storage::disk('public')->delete('branding/favicon.ico');
            }
            
            $faviconPath = $request->file('favicon')->storeAs(
                'branding',
                'favicon.' . $request->file('favicon')->getClientOriginalExtension(),
                'public'
            );
        }

        // Update settings in a JSON file
        $settingsData = [
            'app_name' => $validated['app_name'] ?? config('app.name'),
            'primary_color' => $validated['primary_color'] ?? '#667eea',
            'secondary_color' => $validated['secondary_color'] ?? '#764ba2',
            'updated_at' => now()->toDateTimeString(),
        ];

        Storage::disk('local')->put('settings.json', json_encode($settingsData, JSON_PRETTY_PRINT));

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully! Please refresh the page to see changes.');
    }

    /**
     * Reset settings to defaults.
     */
    public function reset()
    {
        // Delete saved settings
        Storage::disk('local')->delete('settings.json');
        
        // Delete logo if exists
        $logoExtensions = ['png', 'jpg', 'jpeg', 'svg'];
        foreach ($logoExtensions as $ext) {
            if (Storage::disk('public')->exists("branding/logo.{$ext}")) {
                Storage::disk('public')->delete("branding/logo.{$ext}");
            }
        }
        
        // Delete favicon if exists
        $faviconExtensions = ['ico', 'png'];
        foreach ($faviconExtensions as $ext) {
            if (Storage::disk('public')->exists("branding/favicon.{$ext}")) {
                Storage::disk('public')->delete("branding/favicon.{$ext}");
            }
        }
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings reset to defaults successfully!');
    }

    /**
     * Get saved settings from JSON file.
     */
    private function getSavedSettings()
    {
        if (Storage::disk('local')->exists('settings.json')) {
            $json = Storage::disk('local')->get('settings.json');
            return json_decode($json, true) ?? [];
        }
        
        return [];
    }

    /**
     * Get the logo path.
     */
    private function getLogo()
    {
        $extensions = ['png', 'jpg', 'jpeg', 'svg'];
        
        foreach ($extensions as $ext) {
            if (Storage::disk('public')->exists("branding/logo.{$ext}")) {
                return asset("storage/branding/logo.{$ext}");
            }
        }
        
        return null;
    }

    /**
     * Get the favicon path.
     */
    private function getFavicon()
    {
        $extensions = ['ico', 'png'];
        
        foreach ($extensions as $ext) {
            if (Storage::disk('public')->exists("branding/favicon.{$ext}")) {
                return asset("storage/branding/favicon.{$ext}");
            }
        }
        
        return null;
    }
}
