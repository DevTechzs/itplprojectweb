<?php

/*
    Current Version: 2.0.0
    Created By: Devkanta,     dev1@techz.in
    Created On: 25-01-2024
    Modified By:
    Modified On:
*/

namespace app\modules\staff\classes;
use app\database\DBController;

class InternAttendance
{

    /*  Info:
        Param : {AttendanceDate,StaffDesignationID}
        Description: get the Active staff based on designation and date  for attendance
            25-01-2024 (Devkanta) : Adding the function
    */
    public function getInternForAttendance($data)
    {
        $day = date_format(date_create($data["AttendanceDate"]), 'D');
        if ($day == "Sun") {
            return array("return_code" => false, "return_data" => "It is sunday");
        }

        $params = array(
            array(":InternCategoriesID",strip_tags($data["InternCategoriesID"])),
            array(":AttendanceDate", strip_tags($data["AttendanceDate"])),
        );
        $query ="SELECT si.StaffInternID,si.StaffInternName,ic.CategoryName,IFNULL(ia.StaffAttendanceID,-1) as InternAttendanceID,IFNULL(ia.Status,-1) as Status , IFNULL(ia.isBreakInOut,-1) as BreakInOut,  IFNULL(ia.AttendanceModeId,-1) as AttendanceModeId  FROM `staff_intern` si 
        INNER JOIN `intern_category` ic ON si.CategoryID = ic.InternCategoryID
        LEFT JOIN   `intern_attendance` ia ON si.StaffInternID = ia.InternID  and DATE_FORMAT(ia.AttendanceDate,'%Y/%m/%d') = DATE_FORMAT(:AttendanceDate,'%Y/%m/%d')
         where si.StaffInternID=:InternCategoriesID and si.isRemoved=0;";
        $res = DBController::getDataSet($query, $params);
        return array("return_code" => true, "return_data" => $res);
    }

    /*  Info:
        Param : {AttendanceDate,staffId,Status}
        Description: To Update/Add the intern attendance status
            25-01-2024 (Devkanta) : Adding the function
    */
    public function updateInternIndividualAttendance($data)
    {

        //check if already  mark attendance
        $params = array(
            array(":AttendanceDate", strip_tags($data["AttendanceDate"])), 
            array(":internId", strip_tags($data["internId"]))
        );
        $query="SELECT StaffAttendanceID from `Intern_Attendance` where 
        InternID=:internId and AttendanceDate=:AttendanceDate";
        $attendncedetails  = DBController::sendData($query, $params);
         

        if(!$attendncedetails) //if not available then insert 
         {
            //get IN time and out time of the staff and add here LAT IN and LAT out of the school, SessionID , AttendanceModeId
            $params = array(
                array(":AttendanceDate", strip_tags($data["AttendanceDate"])),
                array(":EntryBy", $_SESSION["UserID"]), 
                array(":internId", strip_tags($data["internId"])),
                array(":Status",strip_tags($data["Status"])),
                array(":SessionID",1), //we usually do not use this

            );
            $query="INSERT INTO `Intern_Attendance`(`AttendanceDate`, `StaffID`, `Status`, `EntryBy`,SessionID )
            VALUES (:AttendanceDate,:staffId,:Status,:EntryBy,:SessionID)";
            $res = DBController::ExecuteSQL($query, $params);
            return array("return_code" => true, "return_data" => "Successfully Marked !!");

         }
         else{  //otherwise update the status 
            $params = array(
                array(":AttendanceID", $attendncedetails["StaffAttendanceID"]),
                array(":internId", $data["internId"]),
                array(":Status", $data["Status"])
            );
            $query="UPDATE `Intern_Attendance` SET Status=:Status WHERE StaffAttendanceID=:AttendanceID and `InternID`=:internId;";
            $res = DBController::executeSQL($query, $params); 
            return array("return_code" => true, "return_data" => "Successfully updated !!");

         } 
    }

    /*  Info:
        Param : {AttendanceDate,Designation,AttendanceData[StaffID->integer,Status->Boolean]}
        Description: To Update/Add the staff attendance status
            25-01-2024 (Devkanta) : Adding the function
    */
    public function giveInternManualAttendance($data)
    {
        $data["AttendanceDate"] = date('Y-m-d', strtotime($data["AttendanceDate"]));
        $status = 0;
            for ($i = 0; $i < count($data["AttendanceData"]); $i++) {
            $params = array(
                array(":AttendanceDate", $data["AttendanceDate"]),
                array(":EntryBy", $_SESSION["UserID"]),
                array(":InternID", $data["AttendanceData"][$i]["InternID"]),
                array(":Status", $data["AttendanceData"][$i]["Status"]),
                array(":SessionID", 1), //we do not use this one for now

            );
            $query = "INSERT INTO `Intern_Attendance`(AttendanceDate,EntryBy,InternID,Status,SessionID) 
                    VALUES (:AttendanceDate,:EntryBy,:InternID,:Status,:SessionID);";
            $res = DBController::ExecuteSQL($query, $params);
            if ($res) {
                $status = $data["AttendanceData"][$i]["Status"];
            }
        }
        return array("return_code" => true, "return_data" => "Successfully Added");
    }

