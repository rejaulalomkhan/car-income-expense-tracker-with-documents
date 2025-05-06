<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Add New Car Document</h2>
                        <a href="{{ route('documents.car.index') }}"
                            class="inline-flex items-center px-3 py-1.5 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring ring-gray-300 disabled:opacity-25 transition">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>

                    <form wire:submit="save" class="space-y-4">
                        <!-- Dropdowns in a single row for PC -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="car_id" class="block text-sm font-medium text-gray-700">Car</label>
                                <select id="car_id" wire:model="car_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                    <option value="">Select a car</option>
                                    @foreach($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->name }}</option>
                                    @endforeach
                                </select>
                                @error('car_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="document_type" class="block text-sm font-medium text-gray-700">Document
                                    Type</label>
                                <select id="document_type" wire:model="document_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                    @foreach($documentTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('document_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="document_expiry_date" class="block text-sm font-medium text-gray-700">Expiry
                                    Date</label>
                                <input type="date" id="document_expiry_date" wire:model="document_expiry_date"
                                    value="{{ date('Y-m-d') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                                <p class="text-xs text-gray-500 mt-1">তারিখ/মাস/বছর ফরম্যাটে (
                                    <?php echo date('d/m/Y'); ?>)
                                </p>
                                @error('document_expiry_date') <span class="text-red-500 text-xs mt-1">{{ $message
                                    }}</span> @enderror
                            </div>
                        </div>

                        <!-- Document image upload and comment -->
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div>
                                <label for="document_image" class="block text-sm font-medium text-gray-700">Document
                                    Image</label>
                                <input type="file" id="document_image" wire:model="document_image" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-3 file:py-1.5 file:px-3
                                    file:rounded-md file:border-0
                                    file:text-xs file:font-medium
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                                @error('document_image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                                <div wire:loading wire:target="document_image" class="mt-1 text-xs text-gray-500">
                                    Uploading...
                                </div>
                            </div>

                            <div>
                                <label for="document_comment"
                                    class="block text-sm font-medium text-gray-700">Comment</label>
                                <textarea id="document_comment" wire:model="document_comment" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"></textarea>
                                @error('document_comment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <a href="{{ route('documents.car.index') }}"
                                class="inline-flex items-center px-3 py-1.5 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring ring-gray-300 disabled:opacity-25 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="ml-3 inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring ring-indigo-300 disabled:opacity-25 transition">
                                <i class="fas fa-save mr-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
