<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Date Filter Section -->
        <x-dashboard.date-filter 
            :startDate="$startDate"
            :endDate="$endDate"
            :dateFilterLabel="$dateFilterLabel"
        />

        <!-- Statistics Cards -->
        <x-dashboard.stats-cards 
            :stats="$stats"
            :percentageChanges="$percentageChanges"
        />

        
        <!-- Previous Income vs Expenses Table -->
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
        
        <!-- Income vs Expenses Table -->
        <x-dashboard.income-expense-table 
            :cars="$cars"
            :records="$records"
            :dateRangeText="$dateRangeText"
        />


        <!-- Chart Section -->
        <x-dashboard.chart-section 
            :chartData="$chartData"
        />

        <!-- Recent Transactions -->
        <x-dashboard.recent-transactions 
            :recentIncomes="$recentIncomes"
            :recentExpenses="$recentExpenses"
        />

        <!-- Car-wise Summary -->
        <x-dashboard.car-summary 
            :summary="$summary"
            :dateRangeText="$dateRangeText"
        />
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
<style>
    /* Fix for dropdown z-index issues */
    .date-filter-dropdown {
        position: absolute !important;
        z-index: 9999 !important;
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        overflow: visible;
    }
    
    /* Ensure all dropdowns appear above other elements */
    [x-data] {
        position: relative;
    }
    
    /* Additional fix for Alpine.js x-show elements */
    div[x-show] {
        z-index: 9999 !important;
    }
    
    /* Fix for parent containers */
    .py-12, .max-w-7xl, .bg-white, .p-4, .sm\:p-6, .block, .sm\:hidden, .mb-4, .flex, .flex-col, .space-y-2 {
        overflow: visible !important;
    }
    
    /* Ensure dropdown remains visible */
    .date-filter-dropdown[style*="display: block"] {
        z-index: 9999 !important;
        position: absolute !important;
    }

    /* Reload icon spin animation */
    .reload-spin {
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('livewire:initialized', function () {
    function formatDateToYMD(date) {
        return date.getFullYear() + '-' +
            ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
            ('0' + date.getDate()).slice(-2);
    }

    let dateRangePickerInstance = null;
    let dateRangePickerMobileInstance = null;

    function initPickers() {
        dateRangePickerInstance = flatpickr("#date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: ["{{ $startDate }}", "{{ $endDate }}"],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    @this.set('startDate', formatDateToYMD(selectedDates[0]));
                    @this.set('endDate', formatDateToYMD(selectedDates[1]));
                    @this.set('dateFilter', 'custom');
                }
            }
        });

        dateRangePickerMobileInstance = flatpickr("#date-range-mobile", {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: ["{{ $startDate }}", "{{ $endDate }}"],
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    @this.set('startDate', formatDateToYMD(selectedDates[0]));
                    @this.set('endDate', formatDateToYMD(selectedDates[1]));
                    @this.set('dateFilter', 'custom');
                }
            }
        });
    }

    initPickers();

    Livewire.hook('message.processed', (message, component) => {
        initPickers();
    });

    // Listen for custom event to open the date picker
    window.addEventListener('openDateRangePicker', function(e) {
        if (window.innerWidth < 640) {
            if (dateRangePickerMobileInstance) {
                setTimeout(() => dateRangePickerMobileInstance.open(), 100);
            }
        } else {
            if (dateRangePickerInstance) {
                setTimeout(() => dateRangePickerInstance.open(), 100);
            }
        }
    });
});

function spinAndReload(btn) {
    const icon = btn.querySelector('i');
    if (icon) icon.classList.add('reload-spin');
    window.location.reload();
}
</script>
@endpush
