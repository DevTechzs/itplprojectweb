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

class StaffAttendance
{

    /*  Info:
        Param : {AttendanceDate,StaffDesignationID}
        Description: get the Active staff based on designation and date  for attendance
            24-01-2024 (Angelbert Riahtam) : Adding the function
    */
    public function getStaffForAttendance($data)
    {
        $day = date_format(date_create($data["AttendanceDate"]), 'D');
        if ($day == "Sun") {
            return array("return_code" => false, "return_data" => "It is sunday");
        }

        $params = array(
            array(":StaffDesignationID",strip_tags($data["StaffDesignationID"])),
            array(":AttendanceDate", strip_tags($data["AttendanceDate"])),
        );

        $query = "SELECT d.DesignationID,d.DesignationName,s.StaffName,s.StaffID,IFNULL(sat.StaffAttendanceID,-1) as StaffAttendanceID,IFNULL(sat.Status,-1) as Status , IFNULL(sat.isBreakInOut,-1) as BreakInOut ,  IFNULL(sat.AttendanceModeId,-1) as AttendanceModeId 
        from Staff s
        INNER JOIN `Designation` d on s.DesignationID=d.DesignationID
        LEFT JOIN Staff_Attendance  sat on sat.StaffID=s.StaffID and DATE_FORMAT(sat.AttendanceDate,'%Y/%m/%d') = DATE_FORMAT(:AttendanceDate,'%Y/%m/%d')
        where s.DesignationID=:StaffDesignationID and s.isRemoved=0;";
        $res = DBController::getDataSet($query, $params);
        return array("return_code" => true, "return_data" => $res);
    }

    /*  Info:
        Param : {AttendanceDate,Designation,staffId,Status}
        Description: To Update/Add the staff attendance status
            24-01-2024 (Angelbert Riahtam) : Adding the function
    */
    public function updateIndividualAttendance($data)
    {

        //check if already  mark attendance
        $params = array(
            array(":AttendanceDate", strip_tags($data["AttendanceDate"])), 
            array(":staffId", strip_tags($data["staffId"]))
        );
        $query="SELECT StaffAttendanceID from Staff_Attendance where 
        StaffID=:staffId and AttendanceDate=:AttendanceDate";
        $attendncedetails  = DBController::sendData($query, $params);
         

        if(!$attendncedetails) //if not available then insert 
         {
            //get IN time and out time of the staff and add here LAT IN and LAT out of the school, SessionID , AttendanceModeId
            $params = array(
                array(":AttendanceDate", strip_tags($data["AttendanceDate"])),
                array(":EntryBy", $_SESSION["UserID"]), 
                array(":staffId", strip_tags($data["staffId"])),
                array(":Status",strip_tags($data["Status"])),
                array(":SessionID",1), //we usually do not use this

            );
            $query="INSERT INTO `Staff_Attendance`(`AttendanceDate`, `StaffID`, `Status`, `EntryBy`,SessionID )
            VALUES (:AttendanceDate,:staffId,:Status,:EntryBy,:SessionID)";
            $res = DBController::ExecuteSQL($query, $params);
            return array("return_code" => true, "return_data" => "Successfully Marked !!");

         }
         else{  //otherwise update the status 
            $params = array(
                array(":AttendanceID", $attendncedetails["StaffAttendanceID"]),
                array(":staffId", $data["staffId"]),
                array(":Status", $data["Status"])
            );
            $query="UPDATE Staff_Attendance SET Status=:Status WHERE StaffAttendanceID=:AttendanceID and `StaffID`=:staffId;";
            $res = DBController::executeSQL($query, $params); 
            return array("return_code" => true, "return_data" => "Successfully updated !!");

         } 
    }

    /*  Info:
        Param : {AttendanceDate,Designation,AttendanceData[StaffID->integer,Status->Boolean]}
        Description: To Update/Add the staff attendance status
            24-01-2024 (Angelbert Riahtam) : Adding the function
    */
    public function giveManualAttendance($data)
    {
        date_default_timezone_set('Asia/Kolkata');
        $data["AttendanceDate"] = date('Y-m-d', strtotime($data["AttendanceDate"]));
        $status = 0;
        for ($i = 0; $i < count($data["AttendanceData"]); $i++) {
            if($data["AttendanceData"][$i]["Status"]==0)
            {
                $EntryTime=null;
            }
            else{
                $EntryTime=date("h:i:sa");
            }
            $params = array( 
                array(":AttendanceDate", $data["AttendanceDate"]),
                array(":EntryTime",$EntryTime),
                array(":EntryBy", $_SESSION["UserID"]),
                array(":StaffID", $data["AttendanceData"][$i]["StaffID"]),
                array(":Status", $data["AttendanceData"][$i]["Status"]),
                array(":SessionID", 1), //we do not use this one for now

            );
            $query = "INSERT INTO Staff_Attendance(AttendanceDate,StaffIn,EntryBy,StaffID,Status,SessionID) 
                    VALUES (:AttendanceDate,:EntryTime,:EntryBy,:StaffID,:Status,:SessionID);";
            $res = DBController::ExecuteSQL($query, $params);
            if ($res) {
                $status = $data["AttendanceData"][$i]["Status"];
            }
        }
        return array("return_code" => true, "return_data" => "Successfully Added");
    }


