<?php 
class Account {

    private $con;
    private $errorArray = array();

    public function __construct($con) {
        $this->con = $con;
    }

    public function login($un, $pw) {

        // hash the password in sha512
        $pw = hash("sha512", $pw);
        
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindParam(":un", $un);
        $query->bindParam(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 1) {
            return true;
        }
        else {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }

    }

    // Register the User
    public function register($fn, $ln, $un, $em, $ce, $pw, $cp) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em, $ce);
        $this->validatePasswords($pw, $cp);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }
        else {
            return false;
        }
    }

    // Update User Details
    public function updateDetails($fn, $ln, $em, $un) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em, $un);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em WHERE username=:un");
            $query->bindParam(":fn", $fn);
            $query->bindParam(":ln", $ln);
            $query->bindParam(":em", $em);
            $query->bindParam(":un", $un);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    // Update User Password
    public function updatePassword($oldPass, $newPass, $confNewPass, $un) {
        $this->validateOldPassword($oldPass, $un);
        $this->validatePasswords($newPass, $confNewPass);

        if(empty($this->errorArray)) {
            $pw = hash("sha512", $newPass);
            $query = $this->con->prepare("UPDATE users SET password=:pw WHERE username=:un");
            $query->bindParam(":pw", $pw);
            $query->bindParam(":un", $un);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    private function validateOldPassword($oldPass, $un) {
        // hash the password in sha512
        $pw = hash("sha512", $oldPass);
        
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindParam(":un", $un);
        $query->bindParam(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 0) {
            array_push($this->errorArray, Constants::$incorrectPassword);
        }
    }


    public function insertUserDetails($fn, $ln, $un, $em, $pw) {
        
        // hash the password in sha512
        $pw = hash("sha512", $pw);
        $profilePic = "assets/images/profilePictures/default.png";

        $query = $this->con->prepare("INSERT INTO users (firstName, lastName, username, email, password, profilePic)
                                        VALUES (:fn, :ln, :un, :em, :pw, :pic)");
                        
        $query->bindParam(":fn", $fn);
        $query->bindParam(":ln", $ln);
        $query->bindParam(":un", $un);
        $query->bindParam(":em", $em);
        $query->bindParam(":pw", $pw);
        $query->bindParam(":pic", $profilePic);

        return $query->execute();


    }

    // Validate First Name
    private function validateFirstName($fn) {
        if(strlen($fn) > 25 || strlen($fn) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    // Validate Last Name
    private function validateLastName($ln) {
        if(strlen($ln) > 25 || strlen($ln) < 2) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    // Validate Username
    private function validateUsername($un) {
        if(strlen($un) > 15 || strlen($un) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT username FROM users WHERE username=:un");
        $query->bindParam(":un", $un);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    // Validate Emails
    private function validateEmails($em, $ce) {
        if($em != $ce) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em");
        $query->bindParam(":em", $em);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    // Validate Passwords
    private function validatePasswords($pw, $cp) {
        if($pw != $cp) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if(preg_match("/[^A-Za-z0-9]/", $pw)) {
            array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
            return;
        }

        if(strlen($pw) > 30 || strlen($pw) < 8) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

    public function getError($error) {
        if(in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError() {
        if(!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
        else {
            return "";
        }
    }

    // Validate New Emails
    private function validateNewEmail($em, $un) {

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em AND username != :un");
        $query->bindParam(":em", $em);
        $query->bindParam(":un", $un);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

}
?>