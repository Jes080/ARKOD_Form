<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Voucher - {{ $voucher->pv_no }}</title>
    <style>
        @font-face {
        font-family: 'Aptos Narrow';
        src: url('{{ storage_path("fonts/AptosNarrow.ttf") }}') format("truetype");
        font-weight: normal;
        font-style: normal;
        }

        @font-face {
            font-family: 'Aptos Narrow';
            src: url('{{ storage_path("fonts/AptosNarrow-Bold.ttf") }}') format("truetype");
            font-weight: bold;
            font-style: normal;
        }
        body {
        font-family: 'Aptos Narrow', sans-serif; /* Applied here */
        font-size: 13px; /* Aptos Narrow is slightly smaller, so 13px looks better */
        margin: 0;
        padding: 0;
        color: #000;
        }   
        .container {
            padding: 30px;
        }
        /* Header Section */
        .header {
            text-align: center;
            position: relative;
            margin-bottom: 40px;
        }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .company-no {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .company-address {
            font-size: 10px;
            margin-bottom: 2px;
        }
        .title-right {
            position: absolute;
            top: 0;
            right: 0px;
            font-size: 12px;
            font-weight: bold;
        }
        /* Information Grid */
        .info-section {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding: 3px 0;
        }
        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 300px;
        }
        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 8px 5px;
            text-align: left;
        }
        .items-table td {
            padding: 10px 5px;
            vertical-align: top;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Total Section */
        .total-section {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 10px 0;
            margin-bottom: 30px;
        }
        /* Signatures */
        .signature-section {
            margin-top: 80px;
            width: 100%;
        }
        .sig-box {
            width: 30%;
            text-align: center;
            display: inline-block;
        }
        .sig-line {
            border-top: 1px solid #000;
            margin: 0 10px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title-right">PAYMENT VOUCHER</div>
            <div class="company-name">ARKOD SMART LOGITECH SDN. BHD.</div>
            <div>COMPANY NO: 202001039694 (1396015-V)</div>
            <p>Ground Floor, Lot 1451, Section 66 KTLD, Jalan Keluli,<br>
               Bintawa Industrial Estate, 93450 Kuching, Sarawak</p>
        </div>

        <table class="info-table">
            <tr>
                <td width="10%">Pay To :</td>
                <td width="45%"><span class="underline">{{ $voucher->pay_to }}</span></td>
                <td width="15%" class="text-right">PV No. :</td>
                <td width="30%" style="padding-left: 10px;">{{ $voucher->pv_no }}</td>
            </tr>
            <tr>
                <td>Ref No. :</td>
                <td><span class="underline">{{ $voucher->ref_no }}</span></td>
                <td class="text-right">Date :</td>
                <td style="padding-left: 10px;">{{ \Carbon\Carbon::parse($voucher->pv_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="text-right">Payment By :</td>
                <td style="padding-left: 10px;">{{ $voucher->pay_by }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="text-right">Account :</td>
                <td style="padding-left: 10px;">{{ $voucher->account_no }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="text-right">Ledger :</td>
                <td style="padding-left: 10px;">{{ $voucher->ledger }}</td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%" class="text-center">Bil.</th>
                    <th width="75%">Payment Details</th>
                    <th width="20%" class="text-right">Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voucher->items as $item)
                <tr>
                    <td class="text-center">{{ $item->detail_no }}</td>
                    <td>{!! nl2br(e($item->payment_details)) !!}</td>
                    <td class="text-right">{{ number_format($item->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="info-table total-section">
            <tr>
                <td width="20%">RINGGIT MALAYSIA :</td>
                <td width="55%"><strong>{{ $voucher->total_amount_word }}</strong></td>
                <td width="10%" class="text-right">Total :</td>
                <td width="15%" class="text-right"><strong>{{ number_format($voucher->total_amount, 2) }}</strong></td>
            </tr>
        </table>

        <div style="margin-bottom: 50px;">
            Bank Cheque No. : {{ $voucher->bank_cheque_no }}<br>
            Cheque Date : {{ $voucher->cheque_date }}
        </div>

        <div class="signature-section">
            <div class="sig-box">
                <div style="margin-bottom: 40px;">{{ $voucher->prepared_by }}</div>
                <div class="sig-line">Prepared By</div>
            </div>
            <div class="sig-box" style="margin-left: 4%;">
                <div style="margin-bottom: 40px;">&nbsp;</div>
                <div class="sig-line">Approved By</div>
            </div>
            <div class="sig-box" style="margin-left: 4%;">
                <div style="margin-bottom: 40px;">&nbsp;</div>
                <div class="sig-line">Received By</div>
            </div>
        </div>
    </div>
</body>
</html>