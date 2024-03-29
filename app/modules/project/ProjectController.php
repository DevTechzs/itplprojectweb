<?php

namespace app\modules\project;

use app\core\Controller;
use app\modules\project\classes\Project;

class ProjectController implements Controller
{

    public function Route($data)
    {
        $jsondata = $data["JSON"];

        switch ($data["Page_key"]) {



            case 'addTask':
                return (new Project())->addTask($jsondata);


            default:
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                session_destroy();
                return array("return_code" => false, "return_data" => array("Page Key not found"));
        }
    }

    public static function Views($page)
    {

        $viewpath = "../app/modules/project/views/";

        switch ($page[1]) {

            case 'showProject':
                load($viewpath . "showProject.php");
                break;

            case 'list':
                load($viewpath . "projectList.php");
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