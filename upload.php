<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoDetailsFormProvider.php");
?>

    <div class="column">
    <?php    
    $formProvider = new VideoDetailsFormProvider($con);
    echo $formProvider->createUploadForm();
    ?>
    </div>

    <script>
        $("form").submit(function() {
            $("#uploadingModal").modal("show");
        });
    </script>

    <div class="modal fade" id="uploadingModal" tabindex="-1" role="dialog" aria-labelledby="uploadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body" style="text-align:center;">
                Uploading video...
                <img src="assets/images/icons/loading-video-spinner.gif" alt="uploading video spinner" size="64">
            </div>
            
        </div>
    </div>
    </div>

<?php require_once("includes/footer.php"); ?>