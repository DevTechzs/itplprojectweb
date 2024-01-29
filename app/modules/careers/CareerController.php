<?php
namespace app\modules\careers;

use app\core\Controller;
use app\modules\careers\classes\Careers;

class CareerController implements Controller {

    public function Route($data)
    {
        $jsondata = $data["JSON"];

        switch ($data["Page_key"]) {

            case "getallApplicantsList":
                return (new Careers())->getallApplicantsList();
                
            case "getAllJObPosted":
                return (new Careers())->getAllJObPosted();

            case "postaJob":
                return (new Careers())->postaJob($jsondata);

            case "deletePostedJob":
                return (new Careers ())->deletePostedJob($jsondata);
                

                
            default:
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                session_destroy();
                return array("return_code" => false, "return_data" => array("Page Key not found"));
        }
    }

    public static function Views($page)
    {

        $viewpath = "../app/modules/$page[0]/views/";

        switch ($page[1]) {

            case 'applicantlist':
                load($viewpath . "applicantlist.php");
                break;

            case 'jobposted':
                load($viewpath . "jobposted.php");
                break;
            // case 'clientreport':
            //     load($viewpath . "clientReport.php");
            //     break;
            // case 'invoice':
            //         load($viewpath . "invoice.php");
            //         break;
            default:
                // session_destroy();
                include '404.php';
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                break;
        }
    }
}