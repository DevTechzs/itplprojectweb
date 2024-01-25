<?php
namespace app\modules\auth;
use app\core\Controller;
use \app\database\DBController;
use app\modules\auth\classes\Login;
use app\modules\auth\classes\Password;
use app\modules\auth\classes\Session;
use app\modules\auth\classes\Signup;

class AuthenticationController implements Controller {

    function Route($data) {
        $jsondata = $data["JSON"];

        switch ($data["Page_key"]) {

            case 'Login':
                $result = (new Login())->requestLogin($jsondata);
                break;

            case 'Signup':
                $result = (new Signup())->request($jsondata);
                break;

            case 'SignupUserExists':
                $result = (new Signup())->exists($jsondata);
                break;

            case 'ForgotPassword':
                $result = (new Password())->ForgotPassword($jsondata);
                break;

            case 'ChangePassword':
                $result = (new Password())->ChangePassword($jsondata);
                break;

            case 'Logout':
                if (isset($_SESSION["UserID"]) && isset($_SESSION["SessionKey"]))
                    $result = (new Session())->revoke($jsondata);
                else
                    $result = array("return_code" => true, "return_data" => "Logged Out");
                break;

            default:
                $result = array("return_code" => false, "return_data" => array("Page Key not found"));
                session_destroy();
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                break;
        }

        return $result;
    }

    public static function isValidSession($data)
    {
        
        if (!isset($_SESSION["UserID"]) || !isset($_SESSION["SessionKey"])) {
            if ($data["Page_key"] == "Login" || $data["Page_key"] == "Signup" || $data["Page_key"] == "ForgotPassword") {
                session_destroy();
                session_start();
            }
            return false;
        }

        $params = array(
            array(":UserID", $_SESSION["UserID"]),
            array(":SessionKey", $_SESSION["SessionKey"])
        );

        $query = "SELECT LoginDetailsID FROM LoginDetails WHERE SessionExpiryDateTime>NOW() AND UserID = :UserID AND SessionKey = :SessionKey AND isActive = 1";

        if (DBController::sendData($query, $params)) {
            return true;
        } else {
            return false;
        }
    }

    public static function Views($page)
    {
        // TODO: Implement Views() method.
    }
}
