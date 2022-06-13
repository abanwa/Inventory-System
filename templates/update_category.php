



<!-- Modal  to update categories from the database in the manage_categories.php page-->

<div class="modal fade" id="form_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Category Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--  Category -->
        <form id="update_category_form" onsubmit="return false">
          <div class="form-group">
            <label>Category Name</label>
            <!-- we added new input for the sake of the id to edit  -->
            <input type="hidden" name="cid" id="cid" value="">
            <input type="text" class="form-control" name="update_category" id="update_category">
            <small id="cat_error" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <label>Parent Category</label>
            <select class="form-control" name="parent_cat" id="parent_cat">
              
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>