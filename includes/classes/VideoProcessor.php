<?php 
class VideoProcessor {
    private $con;
    private $sizeLimit = 500000000;
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");
    private $ffmpegPath; // = "ffmpeg/bin/ffmpeg"; -> linux environment
    private $ffprobePath; // = "ffmpeg/bin/ffmpeg"; -> linux environment

    public function __construct($con) {
        $this->con = $con;
        $this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe"); // for windows environments
        $this->ffprobePath = realpath("ffmpeg/bin/ffprobe.exe"); // for windows environments
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
            
            $finalFilePath = $targetDir . uniqid() . ".mp4";

            if(!$this->insertVideoData($videoUploadData, $finalFilePath)) {
                echo "Insert query failed";
                return false;
            }

            if(!$this-> convertVideoToMp4($tempFilePath, $finalFilePath)) {
                echo "upload failed";
                return false;
            }

            if(!$this-> deleteFile($tempFilePath)) {
                echo "upload failed";
                return false;
            }

            if(!$this-> generateThumbnails($finalFilePath)) {
                echo "upload failed - could not generate thumbnail";
                return false;
            }
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

    // Check for the size of input file
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

    // Inset video data into database
    private function insertVideoData($uploadData, $filePath) {
        
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
                                        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");

        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }

    // Convert video format to mp4
    public function convertVideoToMp4($tempFilePath, $finalFilePath) {
        $cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";

        $outputLog = array();
        exec($cmd, $outputLog, $returnCode);

        if($returnCode != 0) {
            foreach($outputLog as $line) {
                echo $line . "<br>";
            }
            return false;
        }
        return true;
    }

    // Delete the original file 
    private function deleteFile($filePath) {
        if(!unlink($filePath)) {
            echo "could not delete\n";
            return false;
        }

        return true;
    }

    // Generate thumbnails images for videos
    public function generateThumbnails($filePath) {
        $thumbNailSize = "210x118";
        $numThumbnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";

        $duration = $this->getVideoDuration($filePath);

        echo "duration: $duration";
    }

    private function getVideoDuration($filePath) {
        return shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }
    
}

?>