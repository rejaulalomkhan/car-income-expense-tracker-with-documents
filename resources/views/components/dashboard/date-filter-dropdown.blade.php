@props(['dateFilterLabel'])

<div class="relative" 
     x-data="{ 
        open: false,
        init() {
            this.$watch('open', value => {
                if (value) {
                    this.$nextTick(() => {
                        this.$refs.dropdown.style.zIndex = 9999;
                        this.$refs.dropdown.style.position = 'absolute';
                    });
                }
            });
        }
     }" 
     style="position: relative; overflow: visible !important;">
    <div @click="open = !open" class="flex items-center justify-between appearance-none bg-white border border-gray-300 rounded-md pl-10 pr-8 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer">
        <span x-text="$wire.dateFilterLabel || 'This Month'"></span>
        <div class="absolute left-3 top-2.5 text-gray-400 cursor-pointer" @click.stop="open = !open">
            <i class="fas fa-filter"></i>
        </div>
        <div class="absolute right-3 top-2.5 text-gray-400 cursor-pointer" @click.stop="open = !open">
            <i class="fas fa-chevron-down" :class="{'transform rotate-180': open}"></i>
        </div>
    </div>
    
    <div x-show="open" 
         x-ref="dropdown"
         @click.outside="open = false" 
         x-init="$el.style.zIndex = 9999" 
         class="absolute z-[9999] mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg py-1 date-filter-dropdown" 
         style="display: none;" 
         x-transition:enter="transition ease-out duration-100" 
         x-transition:enter-start="transform opacity-0 scale-95" 
         x-transition:enter-end="transform opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="transform opacity-100 scale-100" 
         x-transition:leave-end="transform opacity-0 scale-95">
        <div class="px-2 py-1 cursor-pointer hover:bg-gray-100" wire:click="setDateFilter('today'); $dispatch('close')" @click="open = false">Today</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-gray-100" wire:click="setDateFilter('yesterday'); $dispatch('close')" @click="open = false">Yesterday</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-gray-100" wire:click="setDateFilter('this_month'); $dispatch('close')" @click="open = false">This Month</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-gray-100" wire:click="setDateFilter('last_month'); $dispatch('close')" @click="open = false">Last Month</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-gray-100" wire:click="setDateFilter('this_year'); $dispatch('close')" @click="open = false">This Year</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-gray-100" wire:click="setDateFilter('last_year'); $dispatch('close')" @click="open = false">Last Year</div>
        <div class="px-2 py-1 cursor-pointer hover:bg-gray-100" wire:click="setDateFilter('custom'); $dispatch('close')" @click="open = false; window.dispatchEvent(new Event('openDateRangePicker'))">Custom Range</div>
    </div>
    
    <select wire:model.live="dateFilter" class="hidden">
        <option value="today">Today</option>
        <option value="yesterday">Yesterday</option>
        <option value="this_month" selected>This Month</option>
        <option value="last_month">Last Month</option>
        <option value="this_year">This Year</option>
        <option value="last_year">Last Year</option>
        <option value="custom">Custom Range</option>
    </select>
</div> 