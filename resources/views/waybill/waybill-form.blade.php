<div class="modal fade" id="waybillModal" tabindex="-1">
    {{-- <div class="modal-dialog modal-xl app-form-container"> --}}
    <div class="modal-dialog app-form-container" style="max-width: 60%;">
        <form id="waybillForm" class="modal-content app-form-container" method="POST" action="/waybill/store">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Create Waybill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- BASIC INFO -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">No</label>
                        <input name="no" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Customer ID</label>
                        <input name="customer_id" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Service Type</label>
                        <select name="service_type" class="form-select">
                            <option>Door to Door</option>
                            <option>Pick Up</option>
                            <option>Sea Freight</option>
                            <option>Air Freight</option>
                            <option>Land Transport</option>
                            <option>Domestic Pick Up</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="waybill_date" class="form-control" required>
                    </div>
                </div>

                <hr>

                <!-- SHIPPER -->
                <h6 class="fw-bold mb-3">Shipper Details</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input name="shipper[name]" id="customer_search" class="form-control" autocomplete="off">
                        <div id="customer_results" class="list-group position-absolute w-100" style="z-index: 1000; display: none;"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Attention</label>
                        <input name="shipper[attention]" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Address</label>
                        <input name="shipper[address]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Postcode</label>
                        <input name="shipper[postcode]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Phone</label>
                        <input name="shipper[tel]" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input name="shipper[email]" class="form-control">
                    </div>
                </div>

                <hr>

                <!-- RECEIVER -->
                <h6 class="fw-bold mb-3">Receiver Details</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input name="receiver[name]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Attention</label>
                        <input name="receiver[attention]" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Address</label>
                        <input name="receiver[address]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Postcode</label>
                        <input name="receiver[postcode]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Phone</label>
                        <input name="receiver[tel]" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input name="receiver[email]" class="form-control">
                    </div>
                </div>

                <hr>

                <!-- ORDER PRODUCTS -->
                <h6 class="fw-bold mb-3">Order Products</h6>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Content</label>
                        <input name="order[content]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Category</label>
                        <input name="order[category]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Size</label>
                        <input name="order[size]" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Total Weight</label>
                        <input name="order[total_weight]" class="form-control">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="submitBtn">Generate Waybill</button>
            </div>

        </form>
    </div>
</div>
<script>
const modal = document.getElementById('waybillModal');

modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const form = document.getElementById('waybillForm');
    const methodInput = document.getElementById('formMethod');
    const modalTitle = document.getElementById('modalTitle');
    const dateInput = form.querySelector('[name="waybill_date"]');
    const submitBtn = document.getElementById('submitBtn');

    form.reset();

    if (button && button.dataset.waybill) {
        // EDIT
        const waybill = JSON.parse(button.dataset.waybill);

        modalTitle.innerText = 'Edit Waybill';
        submitBtn.innerText = 'Update Waybill';

        form.action = `/waybill/${waybill.id}/update`;
        methodInput.value = 'PUT';

        // BASIC INFO
        form.querySelector('[name="no"]').value = waybill.no;
        form.querySelector('[name="customer_id"]').value = waybill.customer_id;
        form.querySelector('[name="service_type"]').value = waybill.service_type;
        form.querySelector('[name="waybill_date"]').value = waybill.waybill_date;

        // SHIPPER
        form.querySelector('[name="shipper[name]"]').value = waybill.shipper_name;
        form.querySelector('[name="shipper[attention]"]').value = waybill.shipper_attention ?? '';
        form.querySelector('[name="shipper[address]"]').value = waybill.shipper_address;
        form.querySelector('[name="shipper[postcode]"]').value = waybill.shipper_postcode;
        form.querySelector('[name="shipper[tel]"]').value = waybill.shipper_phone;
        form.querySelector('[name="shipper[email]"]').value = waybill.shipper_email ?? '';

        // RECEIVER
        form.querySelector('[name="receiver[name]"]').value = waybill.receiver_name;
        form.querySelector('[name="receiver[attention]"]').value = waybill.receiver_attention ?? '';
        form.querySelector('[name="receiver[address]"]').value = waybill.receiver_address;
        form.querySelector('[name="receiver[postcode]"]').value = waybill.receiver_postcode;
        form.querySelector('[name="receiver[tel]"]').value = waybill.receiver_phone;
        form.querySelector('[name="receiver[email]"]').value = waybill.receiver_email ?? '';

        // ORDER
        form.querySelector('[name="order[content]"]').value = waybill.content ?? '';
        form.querySelector('[name="order[category]"]').value = waybill.category ?? '';
        form.querySelector('[name="order[size]"]').value = waybill.size ?? '';
        form.querySelector('[name="order[total_weight]"]').value = waybill.total_weight ?? '';


    } else {
        // CREATE
        modalTitle.innerText = 'Create Waybill';

        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;

        submitBtn.innerText = 'Save Waybill';

        form.action = '/waybill/store';
        // methodInput.removeAttribute('value');
        methodInput.value = 'POST';
    }
});
</script>
