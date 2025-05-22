@props(['cars', 'records', 'dateRangeText'])

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