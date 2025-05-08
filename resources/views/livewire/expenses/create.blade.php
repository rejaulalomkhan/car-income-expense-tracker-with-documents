<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add New Expense</h2>

                @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <form wire:submit="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="car_id" class="block text-sm font-medium text-gray-700">Car *</label>
                            <select id="car_id" wire:model="car_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('car_id') border-red-300 @enderror">
                                <option value="">Select a car</option>
                                @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->name }}</option>
                                @endforeach
                            </select>
                            @error('car_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date *</label>
                            <input type="date" id="date" wire:model="date"
                                placeholder="Select date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('date') border-red-300 @enderror">
                            @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount *</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">৳</span>
                                </div>
                                <input type="number" id="amount" wire:model="amount" step="0.01"
                                    placeholder="Enter amount (e.g., 1000)"
                                    class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('amount') border-red-300 @enderror">
                            </div>
                            @error('amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                            <select id="category" wire:model="category"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('category') border-red-300 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description
                                *</label>
                            <textarea id="description" wire:model="description" rows="3"
                                placeholder="Enter expense description (e.g., Regular maintenance service)"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-300 @enderror"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2 mt-6 flex justify-end">
                            <a href="{{ route('expenses.index') }}"
                                class="mr-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Save Expense
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
