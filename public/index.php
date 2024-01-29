<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_ALL);
ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '../app/data/session'));

//ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/www/app.techz.in/app/data/session'));
//session_id(md5(getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR')));
session_start();
header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Origin:  https://vta.techz.in:443');

header("Accept: text/html; charset=UTF-8");
header("Content-type: text/html; charset=UTF-8");
header('Cache-Control: max-age=86400');
header('HTTP/2 200 Success');
header("Status: 200");
header("Server: MAC_OS_X");
header("X-Powered-By: Python");
header("Developer: Monoj Das");
date_default_timezone_set('Asia/Kolkata');

// set to the user defined error handler
$old_error_handler = set_error_handler("myErrorHandler");

if (isset($_SERVER["HTTP_COOKIE"])) {
    header("HTTP_COOKIE: " . $_SERVER["HTTP_COOKIE"]);
}
if (isset($_SERVER["Cookie"])) {
    header("Cookie: " . $_SERVER["Cookie"]);
}

if (isset($_SESSION["UserType"]) && $_SESSION["UserType"] == 1) {
    define("VIEWPATH", "../app/views/admin");
} elseif (isset($_SESSION["UserType"]) && $_SESSION["UserType"] == 4) {
    define("VIEWPATH", "../app/views/admission");
} else {
    define("VIEWPATH", "../app/views");
}

$data = json_decode(file_get_contents("php://input"), true);
parse_str($_SERVER["QUERY_STRING"], $query_array);

require_once("../vendor/autoload.php");

use app\modules\auth\AuthenticationController;
use app\misc\MSC;
use app\misc\IPLogger;
use app\database\DBController;
use app\modules\auth\classes\Password;
use app\modules\clients\ClientController;
use app\modules\filemanager\FileController;
use app\modules\settings\SettingController;
use app\modules\products\ProductsController;
use app\modules\supports\SupportController;
use app\modules\supportTicket\SupportTicketController;
//newly added
use app\modules\careers\CareerController;
use app\modules\supportTicket\classes\SupportTicket;
use app\modules\staff\StaffController; //added by dev on 19/01/24

if (!isset($data["JSON"])) {
    $data["JSON"] = "";
}
if (!isset($data["Page_key"])) {
    $data["Page_key"] = "";
}

DBController::logs(json_encode($data));

IPLogger::logIP($data);

if (isset($data["Module"]) && isset($data["Page_key"]) && isset($data["JSON"]) && isset($data["MSC"])) {

    header('HTTP/1.1 200 Success');
    header("Status: 200");

    $result = array("return_code" => false);

    $msc = MSC::getMSC();

    //    if (!(MSC::isValidMSC($data["MSC"]))) {
    //        $result = array("return_code" => false, "return_data" => array("Invalid Request"));
    //
    //        header('HTTP/1.1 403 Forbidden');
    //        header("Status: 403");
    //
    //        echo json_encode($result);
    //        exit();
    //    }

    if (AuthenticationController::isValidSession($data)) {

        switch ($data["Module"]) {

            case "Settings":
                $result = (new SettingController())->Route($data);
                break;

            case "Client":
                $result = (new ClientController())->Route($data);
                break;
            case "Products":
                $result = (new ProductsController())->Route($data);
                break;

            case "Auth":
                $result = (new AuthenticationController())->Route($data);
                break;

            case "Careers":
                $result = (new CareerController())->Route($data);
                break;


            case "SupportTicket":
                $result = (new SupportTicketController())->Route($data);
                break;

            case "Staff": //added by dev on 19/01/24
                $result = (new StaffController())->Route($data);
                break;


            default:
                $result = array("return_code" => false, "return_data" => array("Module key not found"));
                session_destroy();
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                break;
        }

        $result['Module'] = $data["Module"];
        $result['Page_key'] = $data["Page_key"];
    } else {

        switch ($data["Module"]) {

            case "Careers":
                $result = (new CareerController())->Route($data);
                break;

            case "Auth":

            
                $result = (new AuthenticationController())->Route($data);
                break;

            case "Client":
                if ($data["Page_key"] = "getClientsByProductCode")
                    // $result = (new \app\modules\clients\classes\Client())->getClientsByProductCode($data["JSON"]);
                    break;
            default:
                $result = (new AuthenticationController)->Route($data);
                break;
        }

        $result['Module'] = $data["Module"];
        $result['Page_key'] = $data["Page_key"];
    }

    DBController::CloseDB();
    echo json_encode($result);
    exit();
} else if (isset($query_array['path']) && AuthenticationController::isValidSession($data)) {
    // pages 
    $page = explode("-", $query_array["path"]);

    load(VIEWPATH . "/template.php");

    $template = ob_get_clean();
    # Replacement
    ob_start();


    switch ($page[0]) {

        case "":
        case "dashboard":
            load(VIEWPATH . "/dashboard.php");
            break;

        case "clients":
            ClientController::Views($page);
            break;
        case "products":
            ProductsController::Views($page);
            break;
        case "file":
            FileController::File();
            break;

        case "settings":
            SettingController::Views($page);
            break;

        case "careers":
            CareerController::Views($page);
            break;

        case "changepassword":
            load("../app/views/admin/changepassword.php");
            break;


        case "supports":
            SupportController::Views($page);
            break;

        case "supportTicket":
            SupportTicketController::Views($page);
            break;

        case "staff":
            StaffController::Views($page); //added by dev on 19/01/24
            break;

        case "logout":
            session_destroy();
            header('Location: login');
            ob_end_flush();
            exit;
            break;



            




        default:
            header("Content-type: */*;");
            header('HTTP/2 404 Not Found'); //This may be put inside 404.php instead
            $_GET['e'] = 404; //Set the variable for the error code (you cannot have a querystring in an include directive).
            include '404.php';
    }

    $replacement = ob_get_clean();
    $res = str_replace('{{content}}', $replacement, $template);
    echo $res;
} else if (AuthenticationController::isValidSession($data)) {

    if ($_SESSION["UserType"] == 1) {
        header('Location: dashboard');
        ob_end_flush();
        /* Make sure that code below does not get executed when we redirect. */
        exit;
    } else {
        header('Location: home');
        exit;
    }
} else if (isset($query_array['path'])) {
    publicRequest($query_array);
} else {

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

        header("Content-type: */*;");
        header('HTTP/1.1 404 Not Found'); //This may be put inside 404.php instead
        echo json_encode(array("ERROR" => 404));
    } else {
        header("Content-type: text/html;");
        header('Location: login');
        echo "<script>window.location.href = '/login'</script>";
        exit;
    }
} //Do not do any more work in this script.

