<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Settings</h2>

                @if (session('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
                @endif

                <form wire:submit="save" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="appName" class="block text-sm font-medium text-gray-700">Application Name
                                    *</label>
                                <input type="text" id="appName" wire:model="appName"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('appName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="contactEmail" class="block text-sm font-medium text-gray-700">Contact Email
                                    *</label>
                                <input type="email" id="contactEmail" wire:model="contactEmail"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('contactEmail') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="contactPhone" class="block text-sm font-medium text-gray-700">Contact
                                    Phone</label>
                                <input type="text" id="contactPhone" wire:model="contactPhone"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('contactPhone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="theme" class="block text-sm font-medium text-gray-700">Theme</label>
                                <select id="theme" wire:model="theme"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="light">Light</option>
                                    <option value="dark">Dark</option>
                                </select>
                                @error('theme') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                                <select id="language" wire:model="language"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="en">English</option>
                                    <option value="bn">Bengali</option>
                                </select>
                                @error('language') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Application Logo</label>
                                @if($currentLogo)
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $currentLogo) }}" alt="Current logo"
                                        class="h-12 w-auto">
                                </div>
                                @endif
                                <input type="file" wire:model="logo" id="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-medium
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                                @error('logo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="logo" class="mt-1 text-sm text-gray-500">
                                    Uploading...
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Application Icon</label>
                                @if($currentIcon)
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $currentIcon) }}" alt="Current icon"
                                        class="h-12 w-auto">
                                </div>
                                @endif
                                <input type="file" wire:model="icon" id="icon" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-medium
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                                @error('icon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="icon" class="mt-1 text-sm text-gray-500">
                                    Uploading...
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-save mr-2"></i> Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>