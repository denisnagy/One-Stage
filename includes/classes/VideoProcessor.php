<?php 
class VideoProcessor {
    private $con;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");

    public function __construct($con) {
        $this->con = $con;
    }

    public function upload($videoUploadData) {

        $targetDir = "uploads/videos/";
        $videoData = $videoUploadData->videoDataArray;

        $tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);
        // uploads/videos/5f1a2d0e6369cyellow_ice_cream.flv

        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $isValidData = $this->processData($videoData, $tempFilePath);

        if(!$isValidData) {
            return false;
        }

        if(move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {
            echo "file moved succesfuly";
        }
    }

    private function processData($videoData, $filePath) {
        $videoType = pathInfo($filePath, PATHINFO_EXTENSION);

        if(!$this->isValidSize($videoData)) { // Check the file size
            echo "File too large, Maximum file size 500MB";
            return false;
        }
        else if(!$this->isValidType($videoType)) { // Check the file type
            echo "Invalid file type";
            return false;
        }
        else if($this->hasError($videoData)) { // Check for any error
            echo "Error code :" . $videoData["error"];
            return false;
        }
    
        return true;
    }

    private function isValidSize($data) {
        return $data["size"] <= $this->sizeLimit;
    }

    private function isValidType($type) {
        // replace file type to lower case
        $lowerCase = strtolower($type);
        return in_array($lowerCase, $this->allowedTypes);
    }

    private function hasError($data) {
        return $data["error"] != 0;
    }
}

?>