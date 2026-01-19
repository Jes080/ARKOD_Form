<div class="modal fade" id="pvModal" tabindex="-1">
    <div class="modal-dialog modal-xl app-form-container">
        <form id="pvForm" class="modal-content app-form-container" method="POST" action="/payment-voucher/store">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Create Payment Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">PV Date</label>
                        <input type="date" name="pv_date" id="pv_date" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">No</label>
                        <input name="no" id="pv_no" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment By</label>
                        {{-- <input name="pay_by" id="pay_by" class="form-control"> --}}
                        <select name="pay_by" id="pay_by" class="form-select">
                            <option>CASH AT BANK</option>
                            <option>CASH IN HAND</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Account No</label>
                        <input name="account_no" id="account_no" class="form-control" value="PBBANK 3223583706">
                    </div>
                    {{-- </div>
                    <div class="col-md-4">
                        <label class="form-label">Ledger</label>
                        <select name="ledger" id="ledger" class="form-select">
                            <option> </option>
                            <option>AMOUNT OWING TO DIRECTOR</option>
                            <option>TRANSPORTATION CHARGES</option>
                            <option>PALLETS EXPENSES</option>
                            <option>STORAGE EXPENSES</option>
                            <option>LEGAL AND PROFESSIONAL FEES</option>
                            <option>TELEPHONE CHARGES</option>
                            <option>INTERNET CHARGES</option>
                            <option>RENTAL EXPENSES</option>
                            <option>PRINTING AND STATIONERY</option>
                            <option>MEMBERSHIP AND SUBSCRIPTION FEES</option>
                            <option>OUTSOURCE</option>
                        </select>
                    </div> --}}
                    <div class="col-md-4">
                    <label class="form-label">Ledger</label>
                    <input name="ledger" id="ledger" class="form-control" style="max-width: 1000%" list="ledgerOptions" placeholder="Select or type ledger...">
                    
                    <datalist id="ledgerOptions">
                        <option value="AMOUNT OWING TO DIRECTOR">
                        <option value="TRANSPORTATION CHARGES">
                        <option value="PALLETS EXPENSES">
                        <option value="STORAGE EXPENSES">
                        <option value="LEGAL AND PROFESSIONAL FEES">
                        <option value="TELEPHONE CHARGES">
                        <option value="INTERNET CHARGES">
                        <option value="RENTAL EXPENSES">
                        <option value="PRINTING AND STATIONERY">
                        <option value="MEMBERSHIP AND SUBSCRIPTION FEES">
                        <option value="OUTSOURCE">
                    </datalist>
                </div>
                    {{-- <div class="col-md-4">
                        <label class="form-label">Pay To</label>
                        <input type="text" name="pay_to" id="pay_to" class="form-control">
                    </div> --}}
                </div>

                <hr>
                <div class="row mb-3">
                    <div class="col-md-6"><label class="form-label">Pay To</label><input name="pay_to" id="pay_to" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Ref. No.</label><input name="ref_no" id="ref_no" class="form-control"></div>
                </div>

                <div class="row mb-3">
                    {{-- <div class="col-md-8"><label class="form-label">Prepared By</label><input name="prepared_by" id="prepared_by" class="form-control"></div> --}}
                        {{-- <label class="form-label">Prepared By</label>
                        <select name="prepared_by" id="prepared_by" class="form-select">
                            <option>JESDYLISIA</option>
                            <option>YU SHAN</option>
                            <option> </option>
                        </select> --}}
                        <div class="col-md-4">
                            <label class="form-label">Prepared By</label>
                            <input name="prepared_by" id="prepared_by" class="form-control" list="preparedByOptions">
                            
                            <datalist id="preparedByOptions">
                                <option value="JESDYLISIA">
                                <option value="YU SHAN">
                            </datalist>
                        </div>
                    <div class="col-md-4"><label class="form-label">Approved By</label><input name="approved_by" id="approved_by" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Received By</label><input name="received_by" id="received_by" class="form-control"></div>
                </div>

                <hr>
                <h6>Items</h6>
                <table class="table table-sm" id="itemsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="80">No.</th>
                            <th>Payment Details</th>
                            <th width="120">Amount</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="addItem()">+ Add Item</button>

                <table class="table table-bordered w-50 ms-auto">
                    <tr><th>Total</th><td><strong>RM <span id="total_amount">0.00</span></strong></td></tr>
                    <tr>
                        <th>Ringgit Malaysia</th>
                        <td> 
                            <span id="total_amount_word"></span>
                            <input type="hidden" name="total_amount_word" id="total_amount_word_input">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" id="submitBtn">Save Payment Voucher</button>
            </div>
        </form>
    </div>
