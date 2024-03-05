<?php

namespace app\modules\performance;

use app\core\Controller;
use app\modules\performance\classes\Performance;

class PerformanceController implements Controller
{

    public function Route($data)
    {
        $jsondata = $data["JSON"];

        switch ($data["Page_key"]) {
            case "showPerformance":
                return (new Performance())->showPerformance($jsondata);

            case "departmentPerformance":
                return (new Performance())->showPerformance($jsondata);

            default:
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                session_destroy();
                return array("return_code" => false, "return_data" => array("Page Key not found"));
        }
    }

    public static function Views($page)
    {

        $viewpath = "../app/modules/performance/views/";

        switch ($page[1]) {

            case 'employeePerformance':
                load($viewpath . "showPerformance.php");
                break;
            case 'individualPerformance':
                load($viewpath . "individualPerformance.php");
                break;

            case 'departmentPerformance':
                load($viewpath . "departmentPerformance.php");
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