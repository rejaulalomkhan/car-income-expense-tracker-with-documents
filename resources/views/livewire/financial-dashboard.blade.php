<div>
    <!-- Filter Section -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700">Filter Type</label>
                <select wire:model="filterType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="month">By Month</option>
                    <option value="date_range">By Date Range</option>
                </select>
            </div>

            @if($filterType === 'month')
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Select Month</label>
                    <input type="month" wire:model="selectedMonth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            @else
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" wire:model="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" wire:model="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            @endif
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Income Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 bg-indigo-600">
                <h2 class="text-lg font-semibold text-white">Income Summary</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            @foreach($cars as $car)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $car->name }}</th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($incomes->flatten()->unique('date')->sortBy('date') as $income)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $income->date->format('d/m/Y') }}</td>
                                @foreach($cars as $car)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $incomes->get($car->id, collect())->where('date', $income->date)->sum('amount') }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $incomes->flatten()->where('date', $income->date)->sum('amount') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $income->description }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Total</td>
                            @foreach($cars as $car)
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $getTotalIncome($car->id) }}
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $totalIncome }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Expense Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 bg-red-600">
                <h2 class="text-lg font-semibold text-white">Expense Summary</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            @foreach($cars as $car)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $car->name }}</th>
                            @endforeach
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($expenses->flatten()->unique('date')->sortBy('date') as $expense)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $expense->date->format('d/m/Y') }}</td>
                                @foreach($cars as $car)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $expenses->get($car->id, collect())->where('date', $expense->date)->sum('amount') }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $expenses->flatten()->where('date', $expense->date)->sum('amount') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $expense->description }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Total</td>
                            @foreach($cars as $car)
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $getTotalExpense($car->id) }}
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $totalExpense }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 