</div>
{{-- <script>
let rowCount = 0;
const modal = document.getElementById('pvModal');

modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const form = document.getElementById('pvForm');
    const methodInput = document.getElementById('formMethod');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    
    // 1. Reset Form and Clear Items
    form.reset();
    document.querySelector('#itemsTable tbody').innerHTML = '';
    rowCount = 0;

    if (button && button.dataset.pv) {
        // --- EDIT MODE ---
        const pv = JSON.parse(button.dataset.pv);

        modalTitle.innerText = 'Edit Payment Voucher';
        submitBtn.innerText = 'Update Payment Voucher';
        form.action = `/payment-voucher/${pv.id}/update`;
        methodInput.value = 'PUT';

        // Fill basic fields
        form.querySelector('[name="pv_date"]').value = pv.pv_date ? pv.pv_date.split('T')[0] : '';
        form.querySelector('[name="no"]').value = pv.no;
        form.querySelector('[name="customer_id"]').value = pv.customer_id ?? '';
        form.querySelector('[name="pay_by"]').value = pv.pay_by;
        form.querySelector('[name="account_no"]').value = pv.account_no ?? '';
        form.querySelector('[name="ledger"]').value = pv.ledger ?? '';
        form.querySelector('[name="pay_to"]').value = pv.pay_to ?? '';
        form.querySelector('[name="ref_no"]').value = pv.ref_no ?? '';
        form.querySelector('[name="prepared_by"]').value = pv.prepared_by ?? '';
        form.querySelector('[name="approved_by"]').value = pv.approved_by ?? '';
        form.querySelector('[name="received_by"]').value = pv.received_by ?? '';

        // Fill Items
        if(pv.items && pv.items.length > 0) {
            pv.items.forEach(item => addItem(item));
        } else {
            addItem(); 
        }
    } else {
        // --- CREATE MODE ---
        modalTitle.innerText = 'Create Payment Voucher';
        submitBtn.innerText = 'Save Payment Voucher';
        form.action = '/payment-voucher/store';
        methodInput.value = 'POST';

        const today = new Date().toISOString().split('T')[0];
        form.querySelector('[name="pv_date"]').value = today;

        addItem(); // Add one blank row
    }
    
    calculateTotal();
});

function addItem(data = null) {
    const tbody = document.querySelector('#itemsTable tbody');
    
    // 1. Prepare values - all can be empty strings if no data exists
    const detailNoValue = data ? (data.detail_no ?? '') : '';
    const detailsValue = data ? data.payment_details : '';
    const amountValue = (data && data.amount > 0) ? parseFloat(data.amount).toFixed(2) : '';

    const html = `
    <tr>
        <td>
            <input type="text" name="items[${rowCount}][detail_no]" 
                   class="form-control form-control-sm text-center" 
                   value="${detailNoValue}">
        </td>
        
        <td>
            <input type="text" name="items[${rowCount}][payment_details]" 
                   class="form-control form-control-sm" 
                   value="${detailsValue}" required>
        </td>
        
        <td>
            <input type="number" step="0.01" name="items[${rowCount}][amount]" 
                   class="form-control form-control-sm text-end" 
                   value="${amountValue}" 
                   oninput="calculateTotal()">
        </td>
        
        <td>
            <button type="button" class="btn btn-sm btn-danger" 
                    onclick="this.closest('tr').remove(); calculateTotal();">×</button>
        </td>
    </tr>`;
    
    tbody.insertAdjacentHTML('beforeend', html);
    rowCount++;
}

