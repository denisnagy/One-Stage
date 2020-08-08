<?php 
    require_once("ButtonProvider.php");
    class VideoInfoControls {

        private $con, $comment, $userLoggedInObj;

    public function __construct($con, $comment, $userLoggedInObj) {
        $this->con = $con;
        $this->comment = $comment;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {

        $replyButton = $this->createReplyButton();
        $likesCount = $this->createLikesCount();
        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();
        $replySection = $this->createReplySection();
        
        return "<div class='controls'>
                    $replyButton
                    $likesCount
                    $likeButton
                    $dislikeButton
                </div>";
    }

    // Create reply button for comments
    private function createReplyButton() {
        $text = "REPLY";
        $action = "toggleReply(this)";

        return ButtonProvider::createButton($text, null, $action, null);
    }

    // Create the likes counting function for comments
    private function createLikesCount() {
        $text = $this->comment->getLikes();

        if($text == 0) $text = "";

        return "<span class='likesCount'>$text</span>";
    }

    // Create the reply to comments section 
    private function createReplySection() {
        return "";
    }

    // Create the like button functionality
    private function createLikeButton() {

        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "likeComment($commentId, this, $videoId)";
        $class = "likeButton";

        $imageSrc = "assets/images/icons/thumbsUp.png";

        if($this->comment->commentWasLike()) {
            $imageSrc = "assets/images/icons/thumbsUpFull.png";
        }

        return ButtonProvider::createButton("", $imageSrc, $action, $class);
    }

    private function createDislikebutton() {

        $commentId = $this->comment->getId();
        $videoId = $this->comment->getVideoId();
        $action = "dislikeComment($commentId, this, $videoId)";
        $class = "dislikeButton";

        $imageSrc = "assets/images/icons/thumbsDown.png";

        if($this->comment->wasDislikedBy()) {
            $imageSrc = "assets/images/icons/thumbsDownFull.png";
        }

        return ButtonProvider::createButton("", $imageSrc, $action, $class);
    }

    }
?>