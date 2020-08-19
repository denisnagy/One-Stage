<?php 
require_once("includes/header.php");

$followingProvider = new FollowersProvider($con, $userLoggedInObj);
$videos = $followingProvider->getVideos();

$videoGrid = new VideoGrid($con, $userLoggedInObj);

?>

<div class="largeVideoGridContainer">
    <?php
    if(sizeof($videos) > 0) {
        echo $videoGrid->create($videos, "New from your favorite artists", false);
    }
    else {
        echo "No videos to show";
    }
    ?>
</div>