<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $reportTitle }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0 18px;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 0 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-details {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .report-period {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 5px 0;
            border-top: 1px solid #ddd;
        }
        .flex-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 0;
            padding: 0 5px;
        }
        .flex-item {
            flex: 1;
            min-width: 0;
            margin: 0;
            padding: 0;
        }
        .full-width {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .summary-table {
            margin: 0 0 15px 0;
        }
        h2 {
            margin: 0 0 5px 0;
            padding: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Header with Company Information -->
    <div class="header">
        @if($settings && $settings->logo)
            <img src="{{ public_path('storage/' . $settings->logo) }}" alt="Logo" style="max-height: 60px; margin-bottom: 5px;">
        @endif
        <div class="company-name">{{ config('app.name', 'Car Expense Tracker') }}</div>
        <div class="company-details">
            <strong>Report:</strong> {{ $reportTitle }}<br>
            <strong>Period:</strong> {{ $period }}<br>
            <strong>Generated:</strong> {{ now()->format('M d, Y H:i') }}
        </div>
    </div>
    <!-- Summary Section -->
    <table class="summary-table">
        <tr>
            <td style="background:#e6ffed; color:#166534; font-weight:bold; padding:8px;">Total Income</td>
            <td style="background:#fee2e2; color:#991b1b; font-weight:bold; padding:8px;">Total Expense</td>
            <td style="background:#dbeafe; color:#1e40af; font-weight:bold; padding:8px;">Net Balance</td>
        </tr>
        <tr>
            <td style="padding:8px;">{{ number_format($summary['income'], 2) }}</td>
            <td style="padding:8px;">{{ number_format($summary['expense'], 2) }}</td>
            <td style="padding:8px;">{{ number_format($summary['balance'], 2) }}</td>
        </tr>
    </table>
    <!-- Report Data -->
    @if($reportTypes === 'all')
        <table style="width:100%; border:none; margin-bottom: 10px;">
            <tr>
                <td style="width:50%; vertical-align:top; border:none; padding-right:5px;">
                    <h2>Income by Car</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['income']['byCar'] as $item)
                                <tr>
                                    <td>{{ $item->car->name ?? '-' }}</td>
                                    <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td>Total</td>
                                <td style="text-align: right;">{{ number_format($data['income']['byCar']->sum('total'), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width:50%; vertical-align:top; border:none; padding-left:5px;">
                    <h2>Expense by Car</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['expense']['byCar'] as $item)
                                <tr>
                                    <td>{{ $item->car->name ?? '-' }}</td>
                                    <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td>Total</td>
                                <td style="text-align: right;">{{ number_format($data['expense']['byCar']->sum('total'), 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <div class="full-width">
            <h2>Expense by Category</h2>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['expense']['byCategory'] as $item)
                        <tr>
                            <td>{{ $item->category }}</td>
                            <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Total</td>
                        <td style="text-align: right;">{{ number_format($data['expense']['byCategory']->sum('total'), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        @if($reportTypes === 'income')
            <div class="full-width">
                <h2>Income by Car</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['income']['byCar'] as $item)
                            <tr>
                                <td>{{ $item->car->name ?? '-' }}</td>
                                <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td>Total</td>
                            <td style="text-align: right;">{{ number_format($data['income']['byCar']->sum('total'), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="full-width">
                <h2>Expense by Car</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['expense']['byCar'] as $item)
                            <tr>
                                <td>{{ $item->car->name ?? '-' }}</td>
                                <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td>Total</td>
                            <td style="text-align: right;">{{ number_format($data['expense']['byCar']->sum('total'), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="full-width">
                <h2>Expense by Category</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['expense']['byCategory'] as $item)
                            <tr>
                                <td>{{ $item->category }}</td>
                                <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td>Total</td>
                            <td style="text-align: right;">{{ number_format($data['expense']['byCategory']->sum('total'), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    @endif
    <!-- Footer -->
    <div class="footer">
        Generated on {{ now()->format('M d, Y H:i:s') }} | Page {PAGENO}
    </div>
</body>
</html> 