<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../../src/php/classes/Registry.php';
include_once '../../../src/php/classes/Repository.php';
include_once '../../../src/php/classes/Tag.php';
include_once '../../../src/php/classes/Layer.php';
include_once '../../../src/php/classes/Utils.php';
include_once '../../../src/php/classes/Labels.php';
include_once '../../../src/php/config.php';

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PrivateHub - Commands</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../../src/css/style.css">
  </head>
  <body>
    
    <!-- NAVBAR -->
    <?php include '../../../src/html/navbar.html'; ?>

    <div class="container-lg">

        <!-- BREADCRUMBS -->
        <?php include '../../../src/php/content/breadcrumbs.php'; ?>

        <!-- TAG INFOS -->
        <?php include '../../../src/php/content/current_tag.php'; ?>

        <hr>

        <!-- IMAGE LAYERS  -->
        <?php include '../../../src/php/content/image_layers.php'; ?>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        var clipboard = new ClipboardJS('.btn-clipboard');

        clipboard.on('success', function (e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
      });

      clipboard.on('error', function (e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
      });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
  </body>
</html>