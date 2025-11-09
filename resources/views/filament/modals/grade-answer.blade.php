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

    {{-- Question Section --}}
    @if($questionText || $questionImageUrl)
        <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-2">Pertanyaan Soal:</h4>

                    @if($questionText)
                        <p class="text-sm text-amber-900 dark:text-amber-200 leading-relaxed">{{ $questionText }}</p>
                    @endif

                    @if($questionImageUrl)
                        <div
                            class="mt-3 bg-white dark:bg-gray-800 rounded-lg p-3 border border-amber-200 dark:border-amber-700">
                            <img src="{{ $questionImageUrl }}" alt="Gambar Soal" class="max-w-full h-auto rounded"
                                loading="lazy">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

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