<div class="modal fade" id="invoiceModal" tabindex="-1">
    <div class="modal-dialog modal-xl app-form-container">
        <form id="invoiceForm" class="modal-content app-form-container" method="POST" action="/invoice/store">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Create Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Invoice Date</label>
                        <input type="date" name="invoice_date" id="inv_date" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No</label>
                        <input name="no" id="inv_no" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Customer ID</label>
                        <input name="customer_id" id="inv_customer" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">SST (%)</label>
                        <input name="sst_percentage" id="sst_percentage" class="form-control" value="0" oninput="calculateTotal()">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" id="inv_method" class="form-select">
                            <option value="Online Banking">Online Banking</option>
                            <option value="Cheques">Cheques</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Payment Terms</label>
                        <input name="payment_terms" id="inv_terms" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" id="inv_due" class="form-control">
                    </div>
                </div>

                <hr>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="form-label">Name</label><input name="company_name" id="inv_name" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Attention</label><input name="attention" id="inv_attn" class="form-control"></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8"><label class="form-label">Full Address</label><input name="address" id="inv_addr" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Phone</label><input name="phone" id="inv_phone" class="form-control"></div>
                </div>

                <hr>
                <h6>Items</h6>
                <table class="table table-sm" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Qty</th>
                            <th>Description</th>
                            <th width="120">Unit Price</th>
                            <th width="120">Total</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="addItem()">+ Add Item</button>

                <table class="table table-bordered w-50 ms-auto">
                    <tr><th>Subtotal</th><td>RM <span id="subtotal">0.00</span></td></tr>
                    <tr><th>SST</th><td>RM <span id="sst">0.00</span></td></tr>
                    <tr><th>Total</th><td><strong>RM <span id="final_total">0.00</span></strong></td></tr>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" id="submitBtn">Save Invoice</button>
            </div>
        </form>
    </div>
</div>

{{-- <script>
let rowCount = 0;
const modal = document.getElementById('invoiceModal');

modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const form = document.getElementById('invoiceForm');
    const methodInput = document.getElementById('formMethod');
    const modalTitle = document.getElementById('modalTitle');
    const dateInput = form.querySelector('[name="invoice_date"]');
    const submitBtn = document.getElementById('submitBtn');
    
    // Clear existing items
    document.querySelector('#itemsTable tbody').innerHTML = '';
    rowCount = 0;

    if (button.hasAttribute('data-invoice')) {
        // --- EDIT MODE ---
        const invoice = JSON.parse(button.getAttribute('data-invoice'));
        
        modalTitle.innerText = 'Edit Invoice';
        submitBtn.innerText = 'Update Invoice';
        form.action = `/invoice/${invoice.id}/update`;
        document.getElementById('formMethod').value = 'PUT';

        // Fill basic fields
        document.getElementById('inv_date').value = invoice.invoice_date;
        document.getElementById('inv_no').value = invoice.no;
        document.getElementById('inv_customer').value = invoice.customer_id;
        document.getElementById('sst_percentage').value = invoice.sst_percentage;
        document.getElementById('inv_method').value = invoice.payment_method;
        document.getElementById('inv_terms').value = invoice.payment_terms;
        document.getElementById('inv_due').value = invoice.due_date;
        document.getElementById('inv_name').value = invoice.company_name;
        document.getElementById('inv_attn').value = invoice.attention;
        document.getElementById('inv_addr').value = invoice.address;
        document.getElementById('inv_phone').value = invoice.phone;

        // Fill Items
        if(invoice.items && invoice.items.length > 0) {
            invoice.items.forEach(item => {
                addItem(item);
            });
        }
    } else {
        // --- CREATE MODE ---
        modalTitle.innerText = 'Create Invoice';
        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
        submitBtn.innerText = 'Save Invoice';
        form.action = '/invoice/store';
        document.getElementById('formMethod').value = 'POST';
        form.reset();
        document.getElementById('sst_percentage').value = 0;
        addItem(); // Add one blank row
    }
    calculateTotal();
});

function addItem(data = null) {
    const tbody = document.querySelector('#itemsTable tbody');
    const html = `
    <tr>
        <td><input type="number" name="items[${rowCount}][quantity]" class="form-control form-control-sm" value="${data ? data.quantity : ''}" oninput="calculateRow(this)"></td>
        <td><input type="text" name="items[${rowCount}][description]" class="form-control form-control-sm" value="${data ? data.description : ''}"></td>
        <td><input type="number" step="0.01" name="items[${rowCount}][unit_price]" class="form-control form-control-sm" value="${data ? data.unit_price : ''}" oninput="calculateRow(this)"></td>
        <td><input type="text" name="items[${rowCount}][total_price]" class="form-control form-control-sm" value="${data ? data.total_price : '0.00'}" readonly></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); calculateTotal();">×</button></td>
    </tr>`;
    tbody.insertAdjacentHTML('beforeend', html);
    rowCount++;
}

function calculateRow(input) {
    const rowEl = input.closest('tr');
    const qty = parseFloat(rowEl.querySelector('[name*="[quantity]"]').value) || 0;
    const price = parseFloat(rowEl.querySelector('[name*="[unit_price]"]').value) || 0;
    const total = qty * price;
    rowEl.querySelector('[name*="[total_price]"]').value = total.toFixed(2);
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    document.querySelectorAll('[name*="[total_price]"]').forEach(el => {
        subtotal += parseFloat(el.value) || 0;
    });
    const sstPercent = parseFloat(document.getElementById('sst_percentage').value) || 0;
    const sst = subtotal * (sstPercent / 100);
    const finalTotal = subtotal + sst;

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('sst').innerText = sst.innerText = sst.toFixed(2);
    document.getElementById('final_total').innerText = finalTotal.toFixed(2);
}
</script> --}}
<script>
let rowCount = 0;
const modal = document.getElementById('invoiceModal');

modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const form = document.getElementById('invoiceForm');
    const methodInput = document.getElementById('formMethod');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    
    // 1. Reset Form and Clear Items
    form.reset();
    document.querySelector('#itemsTable tbody').innerHTML = '';
    rowCount = 0;

    if (button && button.dataset.invoice) {
        // --- EDIT MODE ---
        const invoice = JSON.parse(button.dataset.invoice);

        modalTitle.innerText = 'Edit Invoice';
        submitBtn.innerText = 'Update Invoice';
        form.action = `/invoice/${invoice.id}/update`;
        methodInput.value = 'PUT';

        // Fill basic fields using querySelector (matching waybill style)
        form.querySelector('[name="invoice_date"]').value = invoice.invoice_date ? invoice.invoice_date.split('T')[0] : '';
        form.querySelector('[name="no"]').value = invoice.no;
        form.querySelector('[name="customer_id"]').value = invoice.customer_id;
        form.querySelector('[name="sst_percentage"]').value = invoice.sst_percentage;
        form.querySelector('[name="payment_method"]').value = invoice.payment_method;
        form.querySelector('[name="payment_terms"]').value = invoice.payment_terms ?? '';
        form.querySelector('[name="due_date"]').value = invoice.due_date ? invoice.due_date.split('T')[0] : '';
        
        form.querySelector('[name="company_name"]').value = invoice.company_name;
        form.querySelector('[name="attention"]').value = invoice.attention ?? '';
        form.querySelector('[name="address"]').value = invoice.address;
        form.querySelector('[name="phone"]').value = invoice.phone;

        form.querySelector('[name="invoice_date"]').value = invoice.invoice_date.split('T')[0];
        if (invoice.due_date) {
            form.querySelector('[name="due_date"]').value = invoice.due_date.split('T')[0];
        }

        // Fill Items
        if(invoice.items && invoice.items.length > 0) {
            invoice.items.forEach(item => {
                addItem(item);
            });
        } else {
            addItem(); // At least one row
        }
    } else {
        // --- CREATE MODE ---
        modalTitle.innerText = 'Create Invoice';
        submitBtn.innerText = 'Save Invoice';
        form.action = '/invoice/store';
        methodInput.value = 'POST';

        // Set default today's date
        const today = new Date().toISOString().split('T')[0];
        form.querySelector('[name="invoice_date"]').value = today;
        form.querySelector('[name="sst_percentage"]').value = 0;

        addItem(); // Add one blank row
    }
    
    calculateTotal();
});

function addItem(data = null) {
    const tbody = document.querySelector('#itemsTable tbody');

    const qtyValue = (data && data.quantity > 0) ? data.quantity : '';
    const priceValue = (data && data.unit_price > 0) ? data.unit_price : '';
    
    // For total price, we format to 2 decimal places if it's > 0
    const totalValue = (data && data.total_price > 0) ? parseFloat(data.total_price).toFixed(2) : '';
    const html = `
    <tr>
        <td><input type="number" name="items[${rowCount}][quantity]" class="form-control form-control-sm" value="${data ? data.quantity : ''}" oninput="calculateRow(this)"></td>
        <td><input type="text" name="items[${rowCount}][description]" class="form-control form-control-sm" value="${data ? data.description : ''}"></td>
        <td><input type="number" step="0.01" name="items[${rowCount}][unit_price]" class="form-control form-control-sm" value="${data ? data.unit_price : ''}" oninput="calculateRow(this)"></td>
        <td><input type="text" name="items[${rowCount}][total_price]" class="form-control form-control-sm" value="${(data && parseFloat(data.total_price) > 0) ? parseFloat(data.total_price).toFixed(2) : ''}" readonly></td>
        <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); calculateTotal();">×</button></td>
    </tr>`;
    tbody.insertAdjacentHTML('beforeend', html);
    rowCount++;
}

function calculateRow(input) {
    const rowEl = input.closest('tr');
    const qty = parseFloat(rowEl.querySelector('[name*="[quantity]"]').value) || 0;
    const price = parseFloat(rowEl.querySelector('[name*="[unit_price]"]').value) || 0;
    const total = qty * price;
    // rowEl.querySelector('[name*="[total_price]"]').value = total.toFixed(2);
    rowEl.querySelector('[name*="[total_price]"]').value = (total > 0) ? total.toFixed(2) : '';
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    document.querySelectorAll('[name*="[total_price]"]').forEach(el => {
        subtotal += parseFloat(el.value) || 0;
    });
    
    // Correctly find SST percentage from the form
    const sstPercent = parseFloat(document.querySelector('[name="sst_percentage"]').value) || 0;
    const sst = subtotal * (sstPercent / 100);
    const finalTotal = subtotal + sst;

    document.getElementById('subtotal').innerText = subtotal.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('sst').innerText = sst.toLocaleString(undefined, {minimumFractionDigits: 2});
    document.getElementById('final_total').innerText = finalTotal.toLocaleString(undefined, {minimumFractionDigits: 2});
}
</script>