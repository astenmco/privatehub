<?php
    
    $v2 = $currentTag->getV2ManifestAsArray();
    $v1 = $currentTag->getV1Manifest();
    if (isset($v2['manifests']) && !is_null($v2['manifests'])) {
        $manifests = $v2['manifests'];
        foreach($manifests as $key=>$manifest) {
            $current_digest = substr($manifest['digest'],7);
            $current_arch = $manifest['platform']['architecture'];
            $current_os = $manifest['platform']['os'];
            $current_size = $manifest['size'];
            include 'digest_result.php';
        }
    } else {
        $current_digest = substr($currentTag->getDockerContentDigestFromHTTPHeader(),7);
        $current_arch = $v1['architecture'];
        $current_os = $currentTag->getLastEditData()['os'];
        $current_size = $currentTag->getHTTPHeadersAsArray()['Content-Length'];
        include 'digest_result.php';
    }
    
?>


