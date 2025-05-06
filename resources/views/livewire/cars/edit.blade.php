<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Car</h2>

                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" wire:model.blur="name" id="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="plate_number" class="block text-sm font-medium text-gray-700">Plate
                                    Number</label>
                                <input type="text" wire:model.blur="plate_number" id="plate_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('plate_number') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                                <input type="text" wire:model.blur="model" id="model"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                                <input type="number" wire:model.blur="year" id="year"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                                <input type="text" wire:model.blur="color" id="color"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="new_photo" class="block text-sm font-medium text-gray-700">Photo</label>
                                @if($photo)
                                <div class="mt-2 mb-2">
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Current car photo"
                                        class="h-32 w-auto object-cover rounded-md border border-gray-200">
                                </div>
                                @endif
                                <input type="file" wire:model="new_photo" id="new_photo" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                                @error('new_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="new_photo" class="mt-1 text-sm text-gray-500">
                                    Uploading...
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('cars.index') }}" wire:navigate
                                class="mr-3 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fas fa-save mr-2"></i> Update Car
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
