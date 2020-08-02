<?php 
class ButtonProvider {

    public static $signInFunction = "notSignedIn()";

    public static function createLink($link) {
        return User::isLoggedIn() ? $link : ButtonProvider::$signInFunction;
    }


    public static function createButton($text, $imageSrc, $action, $class) {

        // Defiene image source for buttons class, If the button has an image fine source else set empty string
        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        $action = ButtonProvider::createLink($action);

        return "<button class='$class' onclick='$action'>
                    $image
                    <span class='text'>$text</span>
                </button>";
    }

    // Create the follow button
    public static function createHyperlinkButton($text, $imageSrc, $href, $class) {

        // Defiene image source for buttons class, If the button has an image fine source else set empty string
        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        return "<a href='$href'>
                <button class='$class'>
                    $image
                    <span class='text'>$text</span>
                </button>
                </a>";
    }

    public static function createUserProfileButton($con, $username) {
        $userObj = new User($con, $username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return "<a href='$link'>
                    <img src='$profilePic' class='profilePicture'>
                </a>";
    }

    public static function createEditVideoButton($videoId) {
        $href = "editVideo.php?videoId=$videoId";

        $button = ButtonProvider::createHyperlinkButton("EDIT VIDEO", null, $href, "edit button");

        return "<div class='editVideoButtonContainer'>
                    $button
                </div>";
    }

    public static function createFollowerButton($con, $userToObj, $userLoggedInObj) {

        $userTo = $userToObj->getUsername();
        $userLoggedIn = $userLoggedInObj->getUsername();

        $isFollowing = $userLoggedInObj->isFollowing($userTo);
        $buttonText = $isFollowing ? "FOLLOWING" : "FOLLOW";
        $buttonText .= " " . $userToObj->getFollowersCount();
        
        $buttonClass = $isFollowing ? "unfollow button" : "follow button";
        $action = "follow(\"$userTo\", \"$userLoggedIn\", this)";

        $button = ButtonProvider::createButton($buttonText, null, $action, $buttonClass);

        return "<div class='followButtonContainer'>
                    $button
                </div>";
    }
}

?>