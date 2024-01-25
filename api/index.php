<?php

session_start();

 
header('Access-Control-Allow-Origin:  https://meg.adoptaschool.org.in:443');
header("Content-Security-Policy: default-src 'self'");
header("Accept: application/json; charset=utf-8");
header("Content-type: application/json; charset=utf-8");

$jsonarray = json_decode(file_get_contents("php://input"), true);
  if (isset($jsonarray["Page_key"]) && isset($jsonarray["JSON"]) && isset($jsonarray["MSC"])) {

    require_once("database/DBController.php");
    // require_once("misc/MSC.php");
    // require_once("misc/Session.php");
	// require_once("misc/SMS.php");

    // $mk = MSC::getMSC();
    $result = array("return_data"=>false);

    header('HTTP/1.1 200 Success');
    $_GET['e'] = 200;
    header("Status: 200");

         if ($jsonarray["Page_key"] == "Login") { 
           //  session_destroy(); 
        }
         else{ 
             if(isset($_SESSION["UserID"]))
            {
                    //check if their is any active session then execute this portion
                    $timeout_duration = 120; // Session timeout in seconds 1800 (30 minutes )
                    $current_time = time();
                    if(isset($_SESSION['last_activity'])){
                        $last_activity = $_SESSION['last_activity'];

                        if (($current_time - $last_activity) > $timeout_duration) {
                            header('Location: logout'); // Redirect to login page or desired location 
                            // session_unset();    // Clear session variables
                            // session_destroy();  // Destroy the session                           
                            // exit();
                        } 
                    } 
                    // // Update last activity time
                    $_SESSION['last_activity'] = $current_time;
            } 
            
        }
 
         switch ($jsonarray["Page_key"]) { 

            case "submitApplication":
                require_once("controllers/Settings.php");
                $settings = new Settings();
                $result = $settings->submitApplication($jsonarray['JSON']); 
                break;   

            case "AddLeads":
                require_once("controllers/Settings.php");
                $settings = new Settings();
                $result = $settings->AddLeads($jsonarray['JSON']); 
                break; 

            case "AddItplRequirements":
                require_once("controllers/Settings.php");
                $settings = new Settings();
                $result = $settings->AddItplRequirements($jsonarray['JSON']); 
                break;
            
            default:
                DBController::logs($jsonarray["Page_key"]);
                $result = "key not found";
                header('HTTP/1.1 401 Unauthorized Access');
                $_GET['e'] = 401;
                header("Status: 401 ");
                break;
        }
    $result['Page_key'] = $jsonarray["Page_key"]; 
    DBController::CloseDB();
    echo json_encode($result);
}else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $valid_exts_videos = array("mp4", "m4v", "mkv", "avi", "mov", "wmv", "mpeg"); // valid extensions
    $valid_exts_images = array("jpeg", "jpg", "png", "bmp", "tiff"); // valid extensions
    $valid_exts_audios = array("mp3", "wav"); // valid extensions
    $valid_exts_documents = array("pdf"); // valid extensions


    $max_size = 2048 * 1024 * 1024; // max file size in bytes

    $json = array();


    if (isset($_FILES['file']) and $_FILES['file']['size'] < $max_size) {
        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

        $type = "";

        $uid = uniqid();
        $path = "../data/";
        // $path = "/data/";
        $filepath = "";

        if (in_array($ext, $valid_exts_videos)) {
            if (!file_exists($path . 'video')) {
                mkdir($path . 'video', 0777, true);
            }
            $filepath = "video/";
        } elseif (in_array($ext, $valid_exts_images)) {
            if (!file_exists($path . 'image')) {
                mkdir($path . 'image', 0777, true);
            }
            $filepath = "image/";
        } elseif (in_array($ext, $valid_exts_audios)) {
            if (!file_exists($path . 'audio')) {
                mkdir($path . 'audio', 0777, true);
            }

            $filepath = "audio/";
        } elseif (in_array($ext, $valid_exts_documents)) {
            if (!file_exists($path . 'document')) {
                mkdir($path . 'document', 0777, true);
            }

            $filepath = "document/";
        }

        $filepath = $filepath . $uid . "." . $ext;

        $json["return_code"] = move_uploaded_file($_FILES['file']['tmp_name'], $path . $filepath);
        $json["return_data"] = array("status" => "Uploaded", "path" => $filepath);
    }
    echo json_encode($json);
}  else {
    header("Content-type: */*;");
    header('HTTP/1.1 404 Not Found'); //This may be put inside 404.php instead
    $_GET['e'] = 404; //Set the variable for the error code (you cannot have a
    // querystring in an include directive).
    if ($jsonarray == null)
        include '404.php';
    else
        echo '{ "Error" : "404" }';
} //Do not do any more work in this script.