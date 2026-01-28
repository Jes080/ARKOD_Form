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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-gradient-theme">
<div class="container-fluid">
    <div class="row vh-100">

        <!-- Sidebar -->
        <div class="col-2 bg-dark text-white p-3">
            <h5 class="mb-4">ARKOD</h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="/customer">Customer Data</a>
                </li>
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
<script>
// document.getElementById('customer_search').addEventListener('input', function() {
//     let query = this.value;
//     let resultsDiv = document.getElementById('customer_results');

//     if (query.length < 2) {
//         resultsDiv.style.display = 'none';
//         return;
//     }

//     fetch(`/customers/search?q=${query}`)
//         .then(response => response.json())
//         .then(data => {
//             resultsDiv.innerHTML = '';
//             if (data.length > 0) {
//                 resultsDiv.style.display = 'block';
//                 data.forEach(customer => {
//                     let item = document.createElement('a');
//                     item.href = '#';
//                     item.className = 'list-group-item list-group-item-action';
//                     item.innerHTML = `<strong>${customer.name}</strong>`;
                    
//                     item.onclick = (e) => {
//                         e.preventDefault();
//                         // 1. Fill the Name
//                         document.getElementById('customer_search').value = customer.name;
                        
//                         // 2. Fill Other Fields (Ensure these IDs exist in your modal)
//                         if(document.getElementById('inv_addr')) document.getElementById('inv_addr').value = customer.address;
//                         if(document.getElementById('inv_phone')) document.getElementById('inv_phone').value = customer.phone;
//                         // For your PV:
//                         if(document.querySelector('[name="address"]')) document.querySelector('[name="address"]').value = customer.address;

//                         resultsDiv.style.display = 'none';
//                     };
//                     resultsDiv.appendChild(item);
//                 });
//             } else {
//                 resultsDiv.style.display = 'none';
//             }
//         });
// });

// // Hide results if clicking outside
// document.addEventListener('click', function (e) {
//     if (e.target.id !== 'customer_search') {
//         document.getElementById('customer_results').style.display = 'none';
//     }
// });
</script>

@yield('scripts')