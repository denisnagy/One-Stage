<?php 
class ProfileData {

    private $con, $profileUserObj;

    public function __construct($con, $profileUsername) {
        $this->con = $con;
        $this->profileUserObj = new User($con, $profileUsername);
    }


    // Return the User object variable
    public function getProfileUserObj() {
        return $this->profileUserObj;
    }

    public function getProfileUsername() {
         return $this->profileUserObj->getUsername();
    }

    // Check if user exists
    public function userExists() {
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam(":username", $profileUsername);
        $profileUsername = $this->getProfileUsername();
        $query->execute();

        return $query->rowCount() != 0;
    }

    // Get the path for the cover photo
    public function getCoverPhoto() {
        return "assets/images/coverPhotos/cover.jpg";
    }

    // Get the full name of the user
    public function getProfileUserFullName() {
        return $this->profileUserObj->getName();
    }

    // Get the profile pic of user
    public function getProfilePic() {
        return $this->profileUserObj->getProfilePic();
    }

    // Get the profile pic of user
    public function getFollowersCount() {
        return $this->profileUserObj->getFollowersCount();
    }

    public function getUsersVideos() {
        $query = $this->con->prepare("SELECT * FROM videos WHERE uploadedBy=:uploadedBy ORDER BY uploadDate DESC");
        $query->bindParam(":uploadedBy", $username);
        $username = $this->getProfileUsername();
        $query->execute();

        $videos = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $videos[] = new Video($this->con, $row, $this->profileUserObj->getUsername());
        }
        return $videos;
    }

    public function getAllUserDetails() {
        return array(
            "Name" => $this->getProfileUserFullName(),
            "Username" => $this->getProfileUsername(),
            "Followers" => $this->getFollowersCount(),
            "Total views" => $this->getTotalViews(),
            "Sign up date" => $this->getSignUpDate()
        );
    }

    private function getTotalViews() {
        $query = $this->con->prepare("SELECT sum(views) FROM videos WHERE uploadedBy=:uploadedBy");
        $query->bindParam(":uploadedBy", $username);
        $username = $this->getProfileUsername();
        $query->execute();

        return $query->fetchColumn();
    }

    private function getSignUpDate() {
        $date = $this->profileUserObj->getSignUpDate();
        return date("F jS, Y", strtotime($date));

    }
    
}
?>