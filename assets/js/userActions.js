function follow(userTo, userFrom, button) {

    if(userTo == userFrom) {
        alert("Sorry, you can't follow yourself!");
        return;
    }

    $.post("ajax/follow.php", {userTo: userTo, userFrom: userFrom})
    .done(function(count) {
        
        if(count != null) {
            $(button).toggleClass("follow unfollow");

            var buttonText = $(button).hasClass("follow") ? "FOLLOW" : "FOLLOWING";
            $(button).text(buttonText + " " + count);
        }
        else {
            alert("something went wrong");
        }

    });
}