     /*  Info:
        Param : {StaffAttendanceID,StaffID}
        Description: To Logout the attendance for Today Attendance
            26-01-2024 (Angelbert Riahtam) : Adding the function
    */
    function  SignOutUserForToday($data)
    {
        //check if already marked
        if(isset($data['StaffAttendanceID']))
        {
            //logout user for today
            $param=array(
                array(":StaffID",strip_tags($data['StaffID'])),
                array(":StaffAttendanceID",strip_tags($data['StaffAttendanceID']))
            );
            $query="UPDATE `Staff_Attendance` SET `StaffOut`=CURTIME() WHERE `StaffAttendanceID`=:StaffAttendanceID and `StaffID`=:StaffID";
            $checkOutUser=DBController::ExecuteSQL($query,$param);
            if($checkOutUser)
            {
                return array("return_code" => true, "return_data" => "Successfully Checkout");
            }
            else{
                return array("return_code" => false, "return_data" => "An Error occur while checking out");
            }
        }
        else
        {
            return array("return_code" => false, "return_data" => "Invalid User data");
        }
    }


     /*  Info:
        BreakIn Param : {BreakOption,StaffAttendanceID,StaffID} 
        BreakOut Param : { StaffAttendanceID,StaffID,BreakInOut}
        Description: To Keep track of staff Breakin  and out
            27-01-2024 (Angelbert Riahtam) : Adding the function
    */

