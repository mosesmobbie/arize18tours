<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 24px;
        }
        body {
            background-color: #ffffff;
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 0;
            color: #333;
        }
        .container {
            max-width: 760px;
            margin: 24px auto;
            padding: 8px 8px 60px;
            background: #ffffff;
        }
        .top {
            display: table;
            width: 100%;
            margin-bottom: 16px;
        }
        .top-left,
        .top-right {
            display: table-cell;
            vertical-align: top;
        }
        .top-right {
            text-align: right;
        }
        .logo {
            width: 230px;
            max-width: 100%;
            margin-bottom: 10px;
        }
        .company {
            font-size: 14px;
            letter-spacing: 1px;
            line-height: 1;
            margin: 4px 0;
            text-transform: uppercase;
        }
        .invoice-no {
            font-size: 35px;
            margin-top: 24px;
            line-height: 1;
            text-transform: uppercase;
            color: #1B2B4B;
        }
        .invoice-code {
            font-size: 20px;
            margin-top: 10px;
            line-height: 1;
            color: #000;
        }
        .meta {
            display: table;
            width: 100%;
            margin-top: 18px;
            margin-bottom: 20px;
        }
        .bill,
        .date-area {
            display: table-cell;
            vertical-align: top;
        }
        .date-area {
            text-align: right;
            width: 360px;
        }
        .label {
            color: #6a6a6a;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .bill-name {
            font-weight: 700;
            font-size: 14px;
            margin-top: 3px;
        }
        .bill-phone {
            margin-top: 4px;
            font-size: 14px;
            color: #4f4f4f;
        }
        .date-row {
            margin-top: 10px;
            margin-bottom: 16px;
        }
        .date-row .label {
            display: inline-block;
            margin-right: 22px;
            margin-bottom: 0;
            vertical-align: middle;
        }
        .date-value {
            font-size: 14px;
            color: #4f4f4f;
            vertical-align: middle;
        }
        .balance {
            background: #ececec;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: auto;
            padding: 10px 12px;
            box-sizing: border-box;
            text-align: right;
        }
        .balance-label,
        .balance-value {
            font-size: 14px;
            font-weight: 700;
            text-align: right;
        }
        .balance-value {
            text-align: right;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        .items thead th {
            background: #1B2B4B;
            color: #fff;
            padding: 11px 16px;
            font-size: 14px;
            font-weight: 500;
        }
        .items thead th:first-child {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
            text-align: left;
        }
        .items thead th:last-child {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
            text-align: right;
        }
        .items tbody td {
            padding: 13px 16px;
            vertical-align: top;
            font-size: 14px;
            border: 0;
        }
        .items tbody td.num {
            text-align: center;
            width: 100px;
        }
        .items tbody td.money {
            text-align: right;
            width: 180px;
            white-space: nowrap;
        }
        .item-title {
            font-weight: 700;
            margin-bottom: 6px;
        }
        .item-sub,
        .item-note {
            color: #606060;
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 2px;
        }
        .totals {
            width: auto;
            margin-left: auto;
            margin-top: 20px;
        }
        .totals table {
            width: auto;
            border-collapse: collapse;
            margin-left: auto;
        }
        .totals td {
            padding: 5px 0;
            font-size: 14px;
        }
        .totals .left {
            color: #5f5f5f;
            text-align: left;
            padding-right: 12px;
        }
        .totals .right {
            text-align: right;
            white-space: nowrap;
        }
        .payment {
            margin-top: 42px;
            font-size: 14px;
            line-height: 1.45;
        }
        .payment-label {
            color: #555;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .terms {
            margin-top: 20px;
            font-size: 14px;
            line-height: 1.4;
        }
        .actions {
            margin-top: 22px;
        }
        .download-btn {
            display: inline-block;
            background: #1f4a80;
            color: #fff;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 14px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 24px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #1B2B4B;
            text-align: center;
            background: #ffffff;
        }
        .footer a {
            color: #1B2B4B;
            text-decoration: none;
        }
        .footer-items {
            display: table;
            width: 100%;
        }
        .footer-item {
            display: table-cell;
            text-align: center;
            padding: 0 8px;
        }
        .small {
            font-size: 14px;
            line-height: 1.3;
            color: #4f4f4f;
        }
        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    @php
        $currency = $invoice->currency ?? 'ZAR';
        $fmt = fn ($amount) => $currency . ' ' . number_format((float) $amount, 2);
        $isQuote = ($printType ?? 'quote') === 'quote';
        $docTitle = $isQuote ? 'QUOTATION' : 'INVOICE';
        $accentColor = $isQuote ? '#1B2B4B' : '#C8202F';
    @endphp

    <div class="container">
        <div class="top">
            <div class="top-left">
                <img src="{{ ($isPdf ?? false) ? public_path('images/logo.png') : asset('images/logo.png') }}" class="logo" alt="Logo">
                <div class="small"><strong>Arize18 Travel and Tours</strong></div>
                <div class="small">TAX No: 9030358296</div>
            </div>
            <div class="top-right">
                <div class="invoice-no" style="color: {{ $accentColor }}">{{ $docTitle }}</div>
                <div class="invoice-code"># {{ $invoice->invoice_number }}</div>
            </div>
        </div>

        <div class="meta">
            <div class="bill">
                <div class="label">Bill To:</div>
                <div class="bill-name">{{ $invoice->bill_to }}</div>
                @if(!empty($invoice->bill_to_phone))
                    <div class="bill-phone">{{ $invoice->bill_to_phone }}</div>
                @endif
            </div>
            <div class="date-area">
                <div class="date-row">
                    <span class="label">Date:</span>
                    <span class="date-value">{{ $invoice->invoice_date }}</span>
                </div>
                <div class="balance">
                    <span class="balance-label">Balance Due:</span>
                    <span class="balance-value nowrap">{{ $fmt($invoice->balance_due) }}</span>
                </div>
            </div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th style="width: 58%; background: {{ $accentColor }}">Item</th>
                    <th style="width: 12%; text-align:center; background: {{ $accentColor }}">Quantity</th>
                    <th style="width: 15%; text-align:right; background: {{ $accentColor }}">Rate</th>
                    <th style="width: 15%; text-align:right; background: {{ $accentColor }}">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr>
                        <td>
                            <div class="item-title">{{ $item['title'] }}</div>
                            @if(!empty($item['description']))
                                <div class="item-sub">{{ $item['description'] }}</div>
                            @endif
                            @if(!empty($item['note']))
                                <div class="item-note">{{ $item['note'] }}</div>
                            @endif
                        </td>
                        <td class="num">{{ $item['quantity'] }}</td>
                        <td class="money nowrap">{{ $fmt($item['rate']) }}</td>
                        <td class="money nowrap">{{ $fmt($item['amount']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <div class="totals">
            <table>
                <thead>
                    <tr>
                        <td class="left">Subtotal:</td>
                        <td class="right">{{ $fmt($invoice->subtotal) }}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="left">Tax ({{ abs($invoice->tax_percent) }}%):</td>
                        <td class="right">{{ $fmt(abs($invoice->tax_amount)) }}</td>
                    </tr>
                    <tr>
                        <td class="left"><strong>Total:</strong></td>
                        <td class="right"><strong>{{ $fmt($invoice->total) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="payment">
            <div class="payment-label">PAYMENT DETAILS</div>
            @foreach($invoice->payment_details as $line)
                @if(str_starts_with($line, 'Reference:'))
                    @php([$label, $value] = array_pad(explode(':', $line, 2), 2, ''))
                    <div><strong>{{ $label }}: {{ trim($value) }}</strong></div>
                @else
                    <div>{{ $line }}</div>
                @endif
            @endforeach
        </div>

        <div class="terms">
            <div class="payment-label">TERMS:</div>
            <div>{{ $invoice->terms }}</div>
        </div>

        @if($showDownloadLink ?? false)
            <p class="actions">
                <a href="{{ route('invoice.download', ['quotation_id' => $quotationId ?? request('quotation_id'), 'print' => $printType ?? 'quote']) }}" class="download-btn">Download PDF</a>
            </p>
        @endif

        @isset($contact)
            <div class="footer">
                <div class="footer-items">
                    <div class="footer-item">🌐 <a href="https://www.arize18.co.za">www.arize18.co.za</a></div>
                    @if(!empty($contact->website))
                        <div class="footer-item">🌐 <a href="{{ $contact->website }}">{{ $contact->website }}</a></div>
                    @endif
                    @if(!empty($contact->email))
                        <div class="footer-item">✉ <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></div>
                    @endif
                    @if(!empty($contact->whatsapp))
                        <div class="footer-item">💬 {{ $contact->whatsapp }}</div>
                    @endif
                    @if(!empty($contact->phone))
                        <div class="footer-item">📞 {{ $contact->phone }}</div>
                    @endif
                </div>
            </div>
        @endisset
    </div>
</body>
</html>
