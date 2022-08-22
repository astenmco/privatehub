<?php

    echo "<div class='accordion' id='repository_items'>";

    try {
        $registry = new Registry(REGISTRY_URL);
    } catch(Exception $ex) {
        echo "<meta http-equiv='refresh' content='0; url=./config_error.html'>";
    }
    $repos = $registry->getRepositories();

    /**
     * Listing the info for each repository
     */
    foreach($repos as $i => $repository_name) {

        include 'repository_item.php';
        
    }    

    echo "</div>";
?>

    


