<?php 
class NavigationMenuProvider {
    
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        $menuHtml = $this->createNavItem("Home", "assets/images/icons/home.png", "index.php");
        $menuHtml .= $this->createNavItem("Trending", "assets/images/icons/trending.png", "trending.php");
        $menuHtml .= $this->createNavItem("Live", "assets/images/icons/home.png", "index.php");

        // only show if user is logged in
        if(User::isLoggedIn()) {
            
            $menuHtml .= $this->createNavItem("Following", "assets/images/icons/following.png", "following.php");
            $menuHtml .= $this->createNavItem("Settings", "assets/images/icons/settings.png", "settings.php");
            $menuHtml .= $this->createNavItem("Log Out", "assets/images/icons/logout.png", "logout.php");
            $menuHtml .= $this->createFollowingSection();
        }



        // Create Following section

        return "<div class='navigationItems'>
                    $menuHtml
                </div>";
    }

    private function createNavItem($text, $icon, $link) {
        return "<div class='navigationItem'>
                    <a href='$link'>
                        <img src='$icon'>
                        <span>$text</span>
                    </a>
                </div>";
    }

    private function createFollowingSection() {
        $following = $this->userLoggedInObj->getFollowing();

        $html = "<span class='heading'>Following</span>";
        foreach($following as $follower) {

            $followUsername = $follower->getUsername();
            $followProfilePic = $follower->getProfilePic();

            $html .= $this->createNavItem($followUsername, $followProfilePic, "profile.php?username=$followUsername");
        }

        return $html;
    }
}
?>