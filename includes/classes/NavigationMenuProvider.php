<?php 
class NavigationMenuProvider {
    
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        // Generate links in the side navigation panel
        $menuHtml = $this->createNavItem("Home", "assets/images/icons/home.png", "index.php");
        $menuHtml .= $this->createNavItem("Trending", "assets/images/icons/trending.png", "trending.php");
        $menuHtml .= $this->createNavItem("Latest News", "assets/images/icons/news.png", "news.php");
        $menuHtml .= $this->createNavItem("Events", "assets/images/icons/events.png", "events.php");
        $menuHtml .= $this->createNavItem("Live Performances", "assets/images/icons/home.png", "live.php");
        $menuHtml .= $this->createNavItem("Stand-Up Comedy", "assets/images/icons/comedy.png", "standup.php");
        $menuHtml .= $this->createNavItem("Theatre Plays", "assets/images/icons/theatre.png", "theatre.php");
        
        

        // only show if user is logged in
        if(User::isLoggedIn()) {
            $menuHtml .= $this->createNavItem("Upload Video", "assets/images/icons/upload.png", "upload.php");
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