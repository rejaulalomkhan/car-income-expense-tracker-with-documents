<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add New Income</h2>

                @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <form wire:submit="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="car_id" class="block text-sm font-medium text-gray-700">Car *</label>
                            <select wire:model="car_id" id="car_id"
                                class="mt-1 block w-full form-select rounded-md @error('car_id') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a car</option>
                                @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->name }}</option>
                                @endforeach
                            </select>
                            @error('car_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date *</label>
                            <input type="date" wire:model="date" id="date"
                                placeholder="Select date"
                                class="mt-1 block w-full form-input rounded-md @error('date') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-indigo-500">
                            @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">৳</span>
                                </div>
                                <input type="number" wire:model="amount" id="amount" step="0.01"
                                    placeholder="Enter amount (e.g., 5000)"
                                    class="pl-7 block w-full form-input rounded-md @error('amount') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="source" class="block text-sm font-medium text-gray-700">Source *</label>
                            <input type="text" wire:model="source" id="source"
                                placeholder="Enter income source (e.g., Rental, Service)"
                                class="mt-1 block w-full form-input rounded-md @error('source') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-indigo-500">
                            @error('source') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="description" id="description" rows="3"
                                placeholder="Enter income description (optional)"
                                class="mt-1 block w-full form-textarea rounded-md @error('description') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('incomes.index') }}"
                            class="mr-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Save Income
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
