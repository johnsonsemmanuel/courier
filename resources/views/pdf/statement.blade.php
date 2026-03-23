<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Statement</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #6B2D9E;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #6B2D9E;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
            color: #666;
        }
        .info-value {
            display: table-cell;
            color: #333;
        }
        .summary-box {
            background: #f8f9fa;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #6B2D9E;
        }
        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .summary-label {
            display: table-cell;
            font-weight: bold;
        }
        .summary-value {
            display: table-cell;
            text-align: right;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #6B2D9E;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .amount-credit {
            color: #10b981;
            font-weight: bold;
        }
        .amount-debit {
            color: #ef4444;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            font-size: 9px;
            color: #999;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Courier Savings Bank</h1>
        <p>Account Statement</p>
        <p style="font-size: 10px;">Generated on {{ $generatedDate->format('F d, Y h:i A') }}</p>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Account Holder:</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Account Number:</div>
            <div class="info-value">{{ $account->account_number }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Account Type:</div>
            <div class="info-value">{{ ucfirst($account->account_type) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Statement Period:</div>
            <div class="info-value">{{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Current Balance:</div>
            <div class="info-value">${{ number_format($account->balance, 2) }}</div>
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-row">
            <div class="summary-label">Total Deposits:</div>
            <div class="summary-value" style="color: #10b981;">${{ number_format($totalDeposits, 2) }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Total Withdrawals:</div>
            <div class="summary-value" style="color: #ef4444;">${{ number_format($totalWithdrawals, 2) }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Net Change:</div>
            <div class="summary-value">${{ number_format($totalDeposits - $totalWithdrawals, 2) }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Total Transactions:</div>
            <div class="summary-value">{{ $transactions->count() }}</div>
        </div>
    </div>

    <h3 style="color: #6B2D9E; margin-top: 30px;">Transaction History</h3>
    
    @if($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                        <td style="font-family: monospace; font-size: 9px;">{{ $transaction->reference_number }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}</td>
                        <td>{{ $transaction->description ?? '-' }}</td>
                        <td style="text-align: right;" class="{{ $transaction->transaction_type === 'deposit' ? 'amount-credit' : 'amount-debit' }}">
                            {{ $transaction->transaction_type === 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge status-{{ $transaction->status }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 40px; color: #999;">No transactions found for this period.</p>
    @endif

    <div class="footer">
        <p><strong>Courier Savings Bank</strong></p>
        <p>This is a computer-generated statement and does not require a signature.</p>
        <p>For inquiries, please contact customer support.</p>
    </div>
</body>
</html>
