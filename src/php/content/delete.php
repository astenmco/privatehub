<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../src/css/style.css">
</head>
<body>
<?php

/**
 * Here we use the command pattern to call for our objects methods 
 */
include_once '../config.php';
include_once '../classes/Registry.php';
include_once '../classes/Repository.php';
include_once '../classes/Tag.php';
include_once '../classes/Utils.php';

try {
    $registry = new Registry(REGISTRY_URL);
} catch(Exception $ex) {
    echo "<meta http-equiv='refresh' content='0; url=./../html/config_error.html'>";
}

if(isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];

    if (isset($_GET['repo']) && !empty($_GET['repo'])) {
        $repo = $_GET['repo'];
    }

    switch($action) {

        case 'deleteTag' : 

            if (isset($_GET['tag']) && !empty($_GET['tag'])) {
                $tag = $_GET['tag'];
            }

            $delete = $registry->getRepository($repo)->getTag($tag)->deleteTag();

            echo "<meta http-equiv='refresh' content='0; url=../../../public/pages/php/tags.php?repo=".$_GET['repo']."'>";
            
            break;

        case 'deleteRepositoryTags': 

            $current_repository = $registry->getRepository($repo);
            $tags = $current_repository->getTags();
            
            foreach($tags as $index=>$tag) {
                $current_repository->getTag($tag)->deleteTag();
            }

           /*  # Execution du script de suppression en fonction de l'OS
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                echo 'This is a server using Windows!';
                #Chemin absolu depuis mon système
                $output = shell_exec("wsl /mnt/c/xampp/htdocs/PrivateHub/src/scripts/remove_empty.sh");
                echo $output;
            } else {
                # chemmin absolu pour install linux (generaliser)
                echo 'This is a server not using Windows!';
                shell_exec(dirname(__FILE__) . '/../../scripts/remove_empty.sh');
            } */

            echo "<meta http-equiv='refresh' content='0; url=../../../public/pages/php/repositories.php'>";
            
            break;

        case 'deleteImagesOlderThan':

            if (isset($_POST['days']) && !empty($_POST['days'])) {
                $now = new DateTime('NOW');
                $then = clone $now;
                $then->modify('-'.$_POST['days'].' day');
                
                $repositories = $registry->getRepositories();
                foreach($repositories as $index => $repository_name) {
                    $repository = $registry->getRepository($repository_name);
                    $repository_tags = $repository->getTags();
                    foreach($repository_tags as $tag_index => $tag_name) {
                        $current_tag = $repository->getTag($tag_name);
                        $tag_dateTime = $current_tag->getDateTime();
                        if ($tag_dateTime->format('U') < $then->format('U') ) {
                            $current_tag->deleteTag();
                        }
                    }
                }
            } else {
                echo "<h1 style='text-align:center;margin-top:45vh'>Please fill in the number of days</h1>";
            }

            echo "<meta http-equiv='refresh' content='0; url=../../../public/pages/php/repositories.php'>";

            break;

        case 'deleteAll' : 
            
            $repositories = $registry->getRepositories();
            foreach($repositories as $index => $repository_name) {
                $repository = $registry->getRepository($repository_name);
                $repository_tags = $repository->getTags();
                foreach($repository_tags as $tag_index => $tag_name) {
                    $current_tag = $repository->getTag($tag_name);
                    $current_tag->deleteTag();
                }
            }

            echo "<meta http-equiv='refresh' content='0; url=../../../public/pages/php/repositories.php'>";

            break;

        default:

            echo "Echec";

            break;
    }
}



?>
</body>
</html>