function publicRequest($query_array)
{
    try {
        $link = pathinfo((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);

        switch ($query_array['path']) {

            case "":
                header('Location: login');
                exit;
            case "login":
                load(VIEWPATH . "/login.php");
                break;
            case "test123":
                load(VIEWPATH . "/test.php");
                break;

            case "file":
                FileController::File();
                break;

            case "website-home":
                load(VIEWPATH . "/website/home/home.php");
                break;

            case "logout":
                session_destroy();
                header('Location: login');
                exit;

            default:
                header("Content-type: text/html;");
                header('HTTP/2 404 Not Found'); //This may be put inside 404.php instead
                include '404.php';
        }
    } catch (Exception $e) {
        include '../500.php';
        exit;
    }
}

function load($path)
{
    try {
        if (!@include_once($path)) // @ - to suppress warnings, 
            // you can also use error_reporting function for the same purpose which may be a better option
            throw new Exception($path . ' does not exist');
        // or 
        if (!file_exists($path))
            throw new Exception($path . ' does not exist');
        else
            require_once($path);
    } catch (Exception $e) {
        echo "Message : " . $e->getMessage();
        echo "Code : " . $e->getCode();
        include '404.php';
    }
}

// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }

    // $errstr may need to be escaped:
    $errstr = htmlspecialchars($errstr);

    $errormessage = "";

    switch ($errno) {
        case E_USER_ERROR:
            $errormessage .= "<b>My ERROR</b> [$errno] $errstr\n";
            $errormessage .=  "  Fatal error on line $errline in file $errfile\n";
            $errormessage .=  "Aborting...<br />\n";
            DBController::logs($errormessage);
            exit(1);

        case E_USER_WARNING:
            $errormessage .=  "<b>My WARNING</b> [$errno] $errstr<br />\n";
            $errormessage .=  "  Fatal error on line $errline in file $errfile\n";
            $errormessage .=  "Aborting...<br />\n";
            break;

        case E_USER_NOTICE:
            $errormessage .=  "<b>My NOTICE</b> [$errno] $errstr<br />\n";
            $errormessage .=  "  Fatal error on line $errline in file $errfile\n";
            $errormessage .=  "Aborting...<br />\n";
            break;
        case E_ERROR:
            $errormessage .=  "<b>File missing</b> [$errno] $errstr<br />\n";
            $errormessage .=  "  Fatal error on line $errline in file $errfile\n";
            $errormessage .=  "Aborting...<br />\n";
            break;

        default:
            $errormessage .=  "Unknown error type: [$errno] $errstr<br />\n";
            $errormessage .=  "  Fatal error on line $errline in file $errfile\n";
            $errormessage .=  "Aborting...<br />\n";

            DBController::logs($errormessage);
            exit(1);
            break;
    }

    DBController::logs($errormessage);
    /* Don't execute PHP internal error handler */
    return true;
}
