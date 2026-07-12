@props([
    'pagination' => null,
    'totalItems' => 0,
    'itemLabel' => 'item'
])

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <!-- Table Container (Responsive) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            {{ $slot }}
        </table>
    </div>
    
    <!-- Pagination Footer -->
    @if($pagination && method_exists($pagination, 'firstItem'))
        <div class="px-4 py-4 md:px-6 md:py-5 border-t border-slate-100 bg-slate-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <span class="text-sm text-slate-600">
                Menampilkan 
                <span class="font-medium">{{ $pagination->firstItem() ?? 0 }}</span> – 
                <span class="font-medium">{{ $pagination->lastItem() ?? 0 }}</span> dari 
                <span class="font-medium">{{ $totalItems }}</span> {{ $itemLabel }}
            </span>
            <div class="text-sm font-medium text-slate-700">
                {{ $pagination->links() }}
            </div>
        </div>
    @endif
</div>
