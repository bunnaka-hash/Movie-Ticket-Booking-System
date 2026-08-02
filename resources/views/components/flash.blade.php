@php
    // session key => [icon, colour classes]
    $flashes = [
        'success' => ['fa-circle-check', 'bg-green-900/40 border-green-700 text-green-100'],
        'error'   => ['fa-circle-exclamation', 'bg-red-900/40 border-red-700 text-red-100'],
        'warning' => ['fa-triangle-exclamation', 'bg-yellow-900/40 border-yellow-700 text-yellow-100'],
        'status'  => ['fa-circle-info', 'bg-blue-900/40 border-blue-700 text-blue-100'],
    ];
@endphp

@foreach ($flashes as $key => [$icon, $classes])
    @if (session($key))
        <div class="flex items-start gap-3 border {{ $classes }} px-4 py-3 rounded-lg mb-4" role="alert">
            <i class="fas {{ $icon }} mt-1"></i>
            <p class="flex-1 text-sm">{{ session($key) }}</p>
            <button type="button"
                    onclick="this.closest('[role=alert]').remove()"
                    class="text-current opacity-60 hover:opacity-100 transition"
                    aria-label="Dismiss">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="border bg-red-900/40 border-red-700 text-red-100 px-4 py-3 rounded-lg mb-4" role="alert">
        <div class="flex items-start gap-3">
            <i class="fas fa-circle-exclamation mt-1"></i>
            <div class="flex-1">
                <p class="text-sm font-semibold mb-1">Please fix the following:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button"
                    onclick="this.closest('[role=alert]').remove()"
                    class="text-current opacity-60 hover:opacity-100 transition"
                    aria-label="Dismiss">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    </div>
@endif
