<?php 
class FollowersProvider {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    // Recommend videos from people the user follows
    public function getVideos() {
        $videos = array();
        $following = $this->userLoggedInObj->getFollowing();

        if(sizeof($following) > 0) {

            $condition = "";
            $i = 0;

            while($i < sizeof($following)) {

                if($i == 0) {
                    $condition .= "WHERE uploadedBy=?";
                }
                else {
                    $condition .= " OR uploadedBy=?";
                }
                $i++;

            }

            $videoSql = "SELECT * FROM videos $condition ORDER BY uploadDate DESC";
            $videoQuery = $this->con->prepare($videoSql);

            $i = 1;

            foreach($following as $follow) {
                $videoQuery->bindParam($i, $subUsername);
                $subUsername = $follow->getUsername();
                $i++;
            }

            $videoQuery->execute();
            while($row = $videoQuery->fetch(PDO::FETCH_ASSOC)) {
                $video = new Video($this->con, $row, $this->userLoggedInObj);
                array_push($videos, $video);
            }

        }

        return $videos;

    }
}
?>