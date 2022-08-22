<?php

    $v2 = $currentTag->getV2ManifestAsArray();
    $v1 = $currentTag->getV1Manifest();
    
    if (isset($v2['manifests']) && !is_null($v2['manifests'])) {

        $manifests = $v2['manifests'];

        foreach($manifests as $key=>$manifest) {

            include 'tag_platform.php';

        }
    } 


?>