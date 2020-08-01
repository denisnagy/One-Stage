<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoInfo.php");

if(!isset($_GET["id"])) {
    echo "no url passed";
    exit();
}

$video = new Video($con, $_GET["id"], $userLoggedInObj);
$video->incrementViews();


?>

<div class="watchLeftColumn">

<?php 
    $videoPlayer = new VideoPlayer($video);
    echo $videoPlayer->create(true);

    $videoInfo = new VideoInfo($con, $video, $userLoggedInObj);
    echo $videoInfo->create();
?>

</div>

<div class="sugestionsColumn">
    <div class="">
    
    </div>
</div>



<?php require_once("includes/footer.php"); ?>