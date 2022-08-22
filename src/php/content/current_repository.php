<?php

    try {
        $registry = new Registry(REGISTRY_URL);
    } catch(Exception $ex) {
        echo "<meta http-equiv='refresh' content='0; url=./../html/config_error.html'>";
    }
    $repo = $registry->getRepository($_GET['repo']);
    $tags = $repo->getTags();
    $mostRecentTag = "";

    if (isset($tags[0]) && !empty($tags[0])) {
        $mostRecentTag = $repo->getTag($tags[0]);
    }

    $repository_architectures = array();

    if (isset($mostRecentTag) && !empty($mostRecentTag)) {

        foreach($tags as $index=>$tag){

            $currentTag = $repo->getTag($tag);

            if ($mostRecentTag->getDateTime() <= $currentTag->getDateTime()){
                $mostRecentTag = $currentTag;
            }

            $architectures = $currentTag->getArchitecture();

            foreach($architectures as $key=>$architecture){

                if (!in_array($architecture, $repository_architectures)){
                    array_push($repository_architectures, $architecture);
                }

            }
            
        }

        $last_pushed = $mostRecentTag->getDateTimeDiffAsDays();
        $description = $mostRecentTag->getLabels()->getDescription();

        $architectures = "";
        foreach($repository_architectures as $index => $arch){
            $architectures .= "<li class='repository_arch_item me-2'>
                                    <a href='#' class='arch_item'>".strtoupper($arch)."</a>
                                </li>";
        }

        $author = "Unknown";
        $authors_exploded = explode("<", $currentTag->getLabels()->getAuthors());
        if (isset($authors_exploded[1])) {
            $author = $authors_exploded[0];
        }
    } else {
        $last_pushed = "0 days";
        $description = "This repository does not hold any tags. This is due to a known bug from the Registry API V2. We display the empty repositories and wait for this issued to be fixed instead of affecting the data storage ourselves.";
        $architectures = "";
        $author = "Unknown";
    }

    include 'current_repository_item.php';
    
?>

