{{-- <div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.away="open = false"
        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ $locales[$currentLocale]['native'] }}</span>
        <svg class="h-4 w-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute end-0 mt-2 w-40 rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black/5 dark:ring-white/10 z-50">
        <div class="py-1">
            @foreach ($locales as $code => $locale)
                <button wire:click="switchLocale('{{ $code }}')"
                    class="flex w-full items-center gap-2 px-4 py-2 text-sm {{ $currentLocale === $code ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700' }}">
                    @if ($currentLocale === $code)
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    @else
                        <span class="w-4"></span>
                    @endif
                    <span>{{ $locale['native'] }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div> --}}
<div
    class="flex items-center rounded-lg bg-white p-1 bg-white-100 dark:text-gray-300 dark:bg-gray-800 transition-colors">
    <a href="{{ route('locale.switch', ['locale' => 'en']) }}"
        class="px-2 py-1 rounded-md text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-slate-900 text-white' : 'text-white-900' }}">{{ __('landing.language_en') }}</a>
    <a href="{{ route('locale.switch', ['locale' => 'ar']) }}"
        class="px-2 py-1 rounded-md text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'bg-slate-900 text-white' : 'text-white-900' }}">{{ __('landing.language_ar') }}</a>
</div>
