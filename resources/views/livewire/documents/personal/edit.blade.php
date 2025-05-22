<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Edit Personal Document</h2>
                        <a href="{{ route('documents.personal.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>Back to List
                        </a>
                    </div>

                    <div class="grid grid-cols-5 gap-6">
                        <div class="col-span-2">
                            <form wire:submit="save" class="space-y-6">
                                <div>
                                    <x-input-label for="doc_name" value="Document Name *" />
                                    <x-text-input wire:model="doc_name" id="doc_name" type="text" class="mt-1 block w-full" required />
                                    <x-input-error :messages="$errors->get('doc_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="doc_category" value="Documents Category *" />
                                    <select wire:model="doc_category" id="doc_category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('doc_category')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="doc_scancopy" value="Update Document Scan" />
                                    <input type="file" wire:model="doc_scancopy" id="doc_scancopy" class="mt-1 block w-full">
                                    <x-input-error :messages="$errors->get('doc_scancopy')" class="mt-2" />
                                    <p class="mt-1 text-sm text-gray-500">Leave empty to keep the current document. Maximum file size: 20MB. Supported formats: PDF, JPG, JPEG, PNG</p>
                                </div>

                                <div>
                                    <x-input-label for="doc_description" value="Description" />
                                    <textarea wire:model="doc_description" id="doc_description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" placeholder="Enter any additional details about the document..."></textarea>
                                    <x-input-error :messages="$errors->get('doc_description')" class="mt-2" />
                                </div>

                                <div class="flex justify-end">
                                    <x-secondary-button type="button" onclick="window.location.href='{{ route('documents.personal.index') }}'">
                                        Cancel
                                    </x-secondary-button>
                                    <x-primary-button class="ml-3">
                                        Update Document
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>

                        <div class="col-span-3">
                            <div class="border rounded-lg overflow-hidden">
                                <div class="bg-gray-50 px-6 py-3 border-b">
                                    <h3 class="text-lg font-medium text-gray-900">Current Document</h3>
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
    </div>
</div> 