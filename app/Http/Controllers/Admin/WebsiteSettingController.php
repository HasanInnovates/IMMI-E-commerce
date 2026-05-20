<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WebsiteSettingController extends Controller
{
    public function index(): View
    {
        $settings = WebsiteSetting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'website_name' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'twitter_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'primary_color' => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,ico,webp', 'max:1024'],
            'hero_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:4096'],
        ];

        $validated = $request->validate($rules);

        $textFields = ['website_name', 'hero_title', 'hero_subtitle', 'footer_text',
                       'contact_email', 'contact_phone', 'facebook_url', 'twitter_url',
                       'instagram_url', 'primary_color', 'secondary_color'];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                WebsiteSetting::setValue($field, $validated[$field] ?? '');
            }
        }

        $imageFields = ['logo', 'favicon', 'hero_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $old = WebsiteSetting::getValue($field);
                if ($old) {
                    Storage::delete($old);
                }

                $path = $request->file($field)->store('settings', 'public');
                WebsiteSetting::setValue($field, $path, 'image');
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('status', 'Settings updated successfully.');
    }

    public function deleteImage(Request $request): RedirectResponse
    {
        $request->validate(['key' => ['required', 'string', 'in:logo,favicon,hero_image']]);

        $key = $request->input('key');
        $path = WebsiteSetting::getValue($key);

        if ($path) {
            Storage::disk('public')->delete($path);
            WebsiteSetting::setValue($key, null);
        }

        return redirect()->route('admin.settings.index')
            ->with('status', ucfirst(str_replace('_', ' ', $key)) . ' deleted successfully.');
    }
}
