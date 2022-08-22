<?php

    echo "<div class='container'>";
    
    foreach($tags as $tag_index=>$tag){

        $currentTag = $repo->getTag($tag);
        $authors_exploded = explode("<", $currentTag->getLabels()->getAuthors());
        
        if (isset($authors_exploded[1])) {
            $author = $authors_exploded[0];
        } else {
            $author = "Unknown";
        }

        include 'tag_result.php';
    } 

    echo "</div>";

?>



    

