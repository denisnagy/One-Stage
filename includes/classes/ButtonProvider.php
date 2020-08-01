<?php 
class ButtonProvider {

    public static function createButton($text, $imageSrc, $action, $class) {

        // Defiene image source for buttons class, If the button has an image fine source else set empty string
        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        // Change action if needed

        return "<button class='$class' onclick='$action'>
                    $image
                    <span class='text'>$text</span>
                </button>";
    }
}

?>