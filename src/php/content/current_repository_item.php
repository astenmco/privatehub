<div class='container'>
    <div class='row'>
        <div class='col'>
            <div class='card'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-1'>
                            <img src='../../../src/img/folder.png' alt='Repository Icon' width='55' height='42'>
                        </div>
                        <div class='col-9'>
                            <h5 class='card-title' id='card_repo_name'><?php echo $_GET['repo']; ?></h5>
                            <h6 class='card-subtitle text-muted' id='card_date'>Last updated <strong><span class='last_pushed'><?php echo $last_pushed; ?></span> ago</strong> by <a href='' class='pushed_by'><?php echo $author ?></a></h6>
                        </div>
                    </div>   
                    <div class='row mt-2'>
                        <div class='card-text col-1'></div>
                        <div class='card-text col' id='card_description'><?php echo $description; ?></div>
                    </div>
                    <div class='row mt-3 d-flex align-items-center'>
                        <div class='card-text col-1'></div>
                        <ul class='col-9 repository_arch_list' id='repository_architectures_list'>
                            <?php echo $architectures; ?>
                        </ul>
                        <div class="col-2">
                        <a value="Delete" type="submit" href="../../../src/php/content/delete.php?repo=<?php echo $_GET['repo']; ?>&action=deleteRepositoryTags" class="btn btn-xl btn-danger delete_tag_button">
                            Delete all tags
                        </a>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </div>
    <div class='row mt-3'>
        <div class='col'>
            <div class='card'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-11'>
                            <input readonly type='text' id='copyPasteBlock' class='form-control' value='sudo docker image pull <?php echo REGISTRY_URL."/".$_GET['repo'].":latest";?>'>
                        </div>
                        <div class='col-1'>
                            <button type ='button' class='btn btn-outline-primary btn-clipboard' data-clipboard-action='copy' data-clipboard-target='#copyPasteBlock'>
                                <img src='../../../src/img/copy.png' alt='copy' height='24' width='24'>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>