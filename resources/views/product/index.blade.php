@extends('layouts.master')
@section('content')

<div id="items" class="container">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#productModal">Add Product<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
<div class="card-body" style="height: 210px;">
    <input type="text" id='productSearch' placeholder="--search--">
</div>
<div class="table-responsive">
    <table id="ptable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Product Type</th>
                <th>Price</th>
                <th>Image</th>
                <th>Stock</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody id="pbody"></tbody>
    </table>
</div>
</div>
<div class="modal fade" id="productModal" role="dialog" style="display:none">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create new product</h4>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="pform" method="#" action="#" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="productId" class="control-label">Product ID</label>
                  <input type="text" class="form-control" id="productId" name="product_id" readonly>
              </div>
              <div class="form-group">
                  <label for="productName" class="control-label">Product Name</label>
                  <input type="text" class="form-control" id="productName" name="product_name">
              </div>
              <div class="form-group">
                  <label for="brandId" class="control-label">Brand Name</label>
                  <input type="text" class="form-control" id="brandId" name="brand_id">
              </div>
              <div class="form-group">
                  <label for="productType" class="control-label">Product Type</label>
                  <select class="form-control" id="productType" name="product_type">
                      <option value="sunscreen">Sunscreen</option>
                      <option value="toner">Toner</option>
                      <option value="serum">Serum</option>
                      <option value="facial_wash">Facial Wash</option>
                      <option value="mud_powder">Mud Powder</option>
                      <!-- Add more options as needed -->
                  </select>
              </div>
              <div class="form-group">
                  <label for="price" class="control-label">Price</label>
                  <input type="text" class="form-control" id="price" name="price" pattern="^\d+(\.\d{1,2})?$" title="Enter a valid price">
              </div>
              <div class="form-group">
                  <label for="stock" class="control-label">Stock</label>
                  <input type="number" class="form-control" id="stock" name="stock" min="0">
              </div>
              <div class="form-group">
                  <label for="images" class="control-label">Images</label>
                  <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
              </div>
          </form>
        </div>
        <div class="modal-footer" id="footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="productSubmit" type="submit" class="btn btn-primary">Save</button>
          <button id="productUpdate" type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
</div>
@endsection