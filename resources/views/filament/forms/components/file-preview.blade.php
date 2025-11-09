<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $answerFile = $getState();
    @endphp

    <div class="rounded-lg border border-gray-200 bg-white overflow-hidden">
        @if($answerFile)
            @php
                $extension = strtolower(pathinfo($answerFile, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $isPdf = $extension === 'pdf';
                $fileUrl = Storage::disk('public')->url($answerFile);
            @endphp

            @if($isImage)
                {{-- Preview Gambar --}}
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">📎 File Jawaban (Gambar)</span>
                    <a href="{{ $fileUrl }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Buka di Tab Baru →
                    </a>
                </div>
                <div class="p-4 bg-white">
                    <img src="{{ $fileUrl }}" alt="Jawaban Siswa"
                        class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200"
                        style="max-height: 600px; object-fit: contain;" />
                </div>
            @elseif($isPdf)
                {{-- Preview PDF --}}
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">📄 File Jawaban (PDF)</span>
                    <a href="{{ $fileUrl }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Buka PDF →
                    </a>
                </div>
                <div class="p-4 bg-white">
                    <iframe src="{{ $fileUrl }}" class="w-full rounded-lg border border-gray-200"
                        style="height: 600px;"></iframe>
                </div>
            @else
                {{-- File Lainnya --}}
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                    <span class="text-sm font-medium text-gray-700">📎 File Jawaban</span>
                </div>
                <div class="p-4 bg-white text-center">
                    <div class="inline-flex items-center gap-2 text-gray-600 mb-3">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ basename($answerFile) }}</p>
                    <a href="{{ $fileUrl }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download File
                    </a>
                </div>
            @endif
        @else
            {{-- Tidak Ada File --}}
            <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                <span class="text-sm font-medium text-gray-500">📎 File Jawaban</span>
            </div>
            <div class="p-6 bg-gray-50 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-sm text-gray-500">Tidak ada file jawaban</p>
            </div>
        @endif
    </div>
</x-dynamic-component>