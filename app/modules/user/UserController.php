<?php

namespace app\modules\user;

use app\core\Controller;
use app\modules\user\classes\User;

class UserController implements Controller
{
    public function Route($data)
    {
        $jsondata = $data["JSON"];
        switch ($data["Page_key"]) {
            case "UserLogin":
                return (new User())->UserLogin($jsondata);
            default:
                return array("return_code" => false, "return_data" => array("Page Key not found"));
        }
    }
    public static function views($page)
    {
        $viewpath = "../app/modules/user/views/";

        switch ($page[1]) {
            case 'Login':
                load($viewpath . "Login.php");
                break;
            case "UserDashboard":
                load($viewpath . "UserDashboard.php");
                break;
            default:
                // session_destroy();
                include '404.php';
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                break;
        }
    }
}
