<a class='list-group-item list-group-item-action<?php echo $active_option; ?> href='#'>
    <div class="row">
        <div class="col-11">
            <?php 
                if (strlen($command)>99) {
                    echo substr($command,0,100)." ..."; 
                } else {
                    echo $command;
                }
                
            ?>
        </div>
        <div class="col-1">
            <div class=''>
                <input hidden type='text' id='command<?php echo $i; ?>' class='form-control' value="<?php echo str_replace("\"", "'", $command); ?>">
            </div>
            <button type ='button' class='col-auto btn btn-outline-primary btn-clipboard' data-clipboard-action='copy' data-clipboard-target='#command<?php echo $i; ?>' data-clipboard-text="<?php echo str_replace("\"", "'", $command); ?>">
                <img src='../../../src/img/copy.png' alt='copy' height='24' width='24'>
            </button>
        </div>
    </div>
</a>

