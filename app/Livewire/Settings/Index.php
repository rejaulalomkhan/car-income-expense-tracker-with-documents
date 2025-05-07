<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class Index extends Component
{
    use WithFileUploads;

    public $appName;
    public $contactEmail;
    public $contactPhone;
    public $logo;
    public $icon;
    public $theme = 'light';
    public $language = 'en';
    public $currentLogo;
    public $currentIcon;

    public function mount()
    {
        // Load settings from database or config
        $this->appName = config('app.name');
        $this->contactEmail = Setting::where('key', 'contact_email')->first()?->value;
        $this->contactPhone = Setting::where('key', 'contact_phone')->first()?->value;
        $this->theme = Setting::where('key', 'theme')->first()?->value ?? 'light';
        $this->language = Setting::where('key', 'language')->first()?->value ?? 'en';
        $this->currentLogo = Setting::where('key', 'logo')->first()?->value;
        $this->currentIcon = Setting::where('key', 'icon')->first()?->value;
    }

    public function save()
    {
        $this->validate([
            'appName' => 'required|string|max:255',
            'contactEmail' => 'required|email',
            'contactPhone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:1024',
            'icon' => 'nullable|image|max:1024',
            'theme' => 'required|in:light,dark',
            'language' => 'required|in:en,bn',
        ]);

        // Save app name to .env file
        $this->updateEnvVariable('APP_NAME', $this->appName);

        // Save other settings to database
        $this->updateSetting('contact_email', $this->contactEmail);
        $this->updateSetting('contact_phone', $this->contactPhone);
        $this->updateSetting('theme', $this->theme);
        $this->updateSetting('language', $this->language);

        if ($this->logo) {
            $logoPath = $this->logo->store('settings', 'public');
            $this->updateSetting('logo', $logoPath);
            $this->currentLogo = $logoPath;
        }

        if ($this->icon) {
            $iconPath = $this->icon->store('settings', 'public');
            $this->updateSetting('icon', $iconPath);
            $this->currentIcon = $iconPath;
        }

        session()->flash('message', 'Settings updated successfully.');
    }

    private function updateSetting($key, $value)
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    private function updateEnvVariable($key, $value)
    {
        $path = base_path('.env');
        $content = file_get_contents($path);

        file_put_contents($path, preg_replace(
            "/^{$key}=.*/m",
            "{$key}=\"{$value}\"",
            $content
        ));
    }

    public function render()
    {
        return view('livewire.settings.index');
    }
}
