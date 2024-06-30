<?php

namespace app\modules\project\classes;

use app\database\DBController;
use app\misc\Sodium;
use app\modules\documents\classes\Documents;
use app\database\Helper;

class Project
{
    /* 
    Current Version: 2.0.0
    Created By: Sahil,     dev1.in
    Created On: 
    Modified By:
    Modified On: 

*/




    // function getProjectTeamMembers()
    // {
    //     $query = "SELECT staff.StaffName
    //     FROM Project
    //     JOIN Staff ON Project.ManagerID = Staff.StaffID OR Project.ProjectCoordinatorStaffID = Staff.StaffID
    //     WHERE Project.ProjectTitle = 'Project X';";
    //     $res = DBController::getDataSet($query);
    //     if ($res) {
    //         return array("return_code" => true, "return_data" => $res);
    //     } else {
    //         return array("return_code" => false, "return_data" => "No data returned");
    //     }
    // }

    function getClients($data)
    {
        $query = "SELECT ClientID, ClientName from Clients;";
        $res = DBController::getDataSet($query);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function storingFiles($data, $file, $res, $field)
    {
        $extractLatestID = "SELECT ProjectID FROM project ORDER BY ProjectID DESC LIMIT 1";
        $extractLatestIDResult = DBController::sendData($extractLatestID);
        if (is_array($extractLatestIDResult) && isset($extractLatestIDResult['ProjectID'])) {
            // Extract the value of "LetterID" and convert it to an integer
            $DocumentID = intval($extractLatestIDResult['ProjectID']);
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
    function addProject($data)
    {
        $workOrderFile = $data['workOrderFile'];
        $projectAttachments = $data['ProjectAttachmentsFile'];
        $params = array(
            array(':projectTitle', $data['projectTitle']),
            array(':projectDescription', $data['projectDescription']),
            array(':projectManager', $data['managerId']),
            array(':clientId', $data['clientId']),
            array(':workorderNumber', $data['workorderNumber']),
            array(':workorderDate', $data['workorderdate']),
            array(':projectCoordinatorId', $data['projectCoordinatorId']),
            array(':clientCoordinatorName', $data['clientCoordinatorName']),
            array(':clientCoordinatorContactNo', $data['clientCoordinatorContactNo']),
            array(':projectBudget', $data['projectBudget']),
            // array(':startDate', $data['projectStartDate']),
            array(':dueDate', $data['projectDueDate']),
            // array(':assignedTo', implode(',', $data['assignedTo'])),
        );

        $query = "INSERT INTO Project (ProjectTitle, ProjectDescription, ManagerID, Attachments, 
            ClientID, WorkorderNumber, WorkorderDate, ProjectCoordinatorStaffID, 
            ClientCoordinatorName, ClientCoordinatorContactNo, ProjectBudget, DueDate)
            VALUES (:projectTitle, :projectDescription, :projectManager, NULL, 
            :clientId, :workorderNumber, :workorderDate, 
            :projectCoordinatorId, :clientCoordinatorName, :clientCoordinatorContactNo, 
            :projectBudget, :dueDate)";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            // return array("return_code" => true, "return_data" => "Record added successfully");
            if ($workOrderFile) $this->storingFiles($data, $workOrderFile, $res, 'workOrderFileID');
            if ($projectAttachments) $this->storingFiles($data, $projectAttachments, $res, 'attachmentsID');
            return array("return_code" => true, "return_data" => "Record added successfully");
        }
        return array("return_code" => false, "return_data" => " Error while saving the data");
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
                $q2 = "INSERT INTO `ProjectDocuments` (`DocumentPath`, `DocumentTitle`) VALUES (  :DocumentPath, :DocumentTitle);";
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
                        array(":ProjectID", $DocumentID)
                    );
                    $query2 = "UPDATE project SET $field =:DocumentId WHERE ProjectID =:ProjectID";
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
    function getProjectList($data)
    {
        $arr = array();

        $query = "SELECT 
        P.ProjectID,
        P.ProjectTitle,
        P.ProjectDescription,
        GROUP_CONCAT(S.StaffName) AS TeamMembers
        FROM 
        Project P
        left JOIN 
        ProjectModule PM ON P.ProjectID = PM.ProjectID
        left JOIN 
        ProjectTeamMembers PTM ON PM.ProjectModuleID = PTM.ProjectModuleID
        left JOIN 
        Staff S ON PTM.StaffID = S.StaffID
        GROUP BY 
        P.ProjectID, P.ProjectTitle, P.ProjectDescription;";

        $res = DBController::getDataSet($query);
        if ($res) {
            //browse all the projects and create a array of projects by encrypting the ID 
            $temparr = array();
            foreach ($res as $project) {

                $temparr = array(
                    "ProjectID" => Sodium::safeEncrypt($project['ProjectID']), //hashed project ID
                    "ProjectTitle" => $project['ProjectTitle'],
                    "ProjectDescription" => $project['ProjectDescription'],
                    "TeamMembers" => $project['TeamMembers'],
                );
                array_push($arr, $temparr);
            }
            return array("return_code" => true, "return_data" => $arr);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
    function getInfoOfIndividualProjects($data)
    {
        // DBController::logs('getInfoOfIndividualProjects- '.$data['ProjectID']); 
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
        );
        $query = "SELECT p.ProjectTitle, p.ProjectDescription, 
        CONCAT(mr.StaffName) AS ManagerName, p.ClientCoordinatorName, 
        p.ClientCoordinatorContactNo AS ClientCoordinatorPhone, p.ProjectCoordinatorStaffID, 
        CONCAT(pc.StaffName) AS ProjectCoordinatorName, p.WorkorderNumber, 
        p.WorkorderDate, pd.DocumentPath 
        FROM Project p 
        LEFT JOIN Staff mr ON p.ManagerID = mr.StaffID 
        LEFT JOIN Staff pc ON p.ProjectCoordinatorStaffID = pc.StaffID 
        left join ProjectDocuments pd on pd.DocumentID = p.workOrderFileID 
        WHERE p.ProjectID = :ProjectID";

        $res = DBController::sendData($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
    function updateProjectField($data)
    {
        $projectId = Sodium::safeDecrypt($data['ProjectID']);
        $newValue = $data['newValue'];
        $field = $data['field'];

        if ($field == "ManagerName") {
            $field = "ManagerID";
        } else if ($field == "ProjectCoordinatorName") {
            $field = "ProjectCoordinatorStaffID";
        }
        // if($field === "ManagerName"){$field}

        $query = "UPDATE Project SET $field = :newValue WHERE ProjectID = :ProjectID";

        // Prepare the parameters
        $params = array(
            array(':ProjectID', $projectId),
            array(":newValue", $newValue)
        );

        // Execute the query
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Update successful");
        } else {
            return array("return_code" => false, "return_data" => "Update failed");
        }
    }
    function getModulesForNotInStaff($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
            array(":StaffID", $data['StaffID'])
        );

        //         $query = "SELECT CASE 
        //     WHEN (
        //         SELECT COUNT(*) 
        //         FROM ProjectModule 
        //         WHERE ProjectID = :ProjectID
        //     ) = (
        //         SELECT COUNT(DISTINCT ptm.ProjectModuleID) 
        //         FROM ProjectTeamMembers ptm
        //         WHERE ptm.StaffID = :StaffID
        //         AND ptm.isRemoved = 0
        //     ) THEN 'yes'
        //     ELSE 'no'
        // END AS IsAssignedToAllModules
        // ";

        $query = "SELECT pm.ProjectModuleID, pm.ModuleName
FROM ProjectModule pm
WHERE pm.ProjectID = :ProjectID -- Project A
AND pm.ProjectModuleID NOT IN (
    SELECT ptm.ProjectModuleID
    FROM ProjectTeamMembers ptm
    WHERE ptm.StaffID = :StaffID-- Replace with the specific StaffID
    AND ptm.isRemoved = 0 -- Staff is not removed
);
";
        $res = DBController::getDataSet($query, $params);
        // if ($res['IsAssignedToAllModules'] == "yes") {
        //     return array("return_code" => true, "return_data" => $res);
        // } else {
        //     $q  = "SELECT pm.ProjectModuleID, pm.ModuleName
        //     FROM ProjectModule pm
        //     WHERE pm.ProjectID = :ProjectID AND NOT EXISTS (
        //         SELECT 1
        //         FROM ProjectTeamMembers ptm
        //         WHERE ptm.ProjectModuleID = pm.ProjectModuleID
        //         AND ptm.StaffID = :StaffID
        //         AND ptm.isRemoved = 0
        //     )
        //     ";
        // $result = DBController::getDataSet($q, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "Update failed");
        }
        // }
    }
    function getTeamMembers($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
        );
        $query = "SELECT DISTINCT s.StaffID,s.StaffName, d.DesignationName FROM Staff s 
        JOIN ProjectTeamMembers pt ON pt.StaffID = s.StaffID JOIN ProjectModule pm
         ON pm.ProjectModuleID = pt.ProjectModuleID join Setting_Designation d on
          s.DesignationID = d.DesignationID WHERE pm.ProjectID = :ProjectID and
          pt.isRemoved = 0;";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
    function getAllModulesOfMember($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
            array(":StaffID", $data['StaffID']),
        );
        $query = "SELECT DISTINCT pm.ProjectModuleID,pm.ModuleName from ProjectModule pm join ProjectTeamMembers ptm on 
        ptm.ProjectModuleID = pm.ProjectModuleID join Staff s on
         s.StaffID = ptm.StaffID join Project p on 
         p.ProjectID = pm.ProjectID where s.StaffID = :StaffID and pm.ProjectID = :ProjectID
         and ptm.isRemoved = 0;";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
    function getModulesByProjectID($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
        );
        $query = "SELECT ProjectModuleID, ModuleName FROM ProjectModule WHERE ProjectID = :ProjectID;";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
    function getStaffWithoutProjectByProjectID($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
        );
        // $query = "SELECT DISTINCT s.StaffID, s.StaffName
        // FROM staff s
        // LEFT JOIN ProjectTeamMembers ptm ON s.StaffID = ptm.StaffID
        // WHERE ptm.ProjectModuleID IS NULL
        // OR ptm.ProjectModuleID NOT IN (
        //     SELECT ProjectModuleID
        //     FROM ProjectModule
        //     WHERE ProjectID = :ProjectID
        // );
        // ";

        $query = "SELECT s.staffID ,s.StaffName
FROM Staff s
WHERE s.StaffID NOT IN (
    SELECT ptm.StaffID
    FROM ProjectTeamMembers ptm
    INNER JOIN ProjectModule pm ON ptm.ProjectModuleID = pm.ProjectModuleID
    WHERE pm.ProjectID = :ProjectID
    and ptm.isRemoved = 0-- Project A
);";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function showStaffAllToAssignProject()
    {
        // $query = "SELECT s.StaffID,s.StaffName, d.DesignationName FROM Staff s
        // JOIN Setting_Designation d ON s.DesignationID = d.DesignationID 
        // WHERE d.DesignationID IN (7,8,9,10);";
        $query = "SELECT s.StaffID,s.StaffName, d.DesignationName FROM Staff s
         JOIN Setting_Designation d ON s.DesignationID = d.DesignationID;";

        $res = DBController::getDataSet($query);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function addNewTeamMember($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
            array(":StaffID", $data['StaffId']),
            array(":ProjectModuleID", $data['ProjectModuleId'])
        );

        $checkStaffs = "SELECT ptm.StaffID,ptm.ProjectTeamMemberID from ProjectTeamMembers ptm 
        join ProjectModule pm 
        on pm.ProjectModuleID = ptm.ProjectModuleID
        where pm.projectID = :ProjectID and ptm.StaffId = :StaffID and ptm.ProjectModuleID=:ProjectModuleID;";

        $checkStaffData = DBController::sendData($checkStaffs, $params);

        $query = "";
        if ($checkStaffData) {
            $params = array(
                array(":StaffID", $checkStaffData['StaffID']),
                array(":ProjectModuleID", $data['ProjectModuleId']),
                array(":ProjectTeamMemberID", $checkStaffData['ProjectTeamMemberID']),

            );
            $query = "UPDATE ProjectTeamMembers SET isRemoved = 0,
            ProjectModuleID = :ProjectModuleID where ProjectTeamMemberID = :ProjectTeamMemberID and StaffID = :StaffID";
        } else {

            $params = array(
                array(":StaffID", $data['StaffId']),
                array(":ProjectModuleID", $data['ProjectModuleId'])

            );
            $query = "INSERT INTO ProjectTeamMembers(StaffID,
            ProjectModuleID, isRemoved, RemovedRemarks,
            isActive)values(:StaffID,:ProjectModuleID,0,'',1)";
        }
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Record added successfully");
        }
        return array("return_code" => false, "return_data" => " Error while saving the data");
    }


    function getManagers()
    {
        $query = "SELECT s.StaffID ,s.StaffName from Staff s join 
        Setting_Designation d on s.DesignationID = d.DesignationID where 
        d.DesignationName = 'manager';";
        $res = DBController::getDataSet($query);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    // function removeTeamMember($data)
    // {
    //     $params = array(
    //         array(":StaffID", $data['StaffId']),
    //         array(":removeRemarks", $data['removeRemarks'])
    //     );
    //     $query = "UPDATE ProjectTeamMembers
    //     SET RemovedRemarks = :removeRemarks, isRemoved = 1
    //     WHERE StaffID = :StaffID";
    //     $res = DBController::ExecuteSQL($query, $params);
    //     if ($res) {
    //         return array("return_code" => true, "return_data" => "Team Member Removed");
    //     }
    //     return array("return_code" => false, "return_data" => " Error while Removing team member");
    // }

    function editTeamMemberModule($data)
    {
        $params = array(
            array(":StaffID", $data['StaffId']),
            array(":newProjectModuleId", $data['ModuleId'])
        );
        $query = "";
        $flag = $data['AddOrRemove'];
        $message = "";
        if ($flag == 1) {
            // $q = "SELECT StaffID, ProjectModuleID FROM projectteammembers WHERE StaffID = :StaffID and
            //  ProjectModuleID =:newProjectModuleId and isRemoved = 1";
            // $result = DBController::sendData($q, $params);
            // if ($result) {
            $query = "INSERT into projectteammembers(StaffID, ProjectModuleID, AddedDate, isRemoved, isActive) 
                VALUES(:StaffID, :newProjectModuleId, now(), 0, 1)";
            // $query = "UPDATE ProjectTeamMembers set isRemoved = 0 where StaffID = :StaffID
            // and ProjectModuleID = :newProjectModuleId";
            // } else {
            //     return array("return_code" => false, "return_data" => " Staff Is already in the Module");
            // }
            $message = "Staff Added successfully";
        } else {
            array_push($params, array(":removedRemarks", $data['removeRemarks']));
            $query = "UPDATE ProjectTeamMembers
            SET isRemoved = 1 ,RemovedRemarks = :removedRemarks
            WHERE StaffID = :StaffID and
            ProjectModuleID = :newProjectModuleId";
            $message = "Staff Removed from successfully";
        }


        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $message);
        }
        return array("return_code" => false, "return_data" => "error while removing staff from module");
    }
    function showProjectCoordinatorName()
    {
        $query = "SELECT s.StaffID,s.StaffName FROM Staff s
        JOIN Setting_Designation d ON s.DesignationID = d.DesignationID 
        WHERE d.DesignationID IN (7,8,9,10);";
        $res = DBController::getDataSet($query);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }
    function addModule($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
            array(":ModuleName", $data['ModuleName']),
            array(":ModuleDescription", $data['ModuleDescription']),
            array(":ModulePriority", $data['ModulePriority']),
            array(":ReportManagerID", $data['ReportManager'])
        );
        $query = "INSERT INTO ProjectModule(ModuleName, ModuleDescription, ModulePriority, ProjectID
        ,ReportManagerStaffID, Planning,Designing,Development,Testing,Deployment
        ,UpdatedDate)values(:ModuleName,:ModuleDescription,:ModulePriority,:ProjectID,
        :ReportManagerID,0,0,0,0,0,now());";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "Module Entered" => $res);
        } else {
            return array("return_code" => false, "return_data" => "Error while inserting module");
        }
    }
    function getProjectModules($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID']))
        );
        $query = "SELECT pm.ProjectModuleID, pm.ModuleName, pm.ModuleDescription,pm.ModulePriority,pm.isCompleted,
    pm.Planning,pm.Designing,pm.Development, pm.Testing,pm.PlanningCompletionDate,pm.DesigningCompletionDate,
    pm.DevelopmentCompletionDate,pm.TestingCompletionDate,pm.ProjectModuleDueDate, pm.CompletionDate,
    s.StaffName  from ProjectModule pm inner join staff s on pm.ReportManagerStaffID  = s.StaffID where ProjectID = :ProjectID";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function removeModuleByModuleID($data)
    {
        $params = array(array("ModuleID", $data['ProjectModuleID']));
        $query = "DELETE FROM ProjectModule WHERE ProjectModuleID = :ModuleID";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Module removed successfully");
        } else {
            return array("return_code" => false, "return_data" => "Error while removing the module");
        }
    }

    function editProjectModuleDetails($data)
    {
        $field = $data['field'];
        $params1 = array(
            array(':ProjectModuleID', $data['ModuleID']),
            array(':newValue', ($data['newValue'])),
        );
        $fieldDate = $field . "CompletionDate";
        $query = "";

        if ($data['newValue'] == "1") {
            $query = "UPDATE ProjectModule SET $field = :newValue, 
            $fieldDate = CURRENT_TIME()
            WHERE ProjectModuleID = :ProjectModuleID;";
        } else {
            $query = "UPDATE ProjectModule SET $field = :newValue 
            WHERE ProjectModuleID = :ProjectModuleID;";
        }

        $res = DBController::ExecuteSQL($query, $params1);

        $params2 = array(array(
            'ProjectModuleID', $data['ModuleID']
        ));
        $getPhasesQuery = "SELECT Planning, Designing, Development, Testing from projectmodule p where ProjectModuleID =:ProjectModuleID;";
        $PhasesData = DBController::sendData($getPhasesQuery, $params2);
        if ($PhasesData['Planning'] && $PhasesData['Designing'] && $PhasesData['Development'] && $PhasesData['Testing']) {

            $updateStatusQuery = "UPDATE ProjectModule SET isCompleted = 1,
            CompletionDate = CURRENT_TIME()
             WHERE ProjectModuleID = :ProjectModuleID;";
            DBController::ExecuteSQL($updateStatusQuery, $params2);
        } else {
            $updateStatusQuery = "UPDATE ProjectModule SET isCompleted = 0,
            CompletionDate = CURRENT_TIME()
             WHERE ProjectModuleID = :ProjectModuleID;";
            DBController::ExecuteSQL($updateStatusQuery, $params2);
        }

        if ($res) {
            return array("return_code" => true, "return_data" => "Updated Successfully");
        } else {
            return array("return_code" => false, "return_data" => "Error while Updating");
        }
    }
}
