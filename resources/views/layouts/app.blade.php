<!DOCTYPE html>
<html>
<head>
    <title>ARKOD Form</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (optional but recommended) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

</head>
<body class="bg-gradient-theme">
<div class="container-fluid">
    <div class="row vh-100">

        <!-- Sidebar -->
        <div class="col-2 bg-dark text-white p-3">
            <h5 class="mb-4">ARKOD</h5>
            <ul class="nav flex-column">
                {{-- <li class="nav-item">
                    <a class="nav-link text-white" href="/">Dashboard</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link text-white" href="/waybill">Waybill</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/invoice">Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/payment-voucher">Payment Voucher</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/vehicle-shipping">Vehicle Shipping List</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="col-10 p-4">
            @yield('content')
        </div>

    </div>
</div>

</body>
</html>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')