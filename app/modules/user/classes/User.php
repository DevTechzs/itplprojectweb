<?php

namespace  app\modules\user\classes;

use app\database\DBController;
use app\misc\Sodium;

class User
{
    function UserLogin($data)
    {
        $params1 = array(array(":EmailID", $data['EmailID']));
        $getStaffQuery = "SELECT StaffID from staff where EmailID =:EmailID";
        $staffData = DBController::getDataSet($getStaffQuery, $params1);
        $staffID = $staffData[0]['StaffID'];

        $params2 = array(
            array(":StaffPassword", $data['Password']),
            array(":StaffID", $staffID)
        );

        $matchPassword = "SELECT password from  ProjectStaffPassword where password =:StaffPassword and StaffID =:StaffID";
        $res = DBController::getDataSet($matchPassword, $params2);
    }
}
