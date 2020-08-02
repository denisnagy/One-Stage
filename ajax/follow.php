<?php 
require_once("../includes/config.php");

if(isset($_POST['userTo']) && isset($_POST['userFrom'])) {
    
    $userTo = $_POST['userTo'];
    $userFrom = $_POST['userFrom'];

    // Check if the user is following
    $query = $con->prepare("SELECT * FROM followers WHERE userTo=:userTo AND userFrom=:userFrom");
    $query->bindParam("userTo", $userTo);
    $query->bindParam("userFrom", $userFrom);
    $query->execute();

    if($query->rowCount() == 0) {
        // Insert
        $query = $con->prepare("INSERT INTO followers(userTo, userFrom) VALUES(:userTo, :userFrom)");
        $query->bindParam("userTo", $userTo);
        $query->bindParam("userFrom", $userFrom);
        $query->execute();
    }
    else {
        // Delete
        $query = $con->prepare("DELETE FROM followers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam("userTo", $userTo);
        $query->bindParam("userFrom", $userFrom);
        $query->execute();
    }


    // Return new number of followers
    $query = $con->prepare("SELECT * FROM followers WHERE userTo=:userTo");
    $query->bindParam("userTo", $userTo);
    $query->execute();

    echo $query->rowCount();
}
else {
    echo "one or more param not passed";
}
?>