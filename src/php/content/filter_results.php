<?php

  try {
    $registry = new Registry(REGISTRY_URL);
  } catch(Exception $ex) {
    echo "<meta http-equiv='refresh' content='0; url=./../html/config_error.html'>";
  }

?>

<div class='container-fluid d-flex justify-content-between '>
    <p class='text-secondary mt-1'><span id='number_of_results'><?php echo $registry->getRepositoriesCount(); ?></span> result(s) avaible.</p>
    <div class='dropdown'>
        <button class='btn btn-danger dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
            Delete
        </button>
        <ul class='dropdown-menu'>
        <li><a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#delete_all_modal'>Delete all images...</a></li>
        <li><a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#delete_images_older'>Delete images older than...</a></li>
        </ul>
    </div>
</div>
<hr class='mt-2'>

<!-- Delete All Modal -->
<div class="modal fade" id="delete_all_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete all images...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../../../src/php/content/delete.php?action=deleteAll" method="post" onsubmit="return confirm('Are you sure you want to proceed?');">
        <div class="modal-body">
            All the images saved within this registry are going to be erased. 
            <div class="alert alert-warning mt-3" role='alert'>
                There is no going back !!!
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" value="Delete" class="btn btn-danger">
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Images Older than.. Modal -->
<div class="modal fade" id="delete_images_older" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete images older than...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../../../src/php/content/delete.php?action=deleteImagesOlderThan" method="post" onsubmit="return confirm('Are you sure you want to proceed?');">
        <div class="modal-body">
            <label for="days">Number of days : </label>
            <input type="number" name="days" id="days" min='1' >
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" value="Delete" class="btn btn-danger">
        </div>
      </form>
    </div>
  </div>
</div>