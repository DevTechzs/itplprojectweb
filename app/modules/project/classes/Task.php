<?php

namespace app\modules\project\classes;

use app\database\DBController;
use app\misc\Sodium;
use app\modules\documents\classes\Documents;
use app\database\Helper;

class Task
{

    function storingFiles($data, $file, $res, $field)
    {
        $extractLatestID = "SELECT TaskId FROM task ORDER BY TaskId DESC LIMIT 1";
        $extractLatestIDResult = DBController::sendData($extractLatestID);
        if (is_array($extractLatestIDResult) && isset($extractLatestIDResult['TaskId'])) {
            // Extract the value of "LetterID" and convert it to an integer
            $DocumentID = intval($extractLatestIDResult['TaskId']);
        } else {
            // Handle the case where "LetterID" is not found or $extractLatestIDResult is not an array
            $DocumentID = null; // or any other fallback value
        }
        if (!$res) {
            return array("return_code" => false, "return_data" => "Document could not be uploaded ");
        } else {
            if (!empty($file)) {
                $documentHandlingResult = $this->handleDocuments($file, $DocumentID, $field);
                if ($documentHandlingResult) {
                    return array("return_code" => true, "return_data" => "Document Saved");
                } else {
                    return array("return_code" => false, "return_data" => "Document could not be saved");
                }
            }
        }
    }

    function handleDocuments($data, $DocumentID, $field)
    {
        // Handle documents
        if (!file_exists("../app/data/letters/")) {
            mkdir("../app/data/letters/", 0777, TRUE);
        }

        // DBController::logs("Reached handleDocuments ");
        ini_set('memory_limit', '-1');
        $documentsIDs = '';
        $files = $data;
        $f1 = array();
        array_push($f1, $files);
        foreach ($f1 as $file) {
            $parts = explode(',',  $file["filedata"], 2);
            if (count($parts) === 2) {
                $header = $parts[0];
                $data = $parts[1];
                $header_parts = explode(';', $header);
                $mime_type = $header_parts[0];
                $ext = explode('/', $mime_type)[1];
                $filearray = array(
                    'ext' => $ext,
                    'file' => $data
                );
                // Now you can use $filearray as needed
            } else {
                // Handle the case where explode didn't return expected parts
                echo "Invalid data format: " . $file["filedata"];
            }
            // $urlFileData=$path;
            // new Documents = new Documents();
            $path = (new Documents())::storeDocuments("DOCUMENT", $filearray);
            // DBController::logs("Reached Documents");
            $ext = pathinfo($file['filename'], PATHINFO_EXTENSION);
            $filedata = file_get_contents($file['filedata']);

            do {
                $newfilename = "n_" . Helper::generate_string(10) . "." . $ext;
            } while (file_exists("../app/data/letters/" . $newfilename));

            $fp = fopen("../app/data/letters/" . $newfilename, "w+");
            if (fwrite($fp, ($filedata))) {
                $q2 = "INSERT INTO taskdocuments (DocumentPath, DocumentTitle) VALUES (  :DocumentPath, :DocumentTitle);";
                $p2 = [
                    [":DocumentPath", $newfilename],
                    [":DocumentTitle", $file['filename']],
                ];
                $r2 = DBController::ExecuteSQLID($q2, $p2);
                $documentsIDs = $r2 . ',' . $documentsIDs;
                if ($documentsIDs) {
                    // Update LeaveDocumentIDs in Administration_Letter
                    $param2 = array(
                        array(":DocumentId", rtrim($documentsIDs, ",")),
                        array(":TaskID", $DocumentID)
                    );
                    $query2 = "UPDATE task SET $field =:DocumentId WHERE TaskId =:TaskID";
                    $updateLeaveDoc = DBController::ExecuteSQL($query2, $param2);
                    if ($updateLeaveDoc) {
                        return array("return_code" => true, "return_data" => "Documents added successfully");
                    } else {
                        return array("return_code" => false, "return_data" => "Error updating leave documents");
                    }
                }
            } else {
                return array("return_code" => false, "return_data" => "File not saved !!");
            }
            fclose($fp);
        }
    }



