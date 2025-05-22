<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Personal Documents</h2>
                        <a href="{{ route('documents.personal.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i>Add New Document
                        </a>
                    </div>

                    <div class="mb-6 flex gap-4">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" wire:model.live="search" placeholder="Search documents..." class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                        </div>
                        <div class="w-64">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-filter text-gray-400"></i>
                                </div>
                                <select wire:model.live="category" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documents as $document)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('documents.personal.view', $document) }}">
                                                <div class="flex items-center">                                               
                                                    <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                                    <div class="text-sm font-medium text-blue-900">{{ $document->doc_name }}</div>                                                
                                                </div>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-folder text-gray-400 mr-2"></i>
                                                <div class="text-sm text-gray-500">{{ $document->doc_category }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-align-left text-gray-400 mr-2"></i>
                                                <div class="text-sm text-gray-500">{{ $document->doc_description ?: 'No description' }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-4">
                                                <a href="{{ route('documents.personal.view', $document) }}" class="text-red-700 hover:text-blue-900 transition-colors duration-200" title="View Document">
                                                    <i class="fas fa-file-pdf text-lg"></i>
                                                </a>
                                                <a href="{{ route('documents.personal.edit', $document) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200" title="Edit Document">
                                                    <i class="fas fa-pencil-alt text-lg"></i>
                                                </a>
                                                <button wire:click="delete({{ $document->id }})" class="text-red-600 hover:text-red-900 transition-colors duration-200" onclick="confirm('Are you sure you want to delete this document?') || event.stopImmediatePropagation()" title="Delete Document">
                                                    <i class="fas fa-trash-alt text-lg"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            <i class="fas fa-folder-open text-4xl mb-2"></i>
                                            <p>No documents found.</p>
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
    </div>
</div> 