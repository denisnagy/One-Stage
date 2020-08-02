<?php 
    require_once("includes/classes/ButtonProvider.php");
    class VideoInfoControls {

        private $video, $userLoggedInObj;

    public function __construct($video, $userLoggedInObj) {
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {

        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();
        
        return "<div class='controls'>
                    $likeButton
                    $dislikeButton
                </div>";
    }

    private function createLikeButton() {

        $text = $this->video->getLikes();
        $videoId = $this->video->getId();
        $action = "likeVideo(this, $videoId)";
        $class = "likeButton";

        $imageSrc = "assets/images/icons/thumbsUp.png";

        if($this->video->wasLikedBy()) {
            $imageSrc = "assets/images/icons/thumbsUpFull.png";
        }

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }

    private function createDislikebutton() {

        $text = $this->video->getDislikes();
        $videoId = $this->video->getId();
        $action = "dislikeVideo(this, $videoId)";
        $class = "dislikeButton";

        $imageSrc = "assets/images/icons/thumbsDown.png";

        if($this->video->wasDislikedBy()) {
            $imageSrc = "assets/images/icons/thumbsDownFull.png";
        }

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }

    }
?>