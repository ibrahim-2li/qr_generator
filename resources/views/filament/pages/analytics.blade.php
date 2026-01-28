<x-filament-panels::page>
    @foreach ($this->getWidgets() as $key => $widget)
        @livewire($widget, ['filters' => $this->filters], key($key . '-' . json_encode($this->filters)))
    @endforeach
</x-filament-panels::page>
