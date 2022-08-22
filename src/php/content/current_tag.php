<?php

    try {
        $registry = new Registry(REGISTRY_URL);
    } catch(Exception $ex) {
        echo "<meta http-equiv='refresh' content='0; url=./../html/config_error.html'>";
    }
    $repo = $registry->getRepository($_GET['repo']);
    $currentTag = $repo->getTag($_GET['tag']);
    $test = $currentTag->getV2ManifestAsArray();
    if (isset($test['manifests'])) {
        $manifests = $test['manifests'];
        foreach($manifests as $key => $manifest ) {
            if ($_GET['arch'] === $manifest['platform']['architecture']) {
                $current_digest = $manifest['digest'];
            }
        }
    } else {
        $current_digest = $currentTag->getTagDigest();
    }

    $authors_exploded = explode("<", $currentTag->getLabels()->getAuthors());
    if (isset($authors_exploded[1])) {
        $author = $authors_exploded[0];
    } else {
        $author = "Unknown";
    }
    
?>

<div class='container'>
    <div class='row'>
        <div class='col'>
            <div class='card'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-1'>
                            <img src='../../../src/img/folder.png' alt='Repository Icon' width='55' height='42'>
                        </div>
                        <div class='col'>
                            <h5 class='card-title' id='card_repo_name'><strong><?php echo $_GET['repo']; ?></strong>:<?php echo $_GET['tag']; ?></h5>
                            <h6 class='card-subtitle text-muted' id='card_date'>Last pushed <strong><span class='last_pushed'><?php echo $currentTag->getDateTimeDiffAsDays(); ?></span> ago</strong></a></h6>
                        </div>
                    </div>   
                    <div class='row mt-2'>
                        <div class='card-text col-1'></div>
                        <p class='card-text text-muted text-xs col' id='card_description'>DIGEST : <?php echo $current_digest; ?></p>
                    </div>          
                </div>
            </div>
        </div>
    </div>
    <div class="tag_infos d-flex">
        <div class="os_arch my-2 me-5">
            <p class="tag_subtitle">OS / Arch</p>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Platforms
                </button>
                <ul class="dropdown-menu">
                    <?php include 'tag_platforms.php'; ?>
                </ul>
            </div>
        </div>
        <div class="vr mt-3 me-3"></div>
        <div class="tag_last_pushed my-2 me-5">
            <p class="tag_subtitle">Last pushed</p>
            <p><?php echo $currentTag->getDateTimeDiffAsDays(); ?> ago by <a href='' class='pushed_by'><?php echo $author ?></p>
        </div>
    </div>
</div>