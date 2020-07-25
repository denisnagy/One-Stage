<?php 
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

$account = new Account($con);


if(isset($_POST["signUpButton"])) {

    // Sanitize data from form
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);

    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);

    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $confEmail = FormSanitizer::sanitizeFormEmail($_POST["confEmail"]);

    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $confPassword = FormSanitizer::sanitizeFormPassword($_POST["confPassword"]);

    $wasSuccessful = $account->register($firstName, $lastName, $username, $email, $confEmail, $password, $confPassword);

    if($wasSuccessful) {
        $_SESSION["userLoggedIn"] = $username;
        header("Location: index.php");
        
    }
    


}

function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - One Stage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>
    <div class="signInContainer">
        <div class="column">

            <div class=header>
                <img src="assets/images/icons/logo_black.png" alt="One Stage Black Logo" title="One Stage">
                <h3>Sign Up</h3>
                <span>to fully enjoy the One Stage!</span>
            </div>

            <div class="loginForm">
                <form action="signUp.php" method="POST">

                    <?php echo $account->getError(Constants::$firstNameCharacters);?>
                    <input type="text" name="firstName" placeholder="First name" value="<?php getInputValue('firstName'); ?>" autocomplete="off" required>
                    <?php echo $account->getError(Constants::$lastNameCharacters);?>
                    <input type="text" name="lastName" placeholder="Last name" value="<?php getInputValue('lastName'); ?>" autocomplete="off" required>
                    <?php echo $account->getError(Constants::$usernameCharacters);?>
                    <?php echo $account->getError(Constants::$usernameTaken);?>
                    <input type="text" name="username" placeholder="Username" value="<?php getInputValue('username'); ?>" autocomplete="off" required>

                    <input type="email" name="email" placeholder="Email" value="<?php getInputValue('email'); ?>" autocomplete="off" required>
                    <?php echo $account->getError(Constants::$emailsDoNotMatch);?>
                    <?php echo $account->getError(Constants::$emailInvalid);?>
                    <?php echo $account->getError(Constants::$emailTaken);?>
                    <input type="email" name="confEmail" placeholder="Confirm email" value="<?php getInputValue('confEmail'); ?>" autocomplete="off" required>

                    <?php echo $account->getError(Constants::$passwordsDoNotMatch);?>
                    <?php echo $account->getError(Constants::$passwordsNotAlphanumeric);?>
                    <?php echo $account->getError(Constants::$passwordLength);?>
                    <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                    <input type="password" name="confPassword" placeholder="Confirm password" autocomplete="off" required>

                    <input type="submit" name="signUpButton" value="Sign Up">
                </form>
            </div>

            <a class="signInMessage" href="signIn.php">
                Already have an account? sign in here!
            </a>

        </div>
    </div>

</body>
</html>