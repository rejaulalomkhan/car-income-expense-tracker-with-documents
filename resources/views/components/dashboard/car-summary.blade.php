@props(['summary', 'dateRangeText'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 mt-6">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Summary for {{ $dateRangeText }}</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-car mr-2"></i>
                                Car
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-arrow-up text-green-500 mr-2"></i>
                                Income
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <i class="fas fa-arrow-down text-red-500 mr-2"></i>
                                Expenses
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                <div class="flex-shrink-0 h-8 w-8 mr-3 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-car text-gray-500"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $carSummary['car']->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $carSummary['car']->plate_number }}</div>
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
                            <div class="text-sm font-medium {{ $carSummary['net'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ৳ {{ number_format(abs($carSummary['net']), 2) }}
                                <i class="fas fa-{{ $carSummary['net'] >= 0 ? 'arrow-up' : 'arrow-down' }} ml-1"></i>
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
                            <div class="text-sm font-medium {{ ($summary['totalIncome'] - $summary['totalExpense']) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ৳ {{ number_format(abs($summary['totalIncome'] - $summary['totalExpense']), 2) }}
                                <i class="fas fa-{{ ($summary['totalIncome'] - $summary['totalExpense']) >= 0 ? 'arrow-up' : 'arrow-down' }} ml-1"></i>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div> 