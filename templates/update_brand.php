







<!-- Modal  to update brand from the database in the manage_brand.php page-->

<div class="modal fade" id="form_brand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Brand Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--  Category -->
        <form id="update_brand_form" onsubmit="return false">
          <div class="form-group">
            <label>Brand Name</label>
            <!-- we added new input for the sake of the id to edit  -->
            <input type="hidden" name="bid" id="bid" value="">
            <input type="text" class="form-control" name="update_brand" id="update_brand">
            <small id="cat_error" class="form-text text-muted"></small>
          </div>
         
          <button type="submit" class="btn btn-primary">Update Brand</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>