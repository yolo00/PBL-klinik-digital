@props([
    'backUrl' => '#',
    'submitLabel' => 'Simpan Data',
    'submitType' => 'primary'
])

<div class="mt-8 flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-slate-100">
    <a 
        href="{{ $backUrl }}" 
        class="w-full sm:w-auto px-6 py-2.5 rounded-lg text-slate-700 bg-slate-100 hover:bg-slate-200 font-medium text-sm transition-colors"
    >
        Batal
    </a>
    <button 
        type="submit"
        class="w-full sm:w-auto px-6 py-2.5 rounded-lg text-white font-medium text-sm transition-colors shadow-sm {{ $submitType === 'primary' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-rose-600 hover:bg-rose-700' }}"
    >
        {{ $submitLabel }}
    </button>
</div>
