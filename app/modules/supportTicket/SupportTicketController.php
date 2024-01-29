<?php

namespace app\modules\supportTicket;
use app\core\Controller;
use app\modules\supportTicket\classes\SupportTicket;

class SupportTicketController implements Controller
{
    /* 
    Current Version: 2.0.0
    Created By: Devkanta,     dev1@techz.in
    Created On: 05/12/2023
    Modified By:
    Modified On: 
*/

    public function Route($data)
    {
        $jsondata = $data["JSON"];

        switch ($data["Page_key"]) {

            case 'getAllCategoryLevel':
                return (new SupportTicket())->getAllCategoryLevel($jsondata);

            case 'addGrievanceCategory':
                return (new SupportTicket())->addGrievanceCategory($jsondata);

            case 'getCategoryList':
                return (new SupportTicket())->getCategoryList($jsondata);

            case 'getZeroLevelCategory':
                return (new SupportTicket())->getZeroLevelCategory($jsondata);

            case 'getMainCategories':
                return (new SupportTicket())->getMainCategories($jsondata);

            case 'getSubCategories':
                return (new SupportTicket())->getSubCategories($jsondata);

            case 'getNextLevelCategories':
                return (new SupportTicket())->getNextLevelCategories($jsondata);

            case 'LodgeGrievances':
                return (new SupportTicket())->LodgeGrievances($jsondata);

            case 'getLodgeGrievancesList':
                return (new SupportTicket())->getLodgeGrievancesList($jsondata);

            case 'onView':
                return (new SupportTicket())->onView($jsondata);

            case 'getTotalGrievances':
                return (new SupportTicket())->getTotalGrievances($jsondata);

            case 'getRecentLodgeGrievances':
                return (new SupportTicket())->getRecentLodgeGrievances($jsondata);

            case 'loadPieChart':
                return (new SupportTicket())->loadPieChart($jsondata);

            case 'getNextLevelCategory':
                return (new SupportTicket())->getNextLevelCategory($jsondata);

            case 'LodgeGrievancesAPI':
                return (new SupportTicket())->LodgeGrievancesAPI($jsondata);


            default:
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                session_destroy();
                return array("return_code" => false, "return_data" => array("Page Key not found"));
        }
    }


    static function Views($page)
    {

        $viewpath = "../app/modules/supportTicket/views/";
      
        switch ($page[1]) {

            case 'lodgegrievance':
                load($viewpath . "lodgegrievance.php");
                break;

            case 'categorygrievance':
                load($viewpath . "categorygrievance.php");
                break;

            case 'dashboard':
                load($viewpath . "dashboard.php");
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
