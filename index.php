<?php


ini_set("session.cookie_httponly", True);
ini_set("session.cookie_secure", True);
ini_set("session.cookie_samesite", "Strict");

ini_set('session.gc_maxlifetime', 1800); // Set session timeout to 30 minutes (1800 seconds) 
// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/api/data/session'));

//local
// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/www/data/session'));

// header('Access-Control-Allow-Origin: https://meg.adoptaschool.org.in:443');
header("X-Frame-Options: SAMEORIGIN");
header("X-Frame-Options: DENY");
header("strict-transport-security: max-age=63072000 ");
header("Accept: text/html; charset=UTF-8");
header("Content-type: text/html; charset=UTF-8");
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
header("Developer: Iewduh Techz Private Limited");

session_start();


parse_str($_SERVER["QUERY_STRING"], $query_array);

if (isset($_SERVER['REMOTE_ADDR'])) {

    require_once("api/database/DBController.php");
    require_once("api/controllers/Settings.php");
    // require_once("api/controllers/Login.php");
    require_once("api/misc/MSC.php");
    // require_once("api/misc/Sodium.php");
    //require_once("api/misc/Session.php");

    header('Cache-Control: max-age=86400');
    header('HTTP/1.1 200 Success');
    header("Status: 200");
    $MSC = MSC::getMSC();

    if (isset($query_array['path'])) {
        // Settings::logIP();
        publicRequests($query_array);
    } else {
        header("Content-type: text/html;");
        require_once("pages/home.php");
    }
}

function publicRequests($query_array)
{
    switch ($query_array["path"]) {
        
        case "Test": // for initail Test
            require_once("pages/test.php");
            break;


            //END OF BLOGS

        default:
            //check if their is any array 
            if (strpos($query_array["path"], "-") > 0) {
                $arr = explode("-", $query_array["path"]);
                switch ($arr[0]) {

                    case "schoolerp":
                        if (!empty($arr[2])) {
                            $_SESSION["city"] =  $arr[2];
                        } else {
                            $_SESSION["city"] = "Shillong";
                        }
                        if (!empty($arr[1])) {
                            $_SESSION["state"] =  $arr[1];
                        } else {
                            $_SESSION["state"] = "Meghalaya";
                        }

                        require_once("pages/schoolerp.php");
                        break;
                    case "careerapply":
                        if (!empty($arr[1])) {
                            $_SESSION["CareerID"] = $arr[1];
                            require_once("pages/careerapply.php");
                        } else {
                            include '404.php';
                        }

                        break;

                    default:
                        // DBController::logs( "Invalid Page request :: " . $query_array["path"]);
                        header("Content-type: */*;");
                        header('HTTP/1.1 404 '); //This may be put inside 404.php instead
                        $_GET['e'] = 404; //Set the variable for the error code (you cannot have a
                        // querystring in an include directive).
                        include '404.php';
                }
            } else {
                // DBController::logs( "Invalid Page request :: " . $query_array["path"]);
                header("Content-type: */*;");
                header('HTTP/1.1 404 '); //This may be put inside 404.php instead
                $_GET['e'] = 404; //Set the variable for the error code (you cannot have a
                // querystring in an include directive).
                include '404.php';
            }
    }
}


