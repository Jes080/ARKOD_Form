<div class="modal fade" id="customerModal">
<div class="modal-dialog modal-lg">
<form method="POST" id="customerForm">
@csrf
<input type="hidden" name="_method" id="method">

<div class="modal-content">
    <div class="modal-header">
        <h5 id="modalTitle">Add Customer</h5>
    </div>

    <div class="modal-body row g-2">
        <input class="form-control" name="name" placeholder="Name" required>
        <textarea class="form-control" name="address" placeholder="Address"></textarea>
        <input class="form-control" name="postcode" placeholder="Postcode">
        <input class="form-control" name="phone" placeholder="Phone">
        <input class="form-control" name="email" placeholder="Email">
    </div>

    <div class="modal-footer">
        <button class="btn btn-success">Save</button>
    </div>
</div>
</form>
</div>
</div>
