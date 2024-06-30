<?php

namespace  app\modules\user\classes;

use app\database\DBController;
use app\misc\Sodium;

class User
{
    function getProjectListOfStaff($data)
    {
        $params = array(array(
            'StaffID', $data['StaffID']
        ));
        $query = "SELECT DISTINCT p.ProjectID, p.ProjectTitle, c.ClientName  from project p join projectmodule pm on p.ProjectID = pm.ProjectID
        join ProjectTeamMembers ptm on pm.ProjectModuleID  = ptm.ProjectModuleID 
        join Clients c on c.ClientID = p.ClientID where ptm.StaffID =:StaffID AND ptm.isRemoved = 0;";

        $res = DBController::getDataSet($query, $params);

        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
    function getModulesOfStaff($data)
    {
        $params = array(
            array("StaffID", $data['StaffID']),
            array("ProjectID", $data['ProjectID'])
        );

        $query = "SELECT DISTINCT pm.ProjectModuleID,pm.ModuleName from projectmodule pm join projectteammembers ptm 
        on pm.ProjectModuleID = ptm.ProjectModuleID  where pm.ProjectID =:ProjectID  and ptm.StaffID =:StaffID and ptm.isRemoved = 0;";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function getModuleTask($data)
    {
        $params = array(
            array("StaffID", $data['StaffID']),
            array("ModuleID", $data['ModuleID'])
        );
        $query = "SELECT t.TaskID, t.TaskTitle, t.TaskStatus, t.Priority, t.DueDate  from task t join projectmodule pm
        on t.ProjectModuleID = pm.ProjectModuleID where t.ProjectModuleID  = :ModuleID and FIND_IN_SET(:StaffID, t.AssignedToStaffIDs);";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function updateTaskStatus($data)
    {
        $params = array(
            array(
                "TaskID", $data["TaskID"]
            ),
            array("TaskStatus", $data['TaskStatus'])
        );
        $query = "UPDATE Task SET TaskStatus = :TaskStatus WHERE TaskID = :TaskID";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
}