function calculateTotal() {
    let total = 0;
    
    document.querySelectorAll('[name*="[amount]"]').forEach(el => {
        total += parseFloat(el.value) || 0;
    });
    
    document.getElementById('total_amount').innerText = total > 0 
        ? total.toLocaleString(undefined, {minimumFractionDigits: 2}) 
        : '0.00';
    
    const wordDisplay = document.getElementById('total_amount_word');
    const wordInput = document.getElementById('total_amount_word_input'); // NEW LINE
    
    if (total > 0) {
        const resultWords = amountToWords(total) + " ONLY";
        wordDisplay.innerText = resultWords;
        wordInput.value = resultWords; // NEW LINE: This sends it to Laravel
    } else {
        wordDisplay.innerText = "";
        wordInput.value = ""; // NEW LINE
    }
}

// Helper function to convert number to Ringgit Words
function amountToWords(amount) {
    if (amount === 0) return "ZERO";
    
    const words = ["", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN", "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN", "NINETEEN"];
    const tens = ["", "", "TWENTY", "THIRTY", "FORTY", "FIFTY", "SIXTY", "SEVENTY", "EIGHTY", "NINETY"];
    const scales = ["", "THOUSAND", "MILLION"];

    function convert(n) {
        if (n < 20) return words[n];
        if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 !== 0 ? " " + words[n % 10] : "");
        if (n < 1000) return words[Math.floor(n / 100)] + " HUNDRED" + (n % 100 !== 0 ? " AND " + convert(n % 100) : "");
        return "";
    }

    let str = "";
    let parts = amount.toFixed(2).split(".");
    let ringgit = parseInt(parts[0]);
    let sen = parseInt(parts[1]);

    if (ringgit > 0) {
        let i = 0;
        while (ringgit > 0) {
            if (ringgit % 1000 !== 0) {
                str = convert(ringgit % 1000) + (scales[i] ? " " + scales[i] : "") + (str ? " " + str : "");
            }
            ringgit = Math.floor(ringgit / 1000);
            i++;
        }
        str += " RINGGIT";
    }

    if (sen > 0) {
        str += (str ? " AND " : "") + convert(sen) + " SEN";
    }

    return str;
}
</script> --}}
<script>
let rowCount = 0;
const modal = document.getElementById('pvModal');

modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const form = document.getElementById('pvForm');
    const methodInput = document.getElementById('formMethod');
    const modalTitle = document.getElementById('modalTitle');
    const submitBtn = document.getElementById('submitBtn');
    
    // 1. Reset Form and Clear Items Table
    form.reset();
    document.querySelector('#itemsTable tbody').innerHTML = '';
    rowCount = 0;

    // 2. Check if we are in Edit Mode (button has data-pv)
    if (button && button.dataset.pv) {
        const pv = JSON.parse(button.dataset.pv);

        modalTitle.innerText = 'Edit Payment Voucher';
        submitBtn.innerText = 'Update Payment Voucher';
        form.action = `/payment-voucher/${pv.id}/update`;
        methodInput.value = 'PUT';

        const fill = (name, value) => {
            const el = form.querySelector(`[name="${name}"]`);
            if (el) el.value = value ?? '';
        };

        // Fill basic fields using the 'name' attribute
        form.querySelector('[name="pv_date"]').value = pv.pv_date ? pv.pv_date.split('T')[0] : '';
        form.querySelector('[name="no"]').value = pv.no;
        form.querySelector('[name="pay_by"]').value = pv.pay_by;
        form.querySelector('[name="account_no"]').value = pv.account_no ?? '';
        form.querySelector('[name="ledger"]').value = pv.ledger ?? '';
        form.querySelector('[name="pay_to"]').value = pv.pay_to ?? '';
        form.querySelector('[name="ref_no"]').value = pv.ref_no ?? '';
        form.querySelector('[name="prepared_by"]').value = pv.prepared_by ?? '';
        form.querySelector('[name="approved_by"]').value = pv.approved_by ?? '';
        form.querySelector('[name="received_by"]').value = pv.received_by ?? '';

        // Fill Items
        if (pv.items && pv.items.length > 0) {
            pv.items.forEach(item => addItem(item));
        } else {
            addItem(); 
        }
    } else {
        // --- CREATE MODE ---
        modalTitle.innerText = 'Create Payment Voucher';
        submitBtn.innerText = 'Save Payment Voucher';
        form.action = '/payment-voucher/store';
        methodInput.value = 'POST';

        const today = new Date().toISOString().split('T')[0];
        form.querySelector('[name="pv_date"]').value = today;

        addItem(); // Add one blank row for new entry
    }
    
    calculateTotal();
});

