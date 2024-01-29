<?php

namespace app\modules\settings\classes;

use app\database\DBController;
use app\misc\FCM;
use app\misc\SMS;

class Department
{

    function addDepartment($data)  // added by dev on 05/12/23
    {
        // Prepare array

        $params = array(
            array(":DepartmentCode", $data["DeptCode"]),
            array(":DepartmentName", $data["DeptName"]),
        );
        $query = "INSERT INTO `grievance_category_department` (`DepartmentCode`, `DepartmentName`,`isActive`) VALUES (:DepartmentCode, :DepartmentName,1)";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Department added successfully");
        }
        return array("return_code" => false, "return_data" => "Error while saving the Department");
    }


    function getDepartment() // added by dev on 05/12/23
    {
        $query = "select grievance_category_department.*, grievance_category_department_staff .StaffID,GROUP_CONCAT(grievance_category_department_staff.StaffName) as StaffName ,GROUP_CONCAT(grievance_category_department_staff.StaffID) as StaffID from grievance_category_department INNER join grievance_category_department_staff on find_in_Set(grievance_category_department.DepartmentID,grievance_category_department_staff.DepartmentID) where find_in_Set(grievance_category_department.DepartmentID,grievance_category_department_staff.DepartmentID) and grievance_category_department.isActive = 1 and grievance_category_department_staff.isRemoved = 0 GROUP by grievance_category_department.DepartmentID;";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }


    function onDepartmentDelete($data) // added by dev on 05/12/23
    {
        $params = array(
            array(":DepartmentID", $data["DepartmentID"]),
        );
        $query = "UPDATE  `grievance_category_department`  SET isActive = 0 WHERE `DepartmentID`=:DepartmentID;";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Sucessfully Removed the Department");
        }
        return array("return_code" => false, "return_data" => "Error while removing the  Department");
    }

    function onUserDelete($data) // added by dev on 05/12/23
    {
        $params = array(
            array(":StaffID", $data["StaffID"]),
        );
        $query = "UPDATE  `grievance_category_department_staff` 
        SET isRemoved = 1 WHERE `StaffID`=:StaffID;";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Sucessfully Removed the User");
        }
        return array("return_code" => false, "return_data" => "Error while removing the  User");
    }


    function getDepartmentForAssignGrievanceCategory()
    {
        $query = "SELECT `DepartmentID`, `DepartmentName` FROM `Grievance_Category_Department` WHERE `isActive` = 1 ";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }

    function getEmployeeByDepartmentID($data)
    {
        $params = array(
            array(":DepartmentID", $data['DepartmentID']),
        );
        $query = "SELECT `StaffID`,`StaffName` FROM `Grievance_Category_Department_Staff` WHERE `DepartmentID` = :DepartmentID";
        $res = DBController::getDataSet($query, $params);
        return array("return_code" => true, "return_data" => $res);
    }

}
