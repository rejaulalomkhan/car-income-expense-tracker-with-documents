<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Car Documents</h2>
                    <button wire:click="$set('showCreateModal', true)" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Document
                    </button>
                </div>

                <!-- Filters -->
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search documents..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex gap-4">
                            <select wire:model.live="type" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Types</option>
                                @foreach($documentTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <select wire:model.live="expiry_status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Status</option>
                                <option value="expired">Expired</option>
                                <option value="expiring_soon">Expiring Soon</option>
                                <option value="valid">Valid</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Documents Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Car
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('document_type')">
                                    Type
                                    @if($sortField === 'document_type')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('document_expiry_date')">
                                    Expiry Date
                                    @if($sortField === 'document_expiry_date')
                                        <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $document->car->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $document->getTypeLabel() }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $document->document_expiry_date->format('Y-m-d') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($document->document_expiry_date->isPast())
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Expired
                                            </span>
                                        @elseif($document->document_expiry_date->diffInDays(now()) <= 30)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Expiring Soon
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Valid
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="edit({{ $document->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                        <a href="{{ Storage::url($document->document_image) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                        <button wire:click="delete({{ $document->id }})" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No documents found.
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

    <!-- Create Modal -->
    <x-modal wire:model="showCreateModal">
        <x-slot name="title">Add New Car Document</x-slot>
        <x-slot name="content">
            <form wire:submit="create">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="car_id" class="block text-sm font-medium text-gray-700">Car</label>
                        <select id="car_id" wire:model="car_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Car</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->name }}</option>
                            @endforeach
                        </select>
                        @error('car_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="document_type" class="block text-sm font-medium text-gray-700">Document Type</label>
                        <select id="document_type" wire:model="document_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach($documentTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('document_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="document_expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                        <input type="date" id="document_expiry_date" wire:model="document_expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('document_expiry_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="document_comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea id="document_comment" wire:model="document_comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        @error('document_comment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="document_image" class="block text-sm font-medium text-gray-700">Document Image</label>
                        <input type="file" id="document_image" wire:model="document_image" class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100">
                        @error('document_image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$set('showCreateModal', false)" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Cancel
            </button>
            <button wire:click="create" class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Save Document
            </button>
        </x-slot>
    </x-modal>

    <!-- Edit Modal -->
    <x-modal wire:model="showEditModal">
        <x-slot name="title">Edit Car Document</x-slot>
        <x-slot name="content">
            <form wire:submit="update">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="edit_car_id" class="block text-sm font-medium text-gray-700">Car</label>
                        <select id="edit_car_id" wire:model="car_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Car</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->name }}</option>
                            @endforeach
                        </select>
                        @error('car_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="edit_document_type" class="block text-sm font-medium text-gray-700">Document Type</label>
                        <select id="edit_document_type" wire:model="document_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach($documentTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('document_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="edit_document_expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                        <input type="date" id="edit_document_expiry_date" wire:model="document_expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @error('document_expiry_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="edit_document_comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea id="edit_document_comment" wire:model="document_comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        @error('document_comment') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="edit_document_image" class="block text-sm font-medium text-gray-700">Document Image</label>
                        <input type="file" id="edit_document_image" wire:model="document_image" class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100">
                        @error('document_image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @if($editingDocument && $editingDocument->document_image)
                            <div class="mt-2">
                                <a href="{{ Storage::url($editingDocument->document_image) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900">View current image</a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$set('showEditModal', false)" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Cancel
            </button>
            <button wire:click="update" class="ml-3 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Update Document
            </button>
        </x-slot>
    </x-modal>
</div> 