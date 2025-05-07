<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add New Car</h2>

                    @if (session()->has('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif

                    <form wire:submit.prevent="save">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                                <input type="text" wire:model="name" id="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 @enderror">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="plate_number" class="block text-sm font-medium text-gray-700">Plate Number
                                    *</label>
                                <input type="text" wire:model="plate_number" id="plate_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('plate_number') border-red-300 @enderror">
                                @error('plate_number') <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                                <input type="text" wire:model="model" id="model"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('model') border-red-300 @enderror">
                                @error('model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                                <input type="number" wire:model="year" id="year"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('year') border-red-300 @enderror">
                                @error('year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                                <input type="text" wire:model="color" id="color"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('color') border-red-300 @enderror">
                                @error('color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                                <input type="file" wire:model="photo" id="photo" class="mt-1 block w-full text-sm text-gray-500 @error('photo') border-red-300 @enderror
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                                @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="photo" class="mt-1 text-sm text-gray-500">
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
                                <i class="fas fa-save mr-2"></i> Save Car
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
