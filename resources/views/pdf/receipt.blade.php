<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaction Receipt</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .receipt-container {
            border: 2px solid #6B2D9E;
            padding: 30px;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px dashed #6B2D9E;
        }
        .header h1 {
            color: #6B2D9E;
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .header .receipt-title {
            font-size: 16px;
            color: #666;
            font-weight: bold;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            margin: 15px 0;
            font-size: 14px;
        }
        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-failed {
            background: #fee2e2;
            color: #991b1b;
        }
        .amount-box {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 5px solid #6B2D9E;
        }
        .amount-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .amount-value {
            font-size: 36px;
            font-weight: bold;
            color: #6B2D9E;
            margin: 10px 0;
        }
        .details-section {
            margin: 30px 0;
        }
        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-label {
            display: table-cell;
            width: 40%;
            font-weight: bold;
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-value {
            display: table-cell;
            color: #333;
            font-size: 13px;
        }
        .reference-box {
            background: #6B2D9E;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin: 20px 0;
        }
        .reference-label {
            font-size: 10px;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .reference-value {
            font-size: 16px;
            font-weight: bold;
            font-family: monospace;
            margin-top: 5px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px dashed #6B2D9E;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .transaction-type {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .type-deposit {
            background: #d1fae5;
            color: #065f46;
        }
        .type-withdrawal {
            background: #fed7aa;
            color: #9a3412;
        }
        .type-transfer {
            background: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <h1>Courier Savings Bank</h1>
            <div class="receipt-title">Transaction Receipt</div>
            <div style="margin-top: 15px;">
                <span class="status-badge status-{{ $transaction->status }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
        </div>

        <div class="reference-box">
            <div class="reference-label">Transaction Reference</div>
            <div class="reference-value">{{ $transaction->reference_number }}</div>
        </div>

        <div class="amount-box">
            <div class="amount-label">Transaction Amount</div>
            <div class="amount-value">
                ${{ number_format($transaction->amount, 2) }}
            </div>
            <span class="transaction-type type-{{ $transaction->transaction_type }}">
                {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
            </span>
        </div>

        <div class="details-section">
            <div class="detail-row">
                <div class="detail-label">Account Holder</div>
                <div class="detail-value">{{ $user->name }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Account Number</div>
                <div class="detail-value">{{ $account->account_number }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Transaction Date</div>
                <div class="detail-value">{{ $transaction->created_at->format('F d, Y h:i A') }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Transaction Type</div>
                <div class="detail-value">{{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}</div>
            </div>
            
            @if($transaction->recipient_account)
                <div class="detail-row">
                    <div class="detail-label">Recipient</div>
                    <div class="detail-value">{{ $transaction->recipient_name }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Recipient Account</div>
                    <div class="detail-value">{{ $transaction->recipient_account }}</div>
                </div>
            @endif
            
            @if($transaction->description)
                <div class="detail-row">
                    <div class="detail-label">Description</div>
                    <div class="detail-value">{{ $transaction->description }}</div>
                </div>
            @endif
            
            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">{{ ucfirst($transaction->status) }}</div>
            </div>
        </div>

        <div class="footer">
            <p><strong>Courier Savings Bank</strong></p>
            <p>Generated on {{ $generatedDate->format('F d, Y h:i A') }}</p>
            <p>This is a computer-generated receipt and does not require a signature.</p>
            <p style="margin-top: 15px; font-size: 9px;">
                Keep this receipt for your records. For inquiries, please contact customer support.
            </p>
        </div>
    </div>
</body>
</html>
