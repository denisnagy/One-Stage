<?php 
require_once("includes/classes/VideoInfoControls.php");
class VideoInfo {

    private $con, $video, $userLoggedInObj;

    public function __construct($con, $video, $userLoggedInObj) {
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        return $this->createPrimaryInfo() . $this->createSecondaryInfo();
    }

    private function createPrimaryInfo() {
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        $videoInfocontrols = new VideoInfoControls($this->video, $this->userLoggedInObj);
        $controls = $videoInfocontrols->create();

        return "<div class='videoInfo'>
                    <h1>$title</h1>

                    <div class='detailsSection'>
                        <span class='viewCount'>$views views</span>
                        $controls
                    </div>
                </div>";
    }

    private function createSecondaryInfo() {
        
    }
}
?>