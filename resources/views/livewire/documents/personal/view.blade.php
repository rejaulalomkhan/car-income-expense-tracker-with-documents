<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Document Details</h2>
                        <a href="{{ route('documents.personal.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>Back to List
                        </a>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="flex items-center space-x-8">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-gray-400 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Document Name</div>
                                    <div class="text-sm text-gray-900">{{ $document->doc_name }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-folder text-gray-400 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Category</div>
                                    <div class="text-sm text-gray-900">{{ $document->doc_category }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Uploaded On</div>
                                    <div class="text-sm text-gray-900">{{ $document->created_at->format('F j, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-align-left text-gray-400 text-xl mr-3"></i>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Description</div>
                                    <div class="text-sm text-gray-900">{{ $document->doc_description ?: 'No description provided.' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-3 border-b flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">Document Preview</h3>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('documents.personal.edit', $document) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    <i class="fas fa-edit mr-2"></i> Edit Document
                                </a>
                                <a href="{{ Storage::url($document->doc_scancopy) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    <i class="fas fa-external-link-alt mr-2"></i> Open in New Tab
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @php
                                $extension = pathinfo($document->doc_scancopy, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                <img src="{{ Storage::url($document->doc_scancopy) }}" alt="{{ $document->doc_name }}" class="max-w-full h-auto mx-auto">
                            @elseif(strtolower($extension) === 'pdf')
                                <iframe src="{{ Storage::url($document->doc_scancopy) }}" class="w-full h-[900px]" frameborder="0"></iframe>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-file-alt text-6xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-500">This file type cannot be previewed directly.</p>
                                    <a href="{{ Storage::url($document->doc_scancopy) }}" target="_blank" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                        <i class="fas fa-download mr-2"></i> Download Document
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 