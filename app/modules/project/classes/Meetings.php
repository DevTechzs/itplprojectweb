<?php

namespace app\modules\project\classes;

use app\database\DBController;
use app\misc\Sodium;
use app\modules\documents\classes\Documents;
use app\database\Helper;

class Meetings
{


    function storingFiles($data, $file, $res, $field)
    {
        $extractLatestID = "SELECT MeetingID FROM ProjectMeetings ORDER BY MeetingID DESC LIMIT 1";
        $extractLatestIDResult = DBController::sendData($extractLatestID);
        if (is_array($extractLatestIDResult) && isset($extractLatestIDResult['MeetingID'])) {
            // Extract the value of "LetterID" and convert it to an integer
            $DocumentID = intval($extractLatestIDResult['MeetingID']);
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
                $q2 = "INSERT INTO MeetingsDocuments (`DocumentPath`, `DocumentTitle`) VALUES (  :DocumentPath, :DocumentTitle);";
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
                        array(":MeetingID", $DocumentID)
                    );
                    $query2 = "UPDATE ProjectMeetings SET $field =:DocumentId WHERE MeetingID =:MeetingID";
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
    function getProjectMeetingsInfoByProjectID($data)
    {
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
        );
        $query = "SELECT 
        PM.MeetingID,
        PM.MeetingDescription,
        PM.MeetingDate,
        md.DocumentPath,
        GROUP_CONCAT(S.StaffName SEPARATOR ', ') AS AttendeeNames
    FROM 
        ProjectMeetings PM
    LEFT JOIN 
        Staff S ON FIND_IN_SET(S.StaffID, PM.AttendeeStaffIDs)
    INNER JOIN MeetingsDocuments md on md.DocumentID = PM.MeetingDocumentID
    WHERE 
        PM.ProjectID = :ProjectID
    GROUP BY 
        PM.MeetingID, PM.MeetingDescription, PM.MeetingDate;";

        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "No data returned");
        }
    }

    function addProjectMeetingsData($data)
    {
        $meetingsReport = $data['MeetingsReport'];
        $params = array(
            array(":ProjectID", Sodium::safeDecrypt($data['ProjectID'])),
            array("MeetingDescription", $data['MeetingDescription']),
            array("MeetingAttendees", implode(",", $data['MeetingsAttendes'])),
            // array("MeetingsReport", $data['MeetingsReport'])
        );
        $query = "INSERT INTO ProjectMeetings(ProjectID, MeetingDescription, MeetingDate,
        AttendeeStaffIDs)
        VALUES(:ProjectID, :MeetingDescription,NOW(),:MeetingAttendees)";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            if ($meetingsReport) $this->storingFiles($data, $meetingsReport, $res, 'MeetingDocumentID');
            return array("return_code" => true, "return_data" => "Record added successfully");
        }
        return array("return_code" => false, "return_data" => " Error while saving the data");
    }
}
