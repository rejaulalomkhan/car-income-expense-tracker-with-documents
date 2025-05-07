<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">Add New Document of Barsha Enterprise</h2>
                        <p class="mt-1 text-sm text-gray-600">Enter the document details below. Required fields are
                            marked with *</p>
                    </div>
                    <a href="{{ route('documents.company.index') }}"
                        class="inline-flex items-center px-3 py-1.5 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring ring-gray-300 disabled:opacity-25 transition">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>

                <form wire:submit="save" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="document_type_id" class="block text-sm font-medium text-gray-700">Document
                                    Type *</label>
                                <select id="document_type_id" wire:model="document_type_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('document_type_id') border-red-300 @enderror">
                                    <option value="">Select document type</option>
                                    @foreach($documentTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('document_type_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
                                <input type="text" id="title" wire:model="title"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('title') border-red-300 @enderror">
                                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" wire:model="description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-300 @enderror"
                                    placeholder="Enter additional details about the document"></textarea>
                                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date
                                    *</label>
                                <input type="date" id="issue_date" wire:model="issue_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('issue_date') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Date format: DD/MM/YYYY (
                                    <?php echo date('d/m/Y'); ?>)
                                </p>
                                @error('issue_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date
                                    *</label>
                                <input type="date" id="expiry_date" wire:model="expiry_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('expiry_date') border-red-300 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Must be after issue date</p>
                                @error('expiry_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="document_file" class="block text-sm font-medium text-gray-700">Document File
                                    *</label>
                                <input type="file" id="document_file" wire:model="document_file" class="mt-1 block w-full text-sm text-gray-500 @error('document_file') border-red-300 @enderror
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-xs file:font-medium
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                                <p class="mt-1 text-xs text-gray-500">Maximum file size: 10MB</p>
                                @error('document_file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                                <div wire:loading wire:target="document_file" class="mt-1 text-xs text-indigo-600">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Uploading...
                                </div>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="is_active"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-600">Document is active</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                        <a href="{{ route('documents.company.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-times mr-2"></i> Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-save mr-2"></i> Save Document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
