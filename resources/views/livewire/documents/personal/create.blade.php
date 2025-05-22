<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg sm:text-2xl font-semibold">Add New Personal Document</h2>
                        <a href="{{ route('documents.personal.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-1.5 px-3 sm:py-2 sm:px-4 rounded text-xs sm:text-base">
                            <i class="fas fa-arrow-left mr-1 sm:mr-2"></i><span class="hidden xs:inline">Back to List</span><span class="inline xs:hidden">Back</span>
                        </a>
                    </div>

                    <form wire:submit="save" class="space-y-6">
                        <div class="grid grid-cols-2 gap-6">
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
                                <x-input-label for="doc_name" value="Document Name *" />
                                <x-text-input wire:model="doc_name" id="doc_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('doc_name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                            <div class="text-center">
                                <x-input-label for="doc_scancopy" value="Upload Document Scan Copy *" class="text-lg font-semibold" />
                                
                                <div class="mt-4">
                                    <input type="file" wire:model="doc_scancopy" id="doc_scancopy" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100" required>
                                </div>
                                <x-input-error :messages="$errors->get('doc_scancopy')" class="mt-2" />
                                <div wire:loading wire:target="doc_scancopy" class="mt-1 text-sm text-gray-500">
                                    Uploading...
                                </div>
                                <div wire:loading.remove wire:target="doc_scancopy" class="mt-1 text-sm text-gray-500">
                                    <p><span class="font-medium">Maximum file size:</span> 20MB , <span class="font-medium">Supported formats:</span> PDF, JPG, JPEG, PNG</p>
                                </div>
                            </div>
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
                                Save Document
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 