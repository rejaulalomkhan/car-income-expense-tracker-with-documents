<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Cars</h2>
                        <a href="{{ route('cars.create') }}" wire:navigate
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i> Add New Car
                        </a>
                    </div>

                    @if(session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                    @endif

                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search cars..."
                                class="w-full pl-10 pr-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortBy('name')">
                                        <div class="flex items-center">
                                            <span>Name</span>
                                            @if($sortField === 'name')
                                            <i
                                                class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                            @else
                                            <i class="fas fa-sort ml-1 text-gray-300"></i>
                                            @endif
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortBy('plate_number')">
                                        <div class="flex items-center">
                                            <span>Plate Number</span>
                                            @if($sortField === 'plate_number')
                                            <i
                                                class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                            @else
                                            <i class="fas fa-sort ml-1 text-gray-300"></i>
                                            @endif
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                        wire:click="sortBy('model')">
                                        <div class="flex items-center">
                                            <span>Model</span>
                                            @if($sortField === 'model')
                                            <i
                                                class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                            @else
                                            <i class="fas fa-sort ml-1 text-gray-300"></i>
                                            @endif
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($cars as $car)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($car->photo)
                                            <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="{{ asset('storage/' . $car->photo) }}" alt="{{ $car->name }}">
                                            </div>
                                            @else
                                            <div
                                                class="flex-shrink-0 h-10 w-10 mr-3 bg-gray-200 rounded-full flex items-center justify-center">
                                                <i class="fas fa-car text-gray-500"></i>
                                            </div>
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">{{ $car->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $car->plate_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $car->model }} {{ $car->year ? '(' .
                                            $car->year . ')' : '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('cars.edit', $car) }}" wire:navigate
                                            class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <button wire:click="delete({{ $car->id }})"
                                            wire:confirm="Are you sure you want to delete this car? All related expenses, incomes and documents will be deleted."
                                            class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center justify-center py-6">
                                            <i class="fas fa-car text-gray-300 text-5xl mb-4"></i>
                                            <p>No cars found.</p>
                                            <a href="{{ route('cars.create') }}" wire:navigate
                                                class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                <i class="fas fa-plus mr-2"></i> Add Your First Car
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $cars->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
