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
        return $this->sqlData["profilePic"];
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
}
?>