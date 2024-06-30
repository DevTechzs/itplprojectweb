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
            case "getProjectListOfStaff":
                return (new User())->getProjectListOfStaff($jsondata);
            case "getModulesOfStaff":
                return (new User())->getModulesOfStaff($jsondata);
            case "getModuleTask":
                return (new User())->getModuleTask($jsondata);
            case "updateTaskStatus":
                return (new User())->updateTaskStatus($jsondata);
            default:
                return array("return_code" => false, "return_data" => array("Page Key not found"));
        }
    }
    public static function Views($page)
    {
        $viewpath = "../app/modules/user/views/";

        switch ($page[1]) {
            case "projects":
                load($viewpath . "projects.php");
                break;
            case "projectDetails":
                load($viewpath . "projectDetails.php");
                break;
            case "moduleTask":
                load($viewpath . "moduleTask.php");
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
