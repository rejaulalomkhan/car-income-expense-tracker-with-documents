<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section with Date Filter and Month Display -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-4 sm:p-6">
                <!-- Mobile Layout -->
                <div class="block sm:hidden mb-4">
                    <!-- Current Period Display for Mobile -->
                    <div class="text-base font-semibold text-gray-700 text-center mb-3" id="selected-period-mobile">
                        {{ now()->format('F Y') }}
                    </div>

                    <div class="flex flex-col space-y-2">
                        <!-- Date Range Picker -->
                        <div class="relative w-full">
                            <input type="text" id="date-range-mobile" placeholder="Select date range"
                                class="w-full appearance-none bg-white border border-gray-300 rounded-md pl-10 pr-8 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                readonly>
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>

                        <!-- Quick Date Filters Dropdown -->
                        <div class="relative w-full">
                            <select wire:model.live="dateFilter" id="date-filter-mobile"
                                class="w-full appearance-none bg-white border border-gray-300 rounded-md pl-10 pr-8 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="this_month" selected>This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="this_year">This Year</option>
                                <option value="last_year">Last Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-filter"></i>
                            </div>
                            <div class="absolute right-3 top-2.5 text-gray-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Layout -->
                <div class="hidden sm:flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <!-- Date Range Picker -->
                        <div class="relative">
                            <input type="text" id="date-range" placeholder="Select date range"
                                class="appearance-none bg-white border border-gray-300 rounded-md pl-10 pr-8 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                readonly>
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>

                        <!-- Quick Date Filters Dropdown -->
                        <div class="relative">
                            <select wire:model.live="dateFilter" id="date-filter"
                                class="appearance-none bg-white border border-gray-300 rounded-md pl-10 pr-8 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="this_month" selected>This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="this_year">This Year</option>
                                <option value="last_year">Last Year</option>
                                <option value="custom">Custom Range</option>
                            </select>
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-filter"></i>
                            </div>
                            <div class="absolute right-3 top-2.5 text-gray-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Current Period Display for Desktop -->
                    <div class="text-lg font-semibold text-gray-700" id="selected-period">
                        {{ now()->format('F Y') }}
                    </div>
                </div>

                <!-- Hidden inputs for Livewire model binding -->
                <input type="hidden" wire:model.live="startDate" id="start-date">
                <input type="hidden" wire:model.live="endDate" id="end-date">
            </div>
        </div>

        <!-- Statistics Cards in Single Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Income Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow transition p-4 border border-gray-100">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 p-2 rounded-lg bg-green-50">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 mb-1">Total Income</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_income'], 2) }}</div>
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $percentageChanges['income'] >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $percentageChanges['income'] >= 0 ? '+' : '' }}{{ number_format($percentageChanges['income'], 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Expenses Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow transition p-4 border border-gray-100">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 p-2 rounded-lg bg-red-50">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8 8V4" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 mb-1">Total Expenses</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_expense'], 2) }}</div>
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $percentageChanges['expense'] >= 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $percentageChanges['expense'] >= 0 ? '+' : '' }}{{ number_format($percentageChanges['expense'], 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Net Income Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow transition p-4 border border-gray-100">
                <div class="flex items-center space-x-4">
                    <div
                        class="flex-shrink-0 p-2 rounded-lg {{ $stats['net_income'] >= 0 ? 'bg-blue-50' : 'bg-orange-50' }}">
                        <svg class="w-5 h-5 {{ $stats['net_income'] >= 0 ? 'text-blue-600' : 'text-orange-600' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 mb-1">Net Income</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-gray-900">${{ number_format($stats['net_income'], 2) }}</div>
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $percentageChanges['net_income'] >= 0 ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ $percentageChanges['net_income'] >= 0 ? '+' : '' }}{{ number_format($percentageChanges['net_income'], 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profit Margin Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow transition p-4 border border-gray-100">
                <div class="flex items-center space-x-4">
                    <div
                        class="flex-shrink-0 p-2 rounded-lg {{ $stats['profit_margin'] >= 0 ? 'bg-indigo-50' : 'bg-pink-50' }}">
                        <svg class="w-5 h-5 {{ $stats['profit_margin'] >= 0 ? 'text-indigo-600' : 'text-pink-600' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 mb-1">Profit Margin</p>
                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['profit_margin'], 1) }}%</div>
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $percentageChanges['profit_margin'] >= 0 ? 'bg-indigo-100 text-indigo-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $percentageChanges['profit_margin'] >= 0 ? '+' : '' }}{{ number_format($percentageChanges['profit_margin'], 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Income VS Expense Transactions -->

        <div class="max-w-full overflow-x-auto mt-6 mb-11">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden text-center text-xs">
                <thead>
                    <tr>
                        <th colspan="{{ count($cars) + 3 }}"
                            class="bg-sky-200 text-sky-800 px-4 py-2 border border-gray-300">
                            <div class="flex justify-between items-center">
                                <a href="{{ route('incomes.create') }}"
                                    class="inline-flex items-center px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-[10px] sm:text-sm font-medium rounded-full transition duration-150 ease-in-out">
                                    <i class="fas fa-plus text-[8px] sm:text-xs mr-1"></i>
                                    Add Income
                                </a>

                                <h3 class="text-[12px] sm:text-lg font-medium text-sky-900">Income vs Expenses of {{ $dateRangeText }}</h3>

                                <a href="{{ route('expenses.create') }}"
                                    class="inline-flex items-center px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-[10px] sm:text-sm font-medium rounded-full transition duration-150 ease-in-out">
                                    <i class="fas fa-plus text-[8px] sm:text-xs mr-1"></i>
                                    Add Expense
                                </a>
                            </div>
                        </th>
                    </tr>
                    <tr class="bg-gray-100 text-gray-700 ">
                        <th class="border border-gray-300 px-[2px] py-[2px]">Date</th>
                        @foreach ($cars as $car)
                        <th class="border border-gray-300 px-[2px] py-[8px]">
                            <i class="fas fa-car mr-2 text-gray-400"></i>
                            {{ $car->name }}
                        </th>
                        @endforeach
                        <th class="border border-gray-300 px-[2px] py-[2px]">Total</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Net Profit/Loss</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-[2px] py-[2px]">
                            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                            {{ $record->date->format('M d, Y') }}
                        </td>
                        @php
                        $totalIncome = 0;
                        $totalExpense = 0;
                        @endphp
                        @foreach ($cars as $car)
                        @php
                        $income = $record->incomes->where('car_id', $car->id)->sum('amount');
                        $expense = $record->expenses->where('car_id', $car->id)->sum('amount');
                        $totalIncome += $income;
                        $totalExpense += $expense;
                        @endphp
                        <td class="border border-gray-300 px-[2px] py-[2px]">
                            <div class="text-green-800">
                                <i class="fas fa-arrow-up text-[10px]"></i>
                                ৳ {{ number_format($income) }}
                            </div>
                            <div class="text-red-500">
                                <i class="fas fa-arrow-down text-[10px]"></i>
                                ৳ {{ number_format($expense) }}
                            </div>
                        </td>
                        @endforeach
                        <td class="border border-gray-300 px-[2px] py-[2px]">
                            <div class="text-green-800">
                                <i class="fas fa-arrow-up text-[10px]"></i>
                                ৳ {{ number_format($totalIncome) }}
                            </div>
                            <div class="text-red-500">
                                <i class="fas fa-arrow-down text-[10px]"></i>
                                ৳ {{ number_format($totalExpense) }}
                            </div>
                        </td>
                        <td
                            class="border border-gray-300 px-[2px] py-[2px] {{ ($totalIncome - $totalExpense) >= 0 ? 'text-green-800' : 'text-red-500' }}">
                            ৳ {{ number_format(abs($totalIncome - $totalExpense)) }}
                            <i
                                class="fas fa-{{ ($totalIncome - $totalExpense) >= 0 ? 'arrow-up' : 'arrow-down' }} text-[10px]"></i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-200 font-semibold text-gray-900">
                        <td class="border border-gray-300 px-[2px] py-[2px] text-right">Grand Total:</td>
                        @foreach ($cars as $car)
                        @php
                        $carTotalIncome = $records->sum(fn($record) => $record->incomes->where('car_id',
                        $car->id)->sum('amount'));
                        $carTotalExpense = $records->sum(fn($record) => $record->expenses->where('car_id',
                        $car->id)->sum('amount'));
                        @endphp
                        <td class="border border-gray-300 px-[2px] py-[2px]">
                            <div class="text-green-800">
                                <i class="fas fa-arrow-up text-[10px]"></i>
                                ৳ {{ number_format($carTotalIncome) }}
                            </div>
                            <div class="text-red-500">
                                <i class="fas fa-arrow-down text-[10px]"></i>
                                ৳ {{ number_format($carTotalExpense) }}
                            </div>
                        </td>
                        @endforeach
                        @php
                        $grandTotalIncome = $records->sum('total_income');
                        $grandTotalExpense = $records->sum('total_expense');
                        @endphp
                        <td class="border border-gray-300 px-[2px] py-[2px]">
                            <div class="text-green-800">
                                <i class="fas fa-arrow-up text-[10px]"></i>
                                ৳ {{ number_format($grandTotalIncome) }}
                            </div>
                            <div class="text-red-500">
                                <i class="fas fa-arrow-down text-[10px]"></i>
                                ৳ {{ number_format($grandTotalExpense) }}
                            </div>
                        </td>
                        <td
                            class="border border-gray-300 px-[2px] py-[2px] {{ ($grandTotalIncome - $grandTotalExpense) >= 0 ? 'text-green-800' : 'text-red-500' }}">
                            ৳ {{ number_format(abs($grandTotalIncome - $grandTotalExpense)) }}
                            <i
                                class="fas fa-{{ ($grandTotalIncome - $grandTotalExpense) >= 0 ? 'arrow-up' : 'arrow-down' }} text-[10px]"></i>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

       
        
    <!-- Separated income VS Expense in one table with total at bottom of table -->
    <div class="max-w-full overflow-x-auto mt-6 mb-11">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden text-center text-xs">
                <thead>
                    <tr>
                        <th colspan="{{ count($cars) + 2 }}" class="bg-green-600 text-white px-4 py-2 border border-gray-300 text-sm">Income</th>
                        <th colspan="{{ count($cars) + 2 }}" class="bg-red-600 text-white px-4 py-2 border border-gray-300 text-sm">Expense</th>
                        <th class="bg-gray-600 text-white px-4 py-2 border border-gray-300 text-sm">Net</th>
                    </tr>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="border border-gray-300 px-[2px] py-[2px] text-xs">Date</th>
                        @foreach ($cars as $car)
                        <th class="border border-gray-300 px-[2px] py-[2px] text-xs">
                            <i class="fas fa-car mr-2 text-gray-400"></i>
                            {{ $car->name }}
                        </th>
                        @endforeach
                        <th class="border border-gray-300 px-[2px] py-[2px] text-xs">Total Income</th>
                        <th class="border border-gray-300 px-[2px] py-[2px] text-xs">Date</th>
                        @foreach ($cars as $car)
                        <th class="border border-gray-300 px-[2px] py-[2px] text-xs">
                            <i class="fas fa-car mr-2 text-gray-400"></i>
                            {{ $car->name }}
                        </th>
                        @endforeach
                        <th class="border border-gray-300 px-[2px] py-[2px] text-xs">Total Expense</th>
                        <th class="border border-gray-300 px-[2px] py-[2px] text-xs">Profit/Loss</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <!-- Income Section -->
                        <td class="border border-gray-300 px-[2px] py-[2px] text-left text-xs">
                            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                            {{ $record->date->format('M d, Y') }}
                        </td>
                        @php
                        $totalIncome = 0;
                        @endphp
                        @foreach ($cars as $car)
                        @php
                        $income = $record->incomes->where('car_id', $car->id)->sum('amount');
                        $totalIncome += $income;
                        @endphp
                        <td class="border border-gray-300 px-[2px] py-[2px] text-green-600 text-xs">
                            ৳ {{ number_format($income) }}
                        </td>
                        @endforeach
                        <td class="border border-gray-300 px-[2px] py-[2px] font-semibold text-green-600 text-xs">
                            ৳ {{ number_format($totalIncome) }}
                        </td>

                        <!-- Expense Section -->
                        <td class="border border-gray-300 px-[2px] py-[2px] text-left text-xs">
                            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                            {{ $record->date->format('M d, Y') }}
                        </td>
                        @php
                        $totalExpense = 0;
                        @endphp
                        @foreach ($cars as $car)
                        @php
                        $expense = $record->expenses->where('car_id', $car->id)->sum('amount');
                        $totalExpense += $expense;
                        @endphp
                        <td class="border border-gray-300 px-[2px] py-[2px] text-red-600 text-xs">
                            ৳ {{ number_format($expense) }}
                        </td>
                        @endforeach
                        <td class="border border-gray-300 px-[2px] py-[2px] font-semibold text-red-600 text-xs">
                            ৳ {{ number_format($totalExpense) }}
                        </td>

                        <!-- Net Profit/Loss -->
                        <td class="border border-gray-300 px-[2px] py-[2px] font-semibold {{ ($totalIncome - $totalExpense) >= 0 ? 'text-green-600' : 'text-red-600' }} text-xs">
                            ৳ {{ number_format(abs($totalIncome - $totalExpense)) }}
                            <i class="fas fa-{{ ($totalIncome - $totalExpense) >= 0 ? 'arrow-up' : 'arrow-down' }} ml-1"></i>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray-200 font-semibold text-gray-900">
                        <td colspan="{{ count($cars) + 1 }}" class="border border-gray-300 px-[2px] py-[2px] text-right text-xs">Total Income:</td>
                        <td class="border border-gray-300 px-[2px] py-[2px] text-green-600 text-xs">
                            ৳ {{ number_format($records->sum('total_income')) }}
                        </td>
                        <td colspan="{{ count($cars) + 1 }}" class="border border-gray-300 px-[2px] py-[2px] text-right text-xs">Total Expense:</td>
                        <td class="border border-gray-300 px-[2px] py-[2px] text-red-600 text-xs">
                            ৳ {{ number_format($records->sum('total_expense')) }}
                        </td>
                        <td class="border border-gray-300 px-[2px] py-[2px] {{ ($records->sum('total_income') - $records->sum('total_expense')) >= 0 ? 'text-green-600' : 'text-red-600' }} text-xs">
                            ৳ {{ number_format(abs($records->sum('total_income') - $records->sum('total_expense'))) }}
                            <i class="fas fa-{{ ($records->sum('total_income') - $records->sum('total_expense')) >= 0 ? 'arrow-up' : 'arrow-down' }} ml-1"></i>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>


        <!-- Chart Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Income vs Expenses</h3>
                    <div class="flex space-x-2">
                        <button wire:click="updateStats" class="inline-flex items-center px-3 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-sync-alt mr-2"></i> Reload Chart
                        </button>
                        <button wire:click="exportReport" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-download mr-2"></i> Export Report
                        </button>
                    </div>
                </div>
                <div class="h-96">
                    <canvas id="incomeExpenseChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Incomes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Recent Incomes</h3>
                        <a href="{{ route('incomes.create') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus"></i> Add Income
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <span class="text-green-500">Income Amount</span>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Car</th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentIncomes as $income)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                        {{ $income->date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <i class="fas fa-arrow-up mr-2"></i>
                                        ৳ {{ number_format($income->amount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="fas fa-car mr-2 text-gray-400"></i>
                                        {{ $income->car->name ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Expenses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Recent Expenses</h3>
                        <a href="{{ route('expenses.create') }}" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-plus"></i> Add Expense
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Car</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentExpenses as $expense)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                        {{ $expense->date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                        <i class="fas fa-arrow-down mr-2"></i>
                                        ৳ {{ number_format($expense->amount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="fas fa-car mr-2 text-gray-400"></i>
                                        {{ $expense->car->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <i class="fas fa-tag mr-2 text-gray-400"></i>
                                        {{ $expense->category }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    
        
          <!-- Car-wise Summary Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 mt-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Summary for {{ $dateRangeText }}</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-car mr-2"></i>
                                                Car
                                            </div>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-arrow-up text-green-500 mr-2"></i>
                                                Income
                                            </div>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-arrow-down text-red-500 mr-2"></i>
                                                Expenses
                                            </div>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                <i class="fas fa-chart-line mr-2"></i>
                                                Net
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($summary['summary'] as $carSummary)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($carSummary['car']->photo)
                                                <div class="flex-shrink-0 h-8 w-8 mr-3">
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                        src="{{ asset('storage/' . $carSummary['car']->photo) }}"
                                                        alt="{{ $carSummary['car']->name }}">
                                                </div>
                                                @else
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 mr-3 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-car text-gray-500"></i>
                                                </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $carSummary['car']->name
                                                        }}</div>
                                                    <div class="text-xs text-gray-500">{{ $carSummary['car']->plate_number }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">
                                                ৳ {{ number_format($carSummary['income'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-red-600">
                                                ৳ {{ number_format($carSummary['expense'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div
                                                class="text-sm font-medium {{ $carSummary['net'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                ৳ {{ number_format(abs($carSummary['net']), 2) }}
                                                <i
                                                    class="fas fa-{{ $carSummary['net'] >= 0 ? 'arrow-up' : 'arrow-down' }} ml-1"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td class="px-6 py-2 whitespace-nowrap font-medium text-gray-700">Total</td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-green-600">
                                                ৳ {{ number_format($summary['totalIncome'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-red-600">
                                                ৳ {{ number_format($summary['totalExpense'], 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div
                                                class="text-sm font-medium {{ ($summary['totalIncome'] - $summary['totalExpense']) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                ৳ {{ number_format(abs($summary['totalIncome'] - $summary['totalExpense']), 2)
                                                }}
                                                <i
                                                    class="fas fa-{{ ($summary['totalIncome'] - $summary['totalExpense']) >= 0 ? 'arrow-up' : 'arrow-down' }} ml-1"></i>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>

   


</div>


@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('livewire:initialized', function () {
        // Initialize date range pickers
        const dateRangePicker = flatpickr("#date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: ["{{ $startDate }}", "{{ $endDate }}"],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    @this.set('startDate', selectedDates[0].toISOString().split('T')[0]);
                    @this.set('endDate', selectedDates[1].toISOString().split('T')[0]);
                    @this.set('dateFilter', 'custom');
                }
            }
        });

        const dateRangePickerMobile = flatpickr("#date-range-mobile", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: ["{{ $startDate }}", "{{ $endDate }}"],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    @this.set('startDate', selectedDates[0].toISOString().split('T')[0]);
                    @this.set('endDate', selectedDates[1].toISOString().split('T')[0]);
                    @this.set('dateFilter', 'custom');
                }
            }
        });

        // Listen for Livewire events to update the date pickers
        Livewire.on('dateRangeUpdated', (data) => {
            dateRangePicker.setDate([data.startDate, data.endDate]);
            dateRangePickerMobile.setDate([data.startDate, data.endDate]);
        });

        // Initialize Chart.js with enhanced configuration
        const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
        let chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [
                    {
                        label: 'Income',
                        data: @json($chartData['income']),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgb(34, 197, 94)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Expenses',
                        data: @json($chartData['expense']),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += '৳ ' + context.parsed.y.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                                return label;
                            },
                            title: function(context) {
                                return context[0].label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false,
                            drawTicks: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            maxRotation: 45,
                            minRotation: 45,
                            padding: 10
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            padding: 10,
                            callback: function(value) {
                                return '৳ ' + value.toLocaleString('en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                            }
                        },
                        border: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 750,
                    easing: 'easeInOutQuart'
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }
            }
        });

        // Update chart when data changes
        Livewire.on('chartDataUpdated', (data) => {
            if (!data || !data.labels || !data.income || !data.expense) {
                console.warn('Invalid chart data received');
                return;
            }

            // Clear existing data
            chart.data.labels = [];
            chart.data.datasets[0].data = [];
            chart.data.datasets[1].data = [];

            // Update with new data
            chart.data.labels = data.labels;
            chart.data.datasets[0].data = data.income;
            chart.data.datasets[1].data = data.expense;

            // Force chart update
            chart.update('none');
        });

        // Add loading state handling
        Livewire.on('loading', () => {
            // You could add a loading overlay here if needed
            console.log('Loading...');
        });

        // Add error handling
        Livewire.on('error', (error) => {
            console.error('Chart error:', error);
        });
    });
</script>
@endpush
