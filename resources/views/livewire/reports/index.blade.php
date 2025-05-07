<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded shadow">
                        <div class="text-sm text-gray-500">Total Income</div>
                        <div class="text-2xl font-bold text-green-700">{{ number_format($summary['income'], 2) }}</div>
                    </div>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded shadow">
                        <div class="text-sm text-gray-500">Total Expense</div>
                        <div class="text-2xl font-bold text-red-700">{{ number_format($summary['expense'], 2) }}</div>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded shadow">
                        <div class="text-sm text-gray-500">Net Balance</div>
                        <div class="text-2xl font-bold text-blue-700">{{ number_format($summary['balance'], 2) }}</div>
                    </div>
                </div>
                <!-- Report Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 items-end">
                    <!-- Date Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date Range</label>
                        <select wire:model.live="dateRange" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="this_year">This Year</option>
                        </select>
                    </div>
                    <!-- Report Type (Dropdown) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Report Type</label>
                        <select wire:model.live="reportTypes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all">All Types</option>
                            <option value="expense">Expense</option>
                            <option value="income">Income</option>
                        </select>
                    </div>
                </div>
                <!-- Export Button -->
                <div class="mb-6">
                    <button wire:click="generateReport" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Export PDF
                    </button>
                </div>
                <!-- Report Data -->
                @if($reportTypes === 'all')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Income by Car -->
                        <div>
                            <h2 class="text-xl font-bold mb-2 text-gray-800">Income by Car</h2>
                            <table class="min-w-full divide-y divide-gray-200 mb-4">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reportData['income']['byCar'] as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->car->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">{{ number_format($reportData['income']['byCar']->sum('total'), 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Expense by Car -->
                        <div>
                            <h2 class="text-xl font-bold mb-2 text-gray-800">Expense by Car</h2>
                            <table class="min-w-full divide-y divide-gray-200 mb-4">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reportData['expense']['byCar'] as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->car->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">{{ number_format($reportData['expense']['byCar']->sum('total'), 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Expense by Category (full width) -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-2 text-gray-800">Expense by Category</h2>
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportData['expense']['byCategory'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">{{ number_format($reportData['expense']['byCategory']->sum('total'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif($reportTypes === 'income')
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-2 text-gray-800">Income by Car</h2>
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportData['income']['byCar'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->car->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">{{ number_format($reportData['income']['byCar']->sum('total'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @elseif($reportTypes === 'expense')
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-2 text-gray-800">Expense by Car</h2>
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportData['expense']['byCar'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->car->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">{{ number_format($reportData['expense']['byCar']->sum('total'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-2 text-gray-800">Expense by Category</h2>
                        <table class="min-w-full divide-y divide-gray-200 mb-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportData['expense']['byCategory'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Total</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">{{ number_format($reportData['expense']['byCategory']->sum('total'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> 