



<!-- Modal  for products-->

<div class="modal fade" id="form_products" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <!--        Product form      -->

      <form id="product_form" onsubmit="return false">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Date</label>
              <input type="text" class="form-control" name="added_date" id="added_date" value="<?php echo date("Y-m-d"); ?>" readonly>
            </div>
            <div class="form-group col-md-6">
              <label>Product Name</label>
              <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" required>
            </div>
          </div>
            <div class="form-group">
              <label>Category</label>
              <select class="form-control" id="select_cat" name="select_cat" required>
                      
                      <!--   The Select options are gotteen from the database  with the code in main.js( fetch category function()) -->
                
              </select>
            </div>
            <div class="form-group">
              <label>Brand</label>
              <select class="form-control" id="select_brand" name="select_brand" required>



                
              </select>
            </div>
            <div class="form-group">
              <label>Product Price</label>
              <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter Price of Product" required>
            </div>
            <div class="form-group">
              <label>Quantity</label>
              <input type="text" class="form-control" name="product_qty" id="product_qty" placeholder="Enter Quantity" required>
            </div>
            
          
          <button type="submit" class="btn btn-success">Add Product</button>
      </form>

        <!--        End of Product form  -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




