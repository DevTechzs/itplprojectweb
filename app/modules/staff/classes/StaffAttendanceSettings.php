<?php
/*
    Current Version: 2.0.0
    Created By: Angelbert,     prayagedu@techz.in
    Created On: 24-01-2024
    Modified By:
    Modified On:
*/

namespace app\modules\staff\classes;
use app\database\DBController;

class StaffAttendanceSettings
{ 

    /*  Info:
        Description: to get the mode for attendance (QR, etc)
            24-01-2024 (Angelbert) : Adding the function
    */
    function getAttendanceMode()
        {
            $query = "SELECT `AttendanceModeID`, `AttendanceMode` FROM `Attendance_Mode`;";
            $res = DBController::getDataSet($query);
            return array("return_code" => true, "return_data" => $res);
        }

    /*  Info:
        Description: Getting the timing of  all staff designation wise
            24-01-2024 (Angelbert) : Adding the function 
    */
    function getSettingTiming()
        {
            $query = "SELECT sat.StaffAttendanceSettingID,sat.StartTime,sat.EndTime,Designation.DesignationID,Designation.DesignationName FROM `Staff_Attendance_Settings` sat
            RIGHT JOIN Designation on Designation.DesignationID=sat.DesignationID;";
            $res = DBController::getDataSet($query);
            return array("return_code" => true, "return_data" => $res);
        }

    /*  Info:
        Description: Getting the timing of  all staff based on staff wise
                    -- get only the active staff
            24-01-2024 (Angelbert) : Adding the function 
    */
    function getStaffTiming()
        {
            $query = "SELECT sat.StaffAttendanceTimingID,sat.DesignationID,sat.StartTime,sat.EndTime,sat.AttendanceModeID,Staff.StaffID,Staff.StaffName,attendance_mode.AttendanceMode FROM `Staff_Attendance_Timing` sat 
            LEFT JOIN Attendance_Mode on Attendance_Mode.AttendanceModeID=sat.AttendanceModeID 
            RIGHT JOIN Staff on Staff.StaffID=sat.StaffID where Staff.isRemoved=0 order by sat.StaffAttendanceTimingID desc;";
            $res = DBController::getDataSet($query);
            return array("return_code" => true, "return_data" => $res);
        }

    /*  Info:
        Description: Adding / Updating the setting for timing     
            24-01-2024 (Angelbert) : Adding the function 
    */
        function UpdatesettingTiming($data)
        {
            //first it will update uin setting then 
            //update setting  
            for ($i = 0; $i < count($data["AttendanceData"]); $i++) {
                //find out if the timing is null or not if null add a new one 
                if($data["AttendanceData"][$i]["StaffAttendanceTiming"]=="null"){
                     //insert the ID for this designaiton 
                     $params1 = array(
                        array(":AttendanceModeID", 1),
                        array(":StartTime", $data["AttendanceData"][$i]["StartTime"]),
                        array(":EndTime", $data["AttendanceData"][$i]["EndTime"]),
                        array(":DesignationID", $data["AttendanceData"][$i]["DesignationID"])
                    );
                     $sq="INSERT INTO Staff_Attendance_Settings(AttendanceModeID,StartTime,EndTime,DesignationID) 
                     VALUES(:AttendanceModeID,:StartTime,:EndTime,:DesignationID )";
                     $data["AttendanceData"][$i]["StaffAttendanceTiming"] =  DBController::ExecuteSQLID($sq, $params1);
                }
               
                //update timing setting
                $params1 = array(
                    array(":StartTime", $data["AttendanceData"][$i]["StartTime"]),
                    array(":EndTime", $data["AttendanceData"][$i]["EndTime"]),
                    array(":StaffAttendanceSettingID", $data["AttendanceData"][$i]["StaffAttendanceTiming"]),
                );
    
                $query1 = "UPDATE `Staff_Attendance_Settings` SET `StartTime`=:StartTime,`EndTime`=:EndTime WHERE `StaffAttendanceSettingID`=:StaffAttendanceSettingID";
                $res1 = DBController::executeSQL($query1, $params1);
    
                // update the staff Timing
                if($res1){
    
                    //check if entryies of that desigation is present or not 
                    $params = array( 
                        array(":DesignationID", $data["AttendanceData"][$i]["DesignationID"]),
                    );
                    $query = "SELECT DesignationID from  `Staff_Attendance_Timing`  WHERE `DesignationID`=:DesignationID";
                    $dt = DBController::sendData($query, $params);
                    
                    if(!$dt){
                        //insert all the staff with this designation id
                        $params = array( 
                            array(":DesignationID", $data["AttendanceData"][$i]["DesignationID"]) 
                        ); 
                        $query = " INSERT INTO `Staff_Attendance_Timing`(StaffID,DesignationID) 
                                    SELECT StaffID,DesignationID FROM Staff WHERE isRemoved=0 AND DesignationID = :DesignationID  ";
                       $res = DBController::executeSQL($query, $params);
                    }
                    $params = array(
                        array(":StartTime", $data["AttendanceData"][$i]["StartTime"]),
                        array(":EndTime", $data["AttendanceData"][$i]["EndTime"]),
                        array(":DesignationID", $data["AttendanceData"][$i]["DesignationID"]),
                    );
        
                    $query = "UPDATE `Staff_Attendance_Timing` SET `StartTime`=:StartTime,`EndTime`=:EndTime WHERE `DesignationID`=:DesignationID";
                    $res = DBController::executeSQL($query, $params);
                }  
            }
            return array("return_code" => true, "return_data" => "Sucessfully Update Timing");
        }

