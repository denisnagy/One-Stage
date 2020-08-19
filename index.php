<?php require_once("includes/header.php"); ?>

<div class="videoSection">
    <?php 

    $followersProvider = new FollowersProvider($con, $userLoggedInObj);
    $followersVideos = $followersProvider->getVideos();

    $videoGrid = new VideoGrid($con, $userLoggedInObj->getUsername());

    if(User::isLoggedIn() && sizeof($followersVideos) > 0) {
        echo $videoGrid->create($followersVideos, "Following", false);
    }

    echo $videoGrid->create(null, "Recommended", false);

    ?>
</div>

<?php require_once("includes/footer.php"); ?>