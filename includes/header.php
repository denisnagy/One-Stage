<?php require_once("includes/config.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome To One Stage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="assets/js/commonActions.js"></script>
</head>
<body>
    
    <div id="pageContainer">

        <div id="mastHeadContainer">
            <button class="navShowHide">
                <img src="assets/images/icons/menu.png" alt="Menu Button Icon" title="Menu">
            </button>

            <a class="logoContainer" href="index.php">
                <img src="assets/images/icons/logo_black.png" alt="One Stage Black Logo" title="One Stage">
            </a>

            <div class="searchBarContainer">
                <form action="search.php" method="GET">
                    <input type="text" class="searchBar" name="term" placeholder="search...">
                    <button class="searchButton">
                        <img src="assets/images/icons/search1.png" alt="Search Bar Icon One stage">
                    </button>
                </form>
            </div>

            <div class="rightMenu">
                <a href="upload.php">
                    <img class="upload" src="assets/images/icons/upload.png" alt="">
                </a>

                <a href="#">
                    <img class="" src="assets/images/profilePictures/defaultProfile.png" alt="">
                </a>
            </div>

        </div>

        <div id="sideNavContainer" style="display:none;">
        
        </div>

        <div id="mainSectionContainer">
            <div id="mainContentContainer">