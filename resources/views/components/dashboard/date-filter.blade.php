@props(['startDate', 'endDate', 'dateFilterLabel'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-4 sm:p-6">
        <!-- Mobile Layout -->
        <div class="block sm:hidden mb-4">
            <div class="text-base font-semibold text-gray-700 text-center mb-3" id="selected-period-mobile">
                {{ now()->format('F Y') }}
            </div>

            <div class="flex flex-col space-y-2">
                <div class="relative w-full flex items-center">
                    <input type="text" id="date-range-mobile" placeholder="Select date range"
                        class="w-full appearance-none bg-white border border-gray-300 rounded-md pl-10 pr-8 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        readonly>
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <button type="button"
                        onclick="spinAndReload(this)"
                        class="ml-2 p-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-blue-600 transition"
                        title="Reload">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <x-dashboard.date-filter-dropdown :dateFilterLabel="$dateFilterLabel" />
            </div>
        </div>

        <!-- Desktop Layout -->
        <div class="hidden sm:flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="relative flex items-center">
                    <input type="text" id="date-range" placeholder="Select date range"
                        class="appearance-none bg-white border border-gray-300 rounded-md pl-10 pr-8 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        readonly>
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <button type="button"
                        onclick="spinAndReload(this)"
                        class="ml-2 p-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-blue-600 transition"
                        title="Reload">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

                <x-dashboard.date-filter-dropdown :dateFilterLabel="$dateFilterLabel" />
            </div>

            <div class="text-lg font-semibold text-gray-700" id="selected-period">
                {{ now()->format('F Y') }}
            </div>
        </div>

        <input type="hidden" wire:model.live="startDate" id="start-date">
        <input type="hidden" wire:model.live="endDate" id="end-date">
    </div>
</div> 