    function InternBreakInOut($data)
    {
        date_default_timezone_set('Asia/Kolkata');

       
        //update break in 
        if(isset($data['BreakInOut']) && $data['BreakInOut']==1 )
        {
            $BreakOutTime=date("h:i:sa");
            //update the break in for that staff
            //get the break in time first
            $param4=array(
                array(":StaffInternID",strip_tags($data['StaffInternID'])),
                array(":InternAttendanceID",strip_tags($data['InternAttendanceID']))
            );
            $query4="SELECT  `BreakInTime` FROM `Intern_Attendance_BreakInOut`
            WHERE `StaffInternID`=:StaffInternID  and `StaffAttendanceID`=:InternAttendanceID  and `BreakOutTime` is NULL";

            $BreakinTime=DBController::sendData($query4,$param4);
                $inTime=$BreakinTime['BreakInTime'];

            $time1 = strtotime($inTime);
            $time2 = strtotime($BreakOutTime);
            $Duration = ($time2-$time1)/60;
            // echo 'Minutes:'.$Duration;

            // $Duration=($BreakOutTime-$inTime);

            $param=array(
                array(":StaffInternID",strip_tags($data['StaffInternID'])),
                array(":StaffAttendanceID",strip_tags($data['InternAttendanceID'])),
                array(":BreakOutTime",$BreakOutTime),
                array(":Duration",$Duration),
                array(":UpdatedBy",$_SESSION["UserID"])
            );
            $query="UPDATE `Intern_Attendance_BreakInOut` SET `BreakOutTime`=:BreakOutTime,`Duration`=:Duration,`UpdatedByID`=:UpdatedBy
            WHERE `StaffAttendanceID`=:StaffAttendanceID and `StaffInternID`=:StaffInternID";
            $StaffBreakInoutUpdateRes=DBController::ExecuteSQL($query,$param);
            if($StaffBreakInoutUpdateRes)
            {
                //set the isBreakInOut to 0 (Staff back to work)
                $param3=array(
                    array(":StaffAttendanceID",strip_tags($data['InternAttendanceID'])),
                    array(":StaffInternID",strip_tags($data['StaffInternID']))
                );
                //update in intern attendance also
                $query3="UPDATE `Intern_Attendance` SET `isBreakInOut`=0
                WHERE `StaffAttendanceID`=:StaffAttendanceID and `StaffID`=:StaffId;";
                $res=DBController::ExecuteSQL($query3,$param3);
                if($res)
                {
                    return array("return_code" => true, "return_data" => "End of Break");  
                }

            }
        }
        //add new Break in 
        else
        {
            $EntryTime=date("h:i:sa");  
            $param=array(
                array(":BreakOption",strip_tags($data['BreakOption'])),
                array(":StaffInternID",strip_tags($data['StaffInternID'])),
                array(":StaffAttendanceID",strip_tags($data['InternAttendanceID'])),
                array(":BreakInTime",$EntryTime),
                array(":CreatedBy",$_SESSION["UserID"])
            );
            $query="INSERT INTO `Intern_Attendance_BreakInOut`(`BreakOptionID`, `StaffInternID`, `StaffAttendanceID`, `BreakInTime`,  `CreatedByID`)
            VALUES (:BreakOption,:StaffInternID,:StaffAttendanceID,:BreakInTime,:CreatedBy)";
            $BreakinOutRes=DBController::ExecuteSQL($query,$param);
            if($BreakinOutRes)
            {
                //update in staff attendance also so that we will know that staff on that day is on break
                $param1=array(
                    array(":StaffAttendanceID",strip_tags($data['InternAttendanceID'])),
                    array(":InternID",strip_tags($data['StaffInternID']))
                );
                $query1="UPDATE `Intern_Attendance` SET `isBreakInOut`=1  WHERE `StaffAttendanceID`=:StaffAttendanceID and `InternID`=:InternID";
                $updateStaffBreakinOutTime=DBController::ExecuteSQL($query1,$param1);
                if($updateStaffBreakinOutTime)
                {
                    return array("return_code" => true, "return_data" => "Taking a Break");  
                }
            }
        }

    }

}

?>