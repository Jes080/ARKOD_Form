<div class="modal fade" id="customerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="customerForm" class="modal-content" method="POST" action="/customer/store">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12 position-relative">
                        <label class="form-label">Company Name</label>
                        <input class="form-control" name="name" id="customer_search" placeholder="Type to search or enter new name" required autocomplete="off">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div id="customer_results" class="list-group position-absolute w-100" style="z-index: 1051; display: none; max-height: 200px; overflow-y: auto;"></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Street Address"></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Postcode</label>
                        <input class="form-control" name="postcode" placeholder="Postcode">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Attention</label>
                        <input class="form-control" name="attention" placeholder="Attention">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Phone</label>
                        <input class="form-control" name="phone" placeholder="Phone Number">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="email@example.com">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" id="submitBtn">Save Customer</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
    const customerModalEl = document.getElementById('customerModal');

    // --- 1. MODAL OPEN/EDIT LOGIC ---
    customerModalEl.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const form = document.getElementById('customerForm');
        const methodInput = document.getElementById('formMethod');
        const modalTitle = document.getElementById('modalTitle');
        const submitBtn = document.getElementById('submitBtn');

        form.reset();
        $('#customer_results').hide().html(''); // Clear search results on open

        if (button && button.dataset.customer) {
            const data = JSON.parse(button.dataset.customer);
            modalTitle.innerText = 'Edit Customer';
            submitBtn.innerText = 'Update Customer';
            form.action = `/customer/${data.id}/update`; 
            methodInput.value = 'PUT';

            form.querySelector('[name="name"]').value = data.name;
            form.querySelector('[name="address"]').value = data.address ?? '';
            form.querySelector('[name="postcode"]').value = data.postcode ?? '';
            form.querySelector('[name="attention"]').value = data.attention ?? '';
            form.querySelector('[name="phone"]').value = data.phone ?? ''; 
            form.querySelector('[name="email"]').value = data.email ?? '';
        } else {
            modalTitle.innerText = 'Add New Customer';
            submitBtn.innerText = 'Save Customer';
            form.action = '/customer/store'; 
            methodInput.value = 'POST';
        }
    });

});
</script>