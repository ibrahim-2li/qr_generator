<?php

namespace App\Livewire;

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale;

    public function mount(): void
    {
        $this->currentLocale = app()->getLocale();
    }

    public function switchLocale(string $locale): void
    {
        if (array_key_exists($locale, SetLocale::SUPPORTED_LOCALES)) {
            Session::put('locale', $locale);
            $this->currentLocale = $locale;

            // Redirect to refresh the page with new locale
            $this->redirect(request()->header('Referer', url()->current()));
        }
    }

    public function render()
    {
        return view('livewire.language-switcher', [
            'locales' => SetLocale::SUPPORTED_LOCALES,
        ]);
    }
}