    function addTask($data)
    {
        $taskFile = $data['taskFile'];
        $params = array(
            array(":AssignedFrom", $_SESSION['UserID']),
            array(':ProjectModuleID', $data['projectModuleID']),
            array(':TaskTitle', $data['taskTitle']),
            array(':TaskDescription', $data['taskDescription']),
            array(':AssignedToStaffIDs', implode(',', $data['assignedToStaffIDs'])),
            array(':StartDate', $data['startDate']),
            array(':DueDate', $data['dueDate']),
            array(':Priority', $data['priority']),
        );

        $query = "INSERT INTO Task (ProjectModuleID, TaskTitle, TaskDescription, AssignedToStaffIDs, AssignedFromStaffID,  StartDate, DueDate,  priority) 
                  VALUES (:ProjectModuleID, :TaskTitle, :TaskDescription, :AssignedToStaffIDs, :AssignedFrom, :StartDate, :DueDate,  :Priority)";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {


            if ($taskFile) {
                $this->storingFiles($data, $taskFile, $res, 'DocumentID');
            }
            return array("return_code" => true, "return_data" => "Record added successfully");
        }
        return array("return_code" => false, "return_data" => " Error while saving the data");
    }

    function seeAllProjectTaskByProjectID($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
        );
        $query = "SELECT t.TaskID, t.TaskTitle,t.TaskDescription, t.ProjectModuleID, GROUP_CONCAT(st.StaffName) AS AssignedToStaffNames,
         t.TaskStatus, t.DueDate, td.DocumentPath
        FROM Task t
        INNER JOIN ProjectModule pm ON t.ProjectModuleID = pm.ProjectModuleID
        INNER JOIN Project p ON pm.ProjectID = p.ProjectID
        INNER JOIN Staff st ON FIND_IN_SET(st.StaffID, t.AssignedToStaffIDs)
        left JOIN taskdocuments td on td.DocumentID = t.DocumentID
        WHERE p.ProjectID = :ProjectID
        GROUP BY t.TaskId, t.TaskTitle, t.TaskStatus, t.DueDate;
        ";


        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function StaffWithoutTaskByTaskID($data)
    {
        $params  = array(
            array(":TaskID", $data['TaskID']),
            array(':ProjectModuleID', $data['ProjectModuleID']),
            // array(":ProjectID", Sodium::safeDecrypt($data['ProjectID']))
        );
        // $query = "SELECT distinct s.StaffID, s.StaffName FROM staff s JOIN ProjectTeamMembers ptm ON
        //  s.StaffID = ptm.StaffID JOIN ProjectModule pm ON ptm.ProjectModuleID = pm.ProjectModuleID 
        //  WHERE FIND_IN_SET(s.StaffID, (SELECT AssignedToStaffIDs FROM Task WHERE TaskId = :TaskID)) = 0 
        //  and ptm.ProjectModuleID = :ProjectModuleID and pm.ProjectID=:ProjectID;";

        $query = "SELECT s.StaffID, s.StaffName FROM Staff s JOIN Projectteammembers ptm ON s.StaffID = ptm.StaffID WHERE ptm.ProjectModuleID = :ProjectModuleID
         AND ptm.isRemoved = 0 AND s.StaffID NOT IN ( SELECT t.AssignedFromStaffID FROM Task t WHERE t.ProjectModuleID =:ProjectModuleID  AND t.TaskId = :TaskID);";

        // $query = "SELECT distinct s.StaffID, s.StaffName FROM staff s JOIN ProjectTeamMembers ptm on
        // s.StaffID = ptm.StaffID JOIN ProjectModule pm ON ptm.ProjectModuleID = pm.ProjectModuleID
        // where FIND_IN_SET(s.StaffID, (SELECT AssignedToStaffIDs FROM Task WHERE TaskId = :TaskID))=0
        // and pm.ProjectID = :ProjectID;";
        $res = DBController::getDataSet($query, $params);
        if (count($res) == 0 || count($res) >= 1) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }


    function UpdateTask($data)
    {
        $message = "";
        $newValue = "";
        $column = str_replace("new", "", $data['field']);
        if ($column == "StaffsInTask") {
            $column = "AssignedToStaffIDs";
            $p1 = array(array(":TaskID", $data['taskID']));
            $getStaffs = "SELECT AssignedToStaffIDs from Task WHERE TaskID = :TaskID";
            $result = DBController::sendData($getStaffs, $p1);
            foreach ($result as $r) {
                $newValue = $r;
            }
            $newValue = preg_replace('/\b' . $data['newvalue'] . '\b,?/', '', $result);
            $newValue = implode(",", $newValue);
        } else if ($column == "AssignedToStaffIDs") {
            $p1 = array(array(":TaskID", $data['taskID']));
            $getStaffs = "SELECT AssignedToStaffIDs from Task WHERE TaskID = :TaskID";
            $result = DBController::sendData($getStaffs, $p1);
            foreach ($result as $r) {
                $newValue = $r;
            }
            $newValue = explode(",", $newValue);
            array_push($newValue, $data['newvalue']);
            $newValue = implode(",", $newValue);
            $message = "Staff Added Successfully";
        } else if ($column == "staffsToRemoveFromTask") {
            $column = "AssignedToStaffIDs";
            $params = array(
                array(":newValue", $data['newvalue']),
                array(":TaskID", $data['taskID'])
            );
            $p1 = array(array(":TaskID", $data['taskID']));
            $getStaffs = "SELECT AssignedToStaffIDs from Task WHERE TaskID = :TaskID";
            $result = DBController::sendData($getStaffs, $p1);
            foreach ($result as $r) {
                $newValue = $r;
            }
            $newValue = explode(",", $newValue);
            if (count($newValue) == 1) {
                $message  = "Cannot remove staff since there is only one staff in this task";
                return array("return_code" => false, "return_data" => $message);
            } else if (count($newValue) > 1) {
                $newValue  =  array_diff($newValue, [$data['newvalue']]);
                $newValue = implode(",", $newValue);
                $message = "Staff Removed Successfully";
            }
        } else {
            $newValue = $data['newvalue'];
        }
        $params = array(
            array(":newValue", $newValue),
            array(":TaskID", $data['taskID'])
        );
        $query = "UPDATE Task set $column = :newValue WHERE TaskId = :TaskID";

        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Task:" . $data['taskID'] . "updated\n" . $message);
        }
        return array("return_code" => false, "return_data" => "Error while updating task number: " . $data['taskID']);
    }

    function getStaffWithTaskID($data)
    {
        $params = array(
            array(":TaskID", $data['taskID'])
        );
        $query = "SELECT AssignedToStaffIDs from task WHERE TaskId = :TaskID";
        $res = DBController::sendData($query, $params);
        $str = "";
        foreach ($res as $r) {
            $str = $r;
        }
        // $str = rtrim($str, ",");
        $integers = array_map('intval', explode(',', $str));
        $integers = implode(",", $integers);
        $query = "SELECT StaffID, StaffName FROM staff WHERE StaffID IN ($integers)";
        $result = DBController::getDataSet($query);
        if ($result) {
            return array("return_code" => true, "return_data" => $result);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function uploadTaskDocument($data)
    {
        $taskFile = $data['DocumentDetails'];
        $taskId = array(array(':TaskId', $data['TaskID']));
        // $getDocIdFromTask = "SELECT DOCUMENTID from task WHERE TaskId = :TaskId;"
        $documentHandlingResult = $this->handleDocuments($taskFile, $data['TaskID'], 'DocumentID');
        if ($documentHandlingResult) {
            return array("return_code" => true, "return_data" => "Document Saved");
        } else {
            return array("return_code" => false, "return_data" => "Document could not be saved");
        }
    }

    function moduleMembersForTask($data)
    {
        $params = array(array(':ModuleID', $data['ModuleID']));
        $query = "select distinct s.StaffID, s.StaffName from staff s join
        projectteammembers ptm on s.StaffID = ptm.StaffID where ptm.ProjectModuleID  = :ModuleID and ptm.isRemoved = 0;";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No Staff in the module");
        }
    }
}
