<div class="row mb-3">
    <div class="list-group command_list">
        <?php
            $commands = $currentTag->getCmdConfigs();
            $i = 0;
            foreach(array_reverse($commands) as $command_key => $command) {
                $active_option = "";
                if ($command_key == 0) {
                    $active_option = "\" aria-current='true' ";
                }
                $last = substr($command, strlen($command) - 1 );
                if ($last == '>') {
                    str_replace_last("<", '&lt;', $command);
                    str_replace_last(">", '&gt;', $command);
                }
                include 'image_layer.php';
                $i++;
            }
        ?>
    </div>
</div>


