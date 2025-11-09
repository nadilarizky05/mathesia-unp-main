<div class="space-y-4">
    {{-- Info Header --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 space-y-2">
        <div class="flex items-center gap-2">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Siswa:</span>
            <span class="text-gray-900 dark:text-white">{{ $studentName }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Section:</span>
            <span class="text-gray-900 dark:text-white">{{ $sectionTitle }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Field:</span>
            <span
                class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-900 px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">
                {{ $fieldName }}
            </span>
        </div>
    </div>

    {{-- Image Preview --}}
    @if($imageUrl)
        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg p-4 flex items-center justify-center min-h-[400px]">
            <img src="{{ $imageUrl }}" alt="Preview Jawaban"
                class="max-w-full max-h-[600px] rounded-lg shadow-lg object-contain" loading="lazy" />
        </div>
    @else
        <div
            class="bg-gray-100 dark:bg-gray-900 rounded-lg p-8 flex flex-col items-center justify-center min-h-[400px] space-y-3">
            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <p class="text-gray-500 dark:text-gray-400 text-center">Tidak ada gambar tersedia</p>
        </div>
    @endif
</div>