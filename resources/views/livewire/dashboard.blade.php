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
                            <span class="text-lg font-semibold text-gray-900">৳ {{
                                number_format($stats['total_income'],
                                2) }}</span>
                            <span class="text-xs px-1.5 py-0.5 rounded-full bg-green-100 text-green-800">+12.5%</span>
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
                            <span class="text-lg font-semibold text-gray-900">৳ {{
                                number_format($stats['total_expense'],
                                2) }}</span>
                            <span class="text-xs px-1.5 py-0.5 rounded-full bg-red-100 text-red-800">-8.4%</span>
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
                            <span
                                class="text-lg font-semibold {{ $stats['net_income'] >= 0 ? 'text-gray-900' : 'text-orange-600' }}">
                                ৳ {{ number_format(abs($stats['net_income']), 2) }}
                            </span>
                            <span
                                class="text-xs px-1.5 py-0.5 rounded-full {{ $stats['net_income'] >= 0 ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                {{ $stats['net_income'] >= 0 ? '+' : '-' }}4.1%
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
                            <span
                                class="text-lg font-semibold {{ $stats['profit_margin'] >= 0 ? 'text-gray-900' : 'text-pink-600' }}">
                                {{ number_format(abs($stats['profit_margin']), 2) }}%
                            </span>
                            <span
                                class="text-xs px-1.5 py-0.5 rounded-full {{ $stats['profit_margin'] >= 0 ? 'bg-indigo-100 text-indigo-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $stats['profit_margin'] >= 0 ? '+' : '-' }}2.3%
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
                <th colspan="{{ count($cars) + 3 }}" class="bg-sky-200 text-sky-800 px-4 py-2 border border-gray-300">
                <div class="flex justify-between items-center">
                <a href="{{ route('incomes.create') }}" class="inline-flex items-center px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white text-[10px] sm:text-sm font-medium rounded-full transition duration-150 ease-in-out">
                    <i class="fas fa-plus text-[8px] sm:text-xs mr-1"></i>
                    Add Income
                </a>

                   <h3 class="text-[12px] sm:text-lg font-medium text-sky-900">Income vs Expenses</h3>

                    <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-2 py-1 bg-red-500 hover:bg-red-600 text-white text-[10px] sm:text-sm font-medium rounded-full transition duration-150 ease-in-out">
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
                    <i class="fas fa-{{ ($totalIncome - $totalExpense) >= 0 ? 'arrow-up' : 'arrow-down' }} text-[10px]"></i>
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
                    <i class="fas fa-{{ ($grandTotalIncome - $grandTotalExpense) >= 0 ? 'arrow-up' : 'arrow-down' }} text-[10px]"></i>
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
                    <button wire:click="exportReport"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-download mr-2"></i> Export Report
                    </button>
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

        <!-- Icone VS Expense in one table with total at bottom of table -->
         <div class="max-w-full overflow-x-auto mt-6 mb-11">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden text-center">
                <thead>
                    <tr>
                        <th colspan="5" class="bg-green-600 text-white px-4 py-2 border border-gray-300">Income</th>
                        <th colspan="5" class="bg-red-600 text-white px-4 py-2 border border-gray-300">Expense</th>
                    </tr>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="border border-gray-300 px-[2px] py-[2px]">Date</th>
                        <!-- Add all cars dynamically as th -->
                        <th class="border border-gray-300 px-[2px] py-[2px]">Car1</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Car2</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Car3</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Total Income</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Car1</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Car2</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Car3</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Total Expense</th>
                        <th class="border border-gray-300 px-[2px] py-[2px]">Net Profit/Loss</th>

                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-[2px] py-[2px]">2024-06-01</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">10000</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">150</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">120</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">120</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">370</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">50</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">60</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">55</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">165</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-[2px] py-[2px]">2024-06-02</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">90</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">130</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">140</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">360</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">40</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">70</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">65</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">175</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">175</td>
                    </tr>
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="border border-gray-300 px-[2px] py-[2px]">2024-06-03</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">110</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">140</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">130</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">380</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">60</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">50</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">50</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">70</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">180</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-200 font-semibold text-gray-900">
                        <td colspan="4" class="border border-gray-300 px-[2px] py-[2px] text-right">Total Income:</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">1110</td>
                        <td colspan="3" class="border border-gray-300 px-[2px] py-[2px] text-right">Total Expense:</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">520</td>
                        <td class="border border-gray-300 px-[2px] py-[2px]">520</td>
                    </tr>
                </tfoot>
            </table>
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
        // Initialize Flatpickr for desktop
        const dateRangePicker = flatpickr("#date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: [
                @this.startDate || new Date().toISOString().split('T')[0],
                @this.endDate || new Date().toISOString().split('T')[0]
            ],
            onChange: function(selectedDates, dateStr) {
                if (selectedDates.length === 2) {
                    updateDateRange(selectedDates, 'desktop');
                }
            }
        });

        // Initialize Flatpickr for mobile
        const dateRangePickerMobile = flatpickr("#date-range-mobile", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: [
                @this.startDate || new Date().toISOString().split('T')[0],
                @this.endDate || new Date().toISOString().split('T')[0]
            ],
            onChange: function(selectedDates, dateStr) {
                if (selectedDates.length === 2) {
                    updateDateRange(selectedDates, 'mobile');
                }
            }
        });

        // Common function to update date range for both mobile and desktop
        function updateDateRange(selectedDates, device) {
            const startDate = selectedDates[0].toISOString().split('T')[0];
            const endDate = selectedDates[1].toISOString().split('T')[0];

            // Update hidden inputs which are bound to Livewire
            document.getElementById('start-date').value = startDate;
            document.getElementById('end-date').value = endDate;

            // Dispatch events to trigger Livewire update
            document.getElementById('start-date').dispatchEvent(new Event('input'));
            document.getElementById('end-date').dispatchEvent(new Event('input'));

            // Update date filter to custom
            const filterId = device === 'mobile' ? 'date-filter-mobile' : 'date-filter';
            document.getElementById(filterId).value = 'custom';
            document.getElementById(filterId).dispatchEvent(new Event('change'));

            // Update period display for both mobile and desktop
            const startMonth = selectedDates[0].toLocaleString('default', { month: 'long', year: 'numeric' });
            const endMonth = selectedDates[1].toLocaleString('default', { month: 'long', year: 'numeric' });
            const periodText = startMonth === endMonth ? startMonth : `${startMonth} - ${endMonth}`;

            document.getElementById('selected-period').textContent = periodText;
            document.getElementById('selected-period-mobile').textContent = periodText;
        }

        // Listen for Livewire events to update the date picker
        Livewire.on('dateRangeUpdated', ({ startDate, endDate }) => {
            // Update both date pickers
            dateRangePicker.setDate([startDate, endDate]);
            dateRangePickerMobile.setDate([startDate, endDate]);

            // Update period displays
            const start = new Date(startDate);
            const end = new Date(endDate);
            const startMonth = start.toLocaleString('default', { month: 'long', year: 'numeric' });
            const endMonth = end.toLocaleString('default', { month: 'long', year: 'numeric' });
            const periodText = startMonth === endMonth ? startMonth : `${startMonth} - ${endMonth}`;

            document.getElementById('selected-period').textContent = periodText;
            document.getElementById('selected-period-mobile').textContent = periodText;
        });

        // Initialize Chart.js
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
                        tension: 0.1,
                        fill: true
                    },
                    {
                        label: 'Expenses',
                        data: @json($chartData['expense']),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.1,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ৳ ' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '৳ ' + value.toFixed(2);
                            }
                        }
                    }
                }
            }
        });

        Livewire.on('chartDataUpdated', (data) => {
            chart.data.labels = data.labels;
            chart.data.datasets[0].data = data.income;
            chart.data.datasets[1].data = data.expense;
            chart.update();
        });
    });
</script>
@endpush
