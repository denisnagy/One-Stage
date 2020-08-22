<?php 
class SettingsFormProvider {

    // Generating the User Details Form
    public function createUserDetailsForm($firstName, $lastName, $email) {
        $firstNameInput = $this->createFirstNameInput($firstName);
        $lastNameInput = $this->createLastNameInput($lastName);
        $emailInput = $this->createEmailInput($email);
        $saveDetailsButton = $this->createSaveUserDetailsButton();

        return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                    <span class='title'>Update User Details</span>
                    $firstNameInput
                    $lastNameInput
                    $emailInput
                    $saveDetailsButton
                </form>";
    }

    // Generating the Password changing form
    public function createUserPasswordForm() {
        $oldPasswordInput = $this->createPasswordInput("oldPassword", "Old Password");
        $newPasswordInput = $this->createPasswordInput("newPassword", "New Password");
        $confNewPasswordInput = $this->createPasswordInput("confNewPassword", "Confirm New Password");
        $savePasswordButton = $this->createSavePasswordButton();

        return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                    <span class='title'>Update Password</span>
                    $oldPasswordInput
                    $newPasswordInput
                    $confNewPasswordInput
                    $savePasswordButton
                </form>";
    }

    // User Details Form
    private function createFirstNameInput($value) {
        if($value == null) $value = "";
        return  "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='First Name' value='$value' name='firstName'>
                </div>";
    }

    private function createLastNameInput($value) {
        if($value == null) $value = "";
        return  "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Last Name' value='$value' name='lastName'>
                </div>";
    }

    private function createEmailInput($value) {
        if($value == null) $value = "";
        return  "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Email' value='$value' name='email'>
                </div>";
    }

    private function createSaveUserDetailsButton() {
        return "<button type='submit' class='btn btn-primary' name='saveDetailsButton'>Save Details</button>";
    }

    // PAssword FOrm
    private function createPasswordInput($name, $placeholder) {
        return  "<div class='form-group'>
                    <input class='form-control' type='password' placeholder='$placeholder' name='$name' required>
                </div>";
    }

    private function createSavePasswordButton() {
        return "<button type='submit' class='btn btn-primary' name='savePasswordButton'>Save Password</button>";
    }

}
    

?>