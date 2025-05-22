@props(['stats', 'percentageChanges'])

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
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_income'], 2) }}</div>
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
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_expense'], 2) }}</div>
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
            <div class="flex-shrink-0 p-2 rounded-lg {{ $stats['net_income'] >= 0 ? 'bg-blue-50' : 'bg-orange-50' }}">
                <svg class="w-5 h-5 {{ $stats['net_income'] >= 0 ? 'text-blue-600' : 'text-orange-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-500 mb-1">Net Income</p>
                <div class="flex items-center justify-between">
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['net_income'], 2) }}</div>
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
            <div class="flex-shrink-0 p-2 rounded-lg {{ $stats['profit_margin'] >= 0 ? 'bg-indigo-50' : 'bg-pink-50' }}">
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