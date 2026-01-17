<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Voucher - {{ $voucher->pv_no }}</title>
    <style>
        @font-face {
        font-family: 'Aptos Narrow';
        src: url('{{ storage_path("fonts/Aptos-Narrow.ttf") }}') format("truetype");
        font-weight: normal;
        font-style: normal;
        }

        @font-face {
            font-family: 'Aptos Narrow';
            src: url('{{ storage_path("fonts/Aptos-Narrow-Bold.ttf") }}') format("truetype");
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
            margin-bottom: 25px;
        }
        .company-name {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .company-no {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 2px;
            margin-top: -7px;
        }
        .company-address {
            font-size: 12px;
            margin-bottom: 2px;
            margin-top: 5px;
        }
        .title-right {
            position: absolute;
            top: 0;
            right: 0px;
            font-size: 15px;
            font-weight: bold;
        }
        /* Information Grid */
        .info-section {
            width: 100%;
            margin-bottom: 10px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            /* vertical-align: top; */
            padding: 0px 0;
        }
        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 320px;
            padding-bottom: 10px;          /* Space between text and the line */
            line-height: 1.2;               /* Prevents extra height causing "double" looks */
            vertical-align: baseline;      /* Aligns the line with the text */
        }
        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            font-weight: normal;
            text-align: center;
        }
        .items-table td {
            padding: 0px 5px;
            vertical-align: top;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }

        /* Total Section */
        .total-section {
            border-top: 1px solid #000;
            /* border-bottom: 2px solid #000; */
            padding: 0px 0;
            margin-bottom: 20px;
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
    <div class="company-no">COMPANY NO: 202001039694 (1396015-V)</div>
    <div class="company-address">
        Ground Floor, Lot 1451, Section 66 KTLD, Jalan Keluli,<br>
        <div style="margin-top: -5px;">Bintawa Industrial Estate, 93450 Kuching, Sarawak</div>
    </div>

<table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <tr>
        <td style="width: 60%; vertical-align: top; padding: 0;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 60px; padding-bottom: 15px;">Pay To :</td>
                    <td class="underline" style="padding-bottom: 15px;">
                        <span style="min-width: 350px;">
                            {!! $voucher->pay_to ?: '&nbsp;' !!}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60px;">Ref No. :</td>
                    <td>
                        <span style="min-width: 350px;">
                            {!! $voucher->ref_no ?: '&nbsp;' !!}
                        </span>
                    </td>
                </tr>
            </table>
        </td>

        <td style="width: 40%; vertical-align: top; text-align: right; padding: 0;">
            <table class="info-table" style="width: 100%; text-align: right;">
                <tr style="font-weight: bold">
                    <td>PV No. :</td>
                    <td style="text-align: left; padding-left: 10px; width: 120px;">{{ $voucher->pv_no }}</td>
                </tr>
                <tr>
                    <td>Date :</td>
                    <td style="text-align: left; padding-left: 10px;">{{ \Carbon\Carbon::parse($voucher->pv_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Payment By :</td>
                    <td style="text-align: left; padding-left: 10px;">{{ $voucher->pay_by }}</td>
                </tr>
                <tr>
                    <td>Account :</td>
                    <td style="text-align: left; padding-left: 10px;">{{ $voucher->account_no }}</td>
                </tr>
                <tr>
                    <td>Ledger :</td>
                    <td style="text-align: left; padding-left: 10px;">{{ $voucher->ledger }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>


        <table class="items-table">
            <thead>
                <tr>
                    <th width="15%" class="text-center" style=" border-right: 1px solid #000;">Bil.</th>
                    <th width="75%">Payment Details</th>
                    <th width="20%" class="text-right">Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voucher->items as $item)
                <tr>
                    <td class="text-center">{{ $item->detail_no }}</td>
                    <td>{!! nl2br(e($item->payment_details)) !!}</td>
                    {{-- <td class="text-right">{{ number_format($item->amount, 2) }}</td> --}}
                    <td class="text-right">{{ $item['amount'] > 0 ? number_format($item['amount'], 2) : '' }}</td>
                    
                </tr>
                @endforeach
                <br>
                <br>
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

        <div style="margin-bottom: 0px;">
            Bank Cheque No. : {{ $voucher->bank_cheque_no }}<br>
            Cheque Date : {{ $voucher->cheque_date }}
        </div>

        <table style="width: 70%; margin: 40px auto 0 auto; border-collapse: collapse;" class="signature-section">
            <tr>
                <td style="width: 30%; text-align: center; vertical-align: bottom;">
                    <div style="padding-bottom: 5px;">
                        {!! $voucher->prepared_by ?: '&nbsp;' !!}
                    </div>
                    <div style="border-top: 1px solid #000; padding-top: 5px;">Prepared By</div>
                </td>

                <td style="width: 13%;"></td>

                <td style="width: 30%; text-align: center; vertical-align: bottom;">
                    <div style="padding-bottom: 5px;">
                        {!! $voucher->approved_by ?: '&nbsp;' !!}
                    </div>
                    <div style="border-top: 1px solid #000; padding-top: 5px;">Approved By</div>
                </td>

                <td style="width: 13%;"></td>

                <td style="width: 30%; text-align: center; vertical-align: bottom;">
                    <div style="padding-bottom: 5px;">
                        {!! $voucher->received_by ?: '&nbsp;' !!}
                    </div>
                    <div style="border-top: 1px solid #000; padding-top: 5px;">Received By</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>