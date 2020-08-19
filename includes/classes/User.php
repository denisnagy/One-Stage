<?php 
class User {

    private $con, $sqlData;

    public function __construct($con, $username) {
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM users WHERE username = :un");
        $query->bindParam(":un", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

    }

    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

    public function getUsername() {
        return $this->sqlData["username"] ?? "";
    }

    public function getName() {
        return $this->sqlData["firstName"] . " " . $this->sqlData["lastName"];
    }

    public function getFirstName() {
        return $this->sqlData["firstName"];
    }

    public function getEmail() {
        return $this->sqlData["email"];
    }

    public function getProfilePic() {
        return $this->sqlData["profilePic"] ?? "assets/images/profilePictures/default.png";
    }

    public function getSignUpDate() {
        return $this->sqlData["signUpDate"];
    }

    // Check see if the user is following a user
    public function isFollowing($userTo) {
        $query = $this->con->prepare("SELECT * FROM followers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $username);
        $username = $this->getUsername();

        $query->execute();
        return $query->rowCount() > 0;
    }

    // Get the numbers of followers from the database
    public function getFollowersCount() {
        $query = $this->con->prepare("SELECT * FROM followers WHERE userTo=:userTo");
        $query->bindParam(":userTo", $username);
        $username = $this->getUsername();

        $query->execute();
        return $query->rowCount();
    }

    // Get following users for userLoggedIn
    public function getFollowing() {
        $query = $this->con->prepare("SELECT userTo FROM followers WHERE userFrom=:userFrom");
        $username = $this->getUsername();
        $query->bindParam(":userFrom", $username);
        $query->execute();

        $followers = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($this->con, $row["userTo"]);
            array_push($followers, $user);
        }
        return $followers;
    }
}
?>