function addItem(data = null) {
    const tbody = document.querySelector('#itemsTable tbody');
    
    // Values extracted from data object (for Edit Mode)
    const detailNoValue = data ? (data.detail_no ?? '') : '';
    const detailsValue = data ? (data.payment_details ?? '') : '';
    const amountValue = (data && data.amount > 0) ? parseFloat(data.amount).toFixed(2) : '';

    const html = `
    <tr>
        <td>
            <input type="text" name="items[${rowCount}][detail_no]" 
                   class="form-control form-control-sm text-center" 
                   value="${detailNoValue}">
        </td>
        <td>
            <input type="text" name="items[${rowCount}][payment_details]" 
                   class="form-control form-control-sm" 
                   value="${detailsValue}" required>
        </td>
        <td>
            <input type="number" step="0.01" name="items[${rowCount}][amount]" 
                   class="form-control form-control-sm text-end" 
                   value="${amountValue}" 
                   oninput="calculateTotal()">
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" 
                    onclick="this.closest('tr').remove(); calculateTotal();">×</button>
        </td>
    </tr>`;
    
    tbody.insertAdjacentHTML('beforeend', html);
    rowCount++;
}

function calculateTotal() {
    let total = 0;
    
    // Select all inputs where name contains [amount]
    document.querySelectorAll('[name*="[amount]"]').forEach(el => {
        total += parseFloat(el.value) || 0;
    });
    
    // Update Display
    document.getElementById('total_amount').innerText = total.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    
    // Handle the Word Conversion
    const wordDisplay = document.getElementById('total_amount_word');
    const wordInput = document.getElementById('total_amount_word_input');
    
    if (total > 0) {
        const resultWords = amountToWords(total) + " ONLY";
        wordDisplay.innerText = resultWords;
        wordInput.value = resultWords;
    } else {
        wordDisplay.innerText = "";
        wordInput.value = "";
    }
}

// Keep your existing amountToWords function below...
// Helper function to convert number to Ringgit Words
function amountToWords(amount) {
    if (amount === 0) return "ZERO";
    
    const words = ["", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", "SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN", "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN", "NINETEEN"];
    const tens = ["", "", "TWENTY", "THIRTY", "FORTY", "FIFTY", "SIXTY", "SEVENTY", "EIGHTY", "NINETY"];
    const scales = ["", "THOUSAND", "MILLION"];

    function convert(n) {
        if (n < 20) return words[n];
        if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 !== 0 ? " " + words[n % 10] : "");
        if (n < 1000) return words[Math.floor(n / 100)] + " HUNDRED" + (n % 100 !== 0 ? " AND " + convert(n % 100) : "");
        return "";
    }

    let str = "";
    let parts = amount.toFixed(2).split(".");
    let ringgit = parseInt(parts[0]);
    let sen = parseInt(parts[1]);

    if (ringgit > 0) {
        let i = 0;
        while (ringgit > 0) {
            if (ringgit % 1000 !== 0) {
                str = convert(ringgit % 1000) + (scales[i] ? " " + scales[i] : "") + (str ? " " + str : "");
            }
            ringgit = Math.floor(ringgit / 1000);
            i++;
        }
        str += " RINGGIT";
    }

    if (sen > 0) {
        str += (str ? " AND " : "") + convert(sen) + " SEN";
    }

    return str;
}
</script>