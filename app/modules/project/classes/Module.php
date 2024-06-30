<?php

namespace app\modules\project\classes;

use app\database\DBController;
use app\misc\Sodium;


class Module
{
    function calculateProjectProgress($data)
    {
        $params = array(array(':ProjectID', Sodium::safeDecrypt($data['ProjectID'])));
        $query = "SELECT Planning, Designing, Development, Testing, Deployment FROM ProjectModule where ProjectID =:ProjectID";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "no data found");
        }
    }

    function getTaskForModule($data)
    {
        $params = array(array(':ProjectID', Sodium::safeDecrypt($data['ProjectID'])));
        $query = "SELECT t.TaskId, t.ProjectModuleID, t.TaskStatus  from Task t inner join
        ProjectModule pm on pm.ProjectModuleID  = t.ProjectModuleID where pm.ProjectID = :ProjectID";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            // Array to store task statuses grouped by ProjectModuleID
            $moduleTasks = array();
            foreach ($res as $task) {
                $moduleId = $task['ProjectModuleID'];
                if (!isset($moduleTasks[$moduleId])) {
                    $moduleTasks[$moduleId] = array();
                }
                $moduleTasks[$moduleId][] = $task['TaskStatus'];
            }

            // Set to store ProjectModuleIDs where all tasks have TaskStatus = 1
            $completedModules = array();
            foreach ($moduleTasks as $moduleId => $statuses) {
                if (count($statuses) > 0 && count(array_unique($statuses)) === 1 && $statuses[0] == 1) {
                    $completedModules[] = $moduleId;
                }
            }

            return array("return_code" => true, "return_data" => $completedModules);
        } else {
            return array("return_code" => false, "return_data" => "No data found");
        }
    }
}
