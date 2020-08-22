<?php 
require_once("includes/header.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/SettingFormProvider.php");

// Check user is logged in
if(!User::isLoggedIn()) {
    header("Location: signIn.php");
}

$detailsMessage = "";
$passwordMessage = "";
$formProvider = new SettingsFormProvider();

// Process User Details
if(isset($_POST["saveDetailsButton"])) {
    $account = new Account($con);

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormString($_POST["email"]);

    if($account->updateDetails($firstName, $lastName, $email, $userLoggedInObj->getUsername())) {
        $detailsMessage =   "<div class='alert alert-success'>
                                Details updated successfully!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        if ($errorMessage == "") {
            $errorMessage = "Something went wrong!";
        }

        $detailsMessage =   "<div class='alert alert-danger'>
                                OOOPS... $errorMessage
                            </div>";
    }
}

// Process Update Password
if(isset($_POST["savePasswordButton"])) {
    $account = new Account($con);

    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $confNewPassword = FormSanitizer::sanitizeFormPassword($_POST["confNewPassword"]);

    if($account->updatePassword($oldPassword, $newPassword, $confNewPassword, $userLoggedInObj->getUsername())) {
        $passwordMessage =   "<div class='alert alert-success'>
                                Password updated successfully!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        if ($errorMessage == "") {
            $errorMessage = "Something went wrong!";
        }

        $passwordMessage =   "<div class='alert alert-danger'>
                                OOOPS... $errorMessage
                            </div>";
    }
}

?>

<div class="settingContainer">

    <div class="formSection">
        <div class="message">
            <?php echo $detailsMessage; ?>
        </div>
        <?php 
            echo $formProvider->createUserDetailsForm(
                isset($_POST["firstName"]) ? $_POST["firstName"] : $userLoggedInObj->getFirstName(),
                isset($_POST["lastName"]) ? $_POST["lastName"] : $userLoggedInObj->getLastName(),
                isset($_POST["email"]) ? $_POST["email"] : $userLoggedInObj->getEmail()
            );
        ?>
    </div>

    <div class="formSection">
        <div class="message">
            <?php echo $passwordMessage; ?>
        </div>
        <?php 
            echo $formProvider->createUserPasswordForm();
        ?>
    </div>

</div>