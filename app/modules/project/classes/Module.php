<?php

namespace app\modules\project\classes;

use app\database\DBController;
use app\misc\Sodium;
use app\modules\documents\classes\Documents;
use app\database\Helper;

class Module
{
    function calculateProjectProgress($data)
    {
        $params = array(array(':ProjectID', Sodium::safeDecrypt($data['ProjectID'])));
        $query = "SELECT Planning, Designing, Development, Testing, Deployment FROM Projectmodule where ProjectID =:ProjectID";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "no data found");
        }
    }
}
