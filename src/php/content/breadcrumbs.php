<?php
    $bool = false;
    $bool2 = false;
    if (isset($_GET['repo']) && !empty($_GET['repo'])) {
        $bool = true;
        if (isset($_GET['tag']) && !empty($_GET['tag'])) {
            $bool2=true;
        }
    }

?>

<nav aria-label="breadcrumb" class="mb-2 mt-3 container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../../">Private Hub</a></li>
      
      <?php
      
        

        if ( $bool && $bool2) {
            echo "<li class='breadcrumb-item' aria-current=''><a href='../../pages/php/repositories.php'>Repositories</a></li>
                    <li class='breadcrumb-item' aria-current=''><a href='../../pages/php/tags.php?repo=".$_GET['repo']."'>".$_GET['repo']."</a></li>
                <li class='breadcrumb-item active' aria-current='page'>".$_GET['tag']."</li>";
        } else {
            if ($bool) {
                echo "<li class='breadcrumb-item' aria-current=''><a href='../../pages/php/repositories.php'>Repositories</a></li>
                <li class='breadcrumb-item active' aria-current='page'>".$_GET['repo']."</li>";   
            } else {
                echo "<li class='breadcrumb-item' aria-current=''>Repositories</li>";
            }
        }
      ?>
    </ol>
</nav>
<hr class="">