<?php

    $repo = $registry->getRepository($repository_name);
    $tags = $repo->getTags();
    $mostRecentTag = "";
    if (isset($tags[0]) && !empty($tags[0])) {
        $mostRecentTag = $repo->getTag($tags[0]);
    }
    $repository_architectures = array();

    /* If the repository has no tags then it will not be displayed.
    A script handles the real deletion from the registry's actual volume */

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
    
        $architectures = "";
        foreach($repository_architectures as $index => $arch){
            $architectures .= "<li class='repository_arch_item me-2'>
                                    <a href='#' class='arch_item'>".strtoupper($arch)."</a>
                                </li>";
        }
    
        $commit_link = $mostRecentTag->getLabels()->getURL()."/commit/".$mostRecentTag->getLabels()->getCommitDigest();
    
        
        /* Options to get the first displayed repository card open and the others closed */

        if ($i == 0) {
    
            $accordion_button = "";
            $accordion_collapse = " show";
            $expanded = "true";
    
        } else {
    
            $accordion_button = " collapsed";
            $accordion_collapse = "";
            $expanded = "false";
        }
    
        include 'repository_item_card.php';
    }

    

?>