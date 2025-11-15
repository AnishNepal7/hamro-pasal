<div class="metallic-card p-6">
    <h3 class="text-xl font-bold text-metallic-mid mb-4">{{ $title }}</h3>
    @forelse($items as $item)
        <div class="flex justify-between bg-steel-800/30 p-3 rounded mb-2">
            <span class="text-white">{{ $item->$nameKey }}</span>
            <span class="text-metallic-gold font-bold">{{ $unit ?? '' }}{{ number_format($item->$valueKey, 2) }}</span>
        </div>
    @empty
        <p class="text-steel-100 text-center py-2">No data</p>
    @endforelse
</div>
