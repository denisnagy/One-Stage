function postComment(button, $postedBy, videoId, replyTo, containerClass) {
    var textarea = $(button).siblings("textarea");
    var commentText = textarea.val();
    textarea.val("");

    if(commentText) {

        $.post("ajax/postComment.php")
        .done(function() {
            alert("done");
        });

    }
    else {
        alert("Please type something in the comment box in order to post a comment!")
    }
}