    function StaffBreakInOut($data)
    {
        date_default_timezone_set('Asia/Kolkata');

       
        //update break in 
        if(isset($data['BreakInOut']) && $data['BreakInOut']==1 )
        {
            $BreakOutTime=date("h:i:sa");
            //update the break in for that staff
            //get the break in time first
            $param4=array(
                array(":StaffId",strip_tags($data['StaffID'])),
                array(":StaffAttendanceID",strip_tags($data['StaffAttendanceID']))
            );
            $query4="SELECT  `BreakInTime` FROM `Staff_Attendance_BreakInOut`
            WHERE `StaffID`=:StaffId  and `StaffAttendanceID`=:StaffAttendanceID  and `BreakOutTime` is NULL";

            $BreakinTime=DBController::sendData($query4,$param4);
                $inTime=$BreakinTime['BreakInTime'];

            $time1 = strtotime($inTime);
            $time2 = strtotime($BreakOutTime);
            $Duration = ($time2-$time1)/60;
            // echo 'Minutes:'.$Duration;

            // $Duration=($BreakOutTime-$inTime);

            $param=array(
                array(":StaffId",strip_tags($data['StaffID'])),
                array(":StaffAttendanceID",strip_tags($data['StaffAttendanceID'])),
                array(":BreakOutTime",$BreakOutTime),
                array(":Duration",$Duration),
                array(":UpdatedBy",$_SESSION["UserID"])
            );
            $query="UPDATE `Staff_Attendance_BreakInOut` SET `BreakOutTime`=:BreakOutTime,`Duration`=:Duration,`UpdatedByID`=:UpdatedBy
            WHERE `StaffAttendanceID`=:StaffAttendanceID and `StaffID`=:StaffId";
            $StaffBreakInoutUpdateRes=DBController::ExecuteSQL($query,$param);
            if($StaffBreakInoutUpdateRes)
            {
                //set the isBreakInOut to 0 (Staff back to work)
                $param3=array(
                    array(":StaffAttendanceID",strip_tags($data['StaffAttendanceID'])),
                    array(":StaffId",strip_tags($data['StaffID']))
                );
                //update in staff attendance also
                $query3="UPDATE `Staff_Attendance` SET `isBreakInOut`=0
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
                array(":StaffId",strip_tags($data['StaffID'])),
                array(":StaffAttendanceID",strip_tags($data['StaffAttendanceID'])),
                array(":BreakInTime",$EntryTime),
                array(":CreatedBy",$_SESSION["UserID"])
            );
            $query="INSERT INTO `Staff_Attendance_BreakInOut`(`BreakOptionID`, `StaffID`, `StaffAttendanceID`, `BreakInTime`,  `CreatedByID`)
            VALUES (:BreakOption,:StaffId,:StaffAttendanceID,:BreakInTime,:CreatedBy)";
            $BreakinOutRes=DBController::ExecuteSQL($query,$param);
            if($BreakinOutRes)
            {
                //update in staff attendance also so that we will know that staff on that day is on break
                $param1=array(
                    array(":StaffAttendanceID",strip_tags($data['StaffAttendanceID'])),
                    array(":StaffID",strip_tags($data['StaffID']))
                );
                $query1="UPDATE `Staff_Attendance` SET `isBreakInOut`=1  WHERE `StaffAttendanceID`=:StaffAttendanceID and `StaffID`=:StaffID";
                $updateStaffBreakinOutTime=DBController::ExecuteSQL($query1,$param1);
                if($updateStaffBreakinOutTime)
                {
                    return array("return_code" => true, "return_data" => "Taking a break");  
                }
            }
        }

    }
    // function StaffBreakInOut($data)
    // {
    //     //staff take a breakin
    //     date_default_timezone_set('Asia/Kolkata');
    //     $EntryTime=date("h:i:sa");  
    //     if($data['Status']==1)
    //     {
    //         // add new data
    //         $param=array(
    //             array(":StaffId",strip_tags($data['staffId'])),
    //             array(":StaffAttendanceID",strip_tags($data['AttendanceID'])),
    //             array(":BreakInTime",$EntryTime),
    //             array(":CreatedBy",$_SESSION["UserID"])
    //         );
    //         $query="INSERT INTO `Staff_Attendance_BreakInOut`(`StaffID`, `StaffAttendanceID`, `BreakInTime`,`CreatedByID`)
    //         VALUES (:StaffId,:StaffAttendanceID,:BreakInTime,:CreatedBy)";
    //         $BreakinOutRes=DBController::ExecuteSQL($query,$param);
    //         if($BreakinOutRes)
    //         {
    //             //update in staff attendance also
    //             $param1=array(
    //                 array(":StaffAttendanceID",strip_tags($data['AttendanceID'])),
    //                 array(":StaffId",strip_tags($data['staffId']))
    //             );
    //             $query1="UPDATE `Staff_Attendance` SET  `isBreakInOut`=1  WHERE `StaffAttendanceID`=:StaffAttendanceID and `StaffID`=:StaffId";
                
    //             return array("return_code" => true, "return_data" => "Taking a break"); 
    //         }

    //     }
    //     else{
    //         // break out
    //         date_default_timezone_set('Asia/Kolkata');
    //         $BreakOutTime=date("h:i:sa");
    //         //need to calculate from break in and breakOut
    //         // $mins = ($end - $start) / 60;
    //         // $duration=($BreakOutTime-$startTime);
    //         $duration=1;
    //         $param=array(
    //             array(":BreakOut",$BreakOutTime),
    //             array(":Duration",$duration), //set one for now
    //             array(":UpdatedByID",$_SESSION["UserID"]),
    //             array(":StaffAttendanceID",strip_tags($data['AttendanceID'])),
    //             array(":StaffId",strip_tags($data['staffId']))
    //         );
    //         $query="UPDATE `Staff_Attendance_BreakInOut` SET `BreakOutTime`=:BreakOut, `Duration`=:Duration, `UpdatedByID`=:UpdatedByID WHERE Date(`CreatedDateTime`)=CURDATE() and `StaffAttendanceID`=:StaffAttendanceID and `StaffID`=:StaffId";
    //         $BreakinOutRes=DBController::ExecuteSQL($query,$param);
    //         if( $BreakinOutRes)
    //         {
    //             //update in staff Attendance also
    //             $param1=array(
    //                 array(":StaffAttendanceID",strip_tags($data['AttendanceID'])),
    //                 array(":StaffId",strip_tags($data['staffId']))
    //             );
    //             $query1="UPDATE `Staff_Attendance` SET  `isBreakInOut`=0  WHERE `StaffAttendanceID`=:StaffAttendanceID and `StaffID`=:StaffId";
    //             $updateStaffTakeABreak=DBController::ExecuteSQL($query1,$param1);
    //             return array("return_code" => true, "return_data" => "Break Time End");
    //         }

    //         //update the 
    //     }

        

    // }

}

?>