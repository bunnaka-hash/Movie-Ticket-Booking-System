<!-- Section Title Component -->
@props(['icon' => 'fa-film', 'title', 'subtitle' => null, 'action' => null, 'actionText' => 'View All'])

<div class="flex justify-between items-start md:items-center mb-12 flex-col md:flex-row gap-4">
    <div>
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-2 flex items-center gap-3">
            <i class="fas {{ $icon }} text-primary"></i>
            {{ $title }}
        </h2>
        @if($subtitle)
            <p class="text-gray-400">{{ $subtitle }}</p>
        @endif
    </div>
    @if($action)
        <a href="{{ $action }}" class="text-primary hover:text-red-400 transition font-semibold flex items-center gap-2 whitespace-nowrap">
            {{ $actionText }}
            <i class="fas fa-arrow-right"></i>
        </a>
    @endif
</div>
