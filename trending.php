<?php 
require_once("includes/header.php");
require_once("includes/classes/TrendingProvider.php");

$trendigProvider = new TrendingProvider($con, $userLoggedInObj);
$videos = $trendigProvider->getVideos();

$videoGrid = new VideoGrid($con, $userLoggedInObj);

?>

<div class="largeVideoGridContainer">
    <?php
    if(sizeof($videos) > 0) {
        echo $videoGrid->create($videos, "Trending videos uploaded in the last week", false);
    }
    else {
        echo "No trending videos to show";
    }
    ?>
</div>