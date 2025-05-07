<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Car Documents</h2>
                    <a href="{{ route('documents.car.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i> Add New Document
                    </a>
                </div>

                @if(session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                    <button wire:click="$set('message', null)" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

                <!-- Filters -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    placeholder="Search documents..."
                                    class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <select wire:model.live="type"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Types</option>
                                @foreach($documentTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="expiry_status"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Status</option>
                                <option value="expired">Expired</option>
                                <option value="expiring_soon">Expiring Soon (৩০ দিন বা এক মাসের কম)</option>
                                <option value="valid">Valid</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Documents Table -->
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Car
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="sortBy('document_type')">
                                    <div class="flex items-center">
                                        <span>Type</span>
                                        @if($sortField === 'document_type')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                        @else
                                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                    wire:click="sortBy('document_expiry_date')">
                                    <div class="flex items-center">
                                        <span>Expiry Date</span>
                                        @if($sortField === 'document_expiry_date')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                        @else
                                        <i class="fas fa-sort ml-1 text-gray-300"></i>
                                        @endif
                                    </div>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($documents as $document)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($document->car->photo)
                                        <div class="flex-shrink-0 h-10 w-10 mr-3">
                                            <img class="h-10 w-10 rounded-full object-cover"
                                                src="{{ asset('storage/' . $document->car->photo) }}"
                                                alt="{{ $document->car->name }}">
                                        </div>
                                        @else
                                        <div
                                            class="flex-shrink-0 h-10 w-10 mr-3 bg-gray-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-car text-gray-500"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $document->car->name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $document->car->plate_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $document->getTypeLabel() }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{
                                        $document->document_expiry_date->format('d/m/Y') }}</span>
                                    <span class="text-xs text-gray-500 block">{{
                                        $document->document_expiry_date->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($document->document_expiry_date->isPast())
                                        <span class="px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-circle mr-1"></i> Expired
                                        </span>
                                    @elseif($document->document_expiry_date->greaterThan(now()->addDays(30)))
                                        <span class="px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Valid
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Expiring Soon
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('documents.car.edit', $document) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ Storage::url($document->document_image) }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button wire:click="delete({{ $document->id }})"
                                        wire:confirm="Are you sure you want to delete this document?"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <div class="flex flex-col items-center justify-center py-6">
                                        <i class="fas fa-file-alt text-gray-300 text-5xl mb-4"></i>
                                        <p>No documents found.</p>
                                        <a href="{{ route('documents.car.create') }}"
                                            class="mt-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <i class="fas fa-plus mr-2"></i> Add Your First Document
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <x-modal wire:model="showEditModal">
        <x-slot name="title">Edit Car Document</x-slot>
        <x-slot name="content">
            <form wire:submit.prevent="update">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="edit_car_id" class="block text-sm font-medium text-gray-700">Car</label>
                        <select id="edit_car_id" wire:model.blur="car_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Car</option>
                            @foreach($cars as $car)
                            <option value="{{ $car->id }}">{{ $car->name }} ({{ $car->plate_number }})</option>
                            @endforeach
                        </select>
                        @error('car_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="edit_document_type" class="block text-sm font-medium text-gray-700">Document
                            Type</label>
                        <select id="edit_document_type" wire:model.blur="document_type"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach($documentTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('document_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="edit_document_expiry_date" class="block text-sm font-medium text-gray-700">Expiry
                            Date</label>
                        <input type="date" id="edit_document_expiry_date" wire:model.blur="document_expiry_date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('document_expiry_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="edit_document_comment"
                            class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea id="edit_document_comment" wire:model.blur="document_comment" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        @error('document_comment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="edit_document_image" class="block text-sm font-medium text-gray-700">Document
                            Image</label>
                        <input type="file" id="edit_document_image" wire:model="document_image" class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100">
                        @error('document_image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="document_image" class="mt-1 text-sm text-gray-500">
                            Uploading...
                        </div>
                        @if($editingDocument && $editingDocument->document_image)
                        <div class="mt-2 mb-2">
                            <a href="{{ Storage::url($editingDocument->document_image) }}" target="_blank"
                                class="text-sm text-indigo-600 hover:text-indigo-900 flex items-center">
                                <i class="fas fa-file-image mr-1"></i> View current document
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$set('showEditModal', false)"
                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-times mr-2"></i> Cancel
            </button>
            <button wire:click="update"
                class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-save mr-2"></i> Update Document
            </button>
        </x-slot>
    </x-modal>
</div>
