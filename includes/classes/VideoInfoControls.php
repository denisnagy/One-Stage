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
        
        return "<div>
                    $likeButton
                    $dislikeButton
                </div>";
    }

    private function createLikebutton() {

        $text = $this->video->getLikes();
        $videoId = $this->video-getId();
        $action = "likeVideo(this, $videoId)";
        $class = "likeButton";

        $imageSrc = "assets/images/icons/thumbsUpFull.png";

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }

    private function createDislikebutton() {
        return "<button>Dislike</button>";
    }

    }
?>