<?php 
class Constants {

    // ERROR MESSAGE CONSTANTS
    //-------------------------
    // First name error message
    public static $firstNameCharacters = "Your first name must be between 2 and 25 characters.";
    // Last name error message
    public static $lastNameCharacters = "Your last name must be between 2 and 25 characters.";
    // Username error message
    public static $usernameCharacters = "Your username must be between 5 and 15 characters.";
    // Username taken error message
    public static $usernameTaken = "The username is already taken.";
    // Email do not match error message
    public static $emailsDoNotMatch = "The emails provided do not match.";
    // Email invalid error message
    public static $emailInvalid = "The email provided is invalid.";
    // Email taken error message
    public static $emailTaken = "This email is already registered.";
    // Passwords do not match error message
    public static $passwordsDoNotMatch = "The passwords provided do not match.";
    // Passwords do not match error message
    public static $passwordsNotAlphanumeric = "Your password can only contain letters and numbers.";
    // Passwords do not match error message
    public static $passwordLength = "The password must be between 8 and 30 characters.";

    // Login Failed error message
    public static $loginFailed = "The username or password is incorrect.";
    
}
?>