    /*  Info:
        Description:  Adding / Updating the timing for that staff   
            24-01-2024 (Angelbert) : Adding the function 
    */
    function saveStaffAttendanceTiming($data)
    {
        if (isset($data['StaffAttendanceTimingID']) && $data['StaffAttendanceTimingID'] != '') {
            //check first for Designation
            if (isset($data['DesignationID']) &&  $data['DesignationID'] != '') {
                $param8 = array(
                    array(":DesignationID", $data['DesignationID']),
                    array(":StartTime", $data['startTime']),
                    array(":EndTime", $data['EndTime']),
                    array(":StaffID", $data['StaffId']),
                    array(":AttendanceMode", $data['attendanceMode']),
                    array(":StaffAttendanceTimingID", $data['StaffAttendanceTimingID'])
                );
                $query8 = "UPDATE `Staff_Attendance_Timing` SET `DesignationID`=:DesignationID,`StartTime`=:StartTime,
                `EndTime`=:EndTime,`StaffID`=:StaffID,`AttendanceModeID`=:AttendanceMode WHERE StaffAttendanceTimingID=:StaffAttendanceTimingID";
                $res8 = DBController::ExecuteSQL($query8, $param8);

                return array("return_code" => true, "return_data" => "Sucessfully Update Time");
            }
            //add new 

            else {

                $param1 = array(
                    array(":StaffID", $data['StaffId'])
                );

                $query3 = "SELECT `DesignationID` FROM `Staff` WHERE `StaffID`=:StaffID";
                $res3 = DBController::sendData($query3, $param1);

                $param9 = array(
                    array(":DesignationID", $res3['DesignationID']),
                    array(":StartTime", $data['startTime']),
                    array(":EndTime", $data['EndTime']),
                    array(":StaffID", $data['StaffId']),
                    array(":AttendanceMode", $data['attendanceMode']),
                    array(":StaffAttendanceTimingID", $data['StaffAttendanceTimingID'])
                );
                $query9 = "UPDATE `Staff_Attendance_Timing` SET `DesignationID`=:DesignationID,`StartTime`=:StartTime,
                `EndTime`=:EndTime,`StaffID`=:StaffID,`AttendanceModeID`=:AttendanceMode WHERE StaffAttendanceTimingID=:StaffAttendanceTimingID";
                $res9 = DBController::ExecuteSQL($query9, $param9);

                return array("return_code" => true, "return_data" => "Sucessfully Update Time");
            }   
        } else {
            //get the designatin First
            //add new data in staff Timing

            //get deisignation from staff

            $param1 = array(
                array(":StaffID", $data['StaffId'])
            );

            $query3 = "SELECT `DesignationID` FROM `Staff` WHERE `StaffID`=:StaffID";
            $res3 = DBController::sendData($query3, $param1);

            $param = array(
                array(":DesignationID", $res3['DesignationID']),
                array(":StartTime", $data['startTime']),
                array(":EndTime", $data['EndTime']),
                array(":StaffID", $data['StaffId']),
                array(":AttendanceMode", $data['attendanceMode'])
            );

            $query = "INSERT INTO `Staff_Attendance_Timing`(`DesignationID`, `StartTime`, `EndTime`, `StaffID`, `AttendanceModeID`) 
            VALUES (:DesignationID,:StartTime,:EndTime,:StaffID,:AttendanceMode)";
            $res = DBController::ExecuteSQL($query, $param);

            if ($res) {
                return array("return_code" => true, "return_data" => "Sucessfully Update Time");
            }
        }
    }

    /*  Info:
        Description: for getting the QR code for the particular office
                    -- Only admin will have access   
            24-01-2024 (Angelbert) : Adding the function 
    */

    //TODO
    function getAttendanceQRSheet()
    {
        if ($_SESSION["UserType"] != 1) {
            return array("return_code" => false, "return_data" => "Unable to access the requested data or you don't have access.");
        }

        $query = "SELECT * FROM Settings_School Limit 1";
        $school = DBController::sendData($query);
        if ($school && $school["QRCode"]) {
            return array("return_code" => true, "return_data" => "file?type=qr&name=" . $school["QRCode"]);
        } else
            return array("return_code" => false, "return_data" => "Unable to find the QR");
    }


    function getAllBreakOption()
    {
        $query="SELECT * from `Staff_Attendance_BreakOption` where isActive=1";
        $BreakOption=DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $BreakOption);
    }

}


?>