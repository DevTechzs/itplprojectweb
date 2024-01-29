<?php


namespace app\modules\staff\classes;


use app\database\DBController;
use app\modules\settings\classes\Session;
use \app\database\Helper;
use app\modules\settings\classes\Log;
use app\misc\Sodium;
use app\misc\GenerateQR;

class StaffAttendance
{

    //mark attendance through QR   
    function markQRattendance($data)
    {

         //there is another function for staff attendance bottom markQRattendanceStaff() for the app 
        //see the feasibility and remove one.
        if (!isset($data["code"]) || !isset($data["data"])) {
            return array("retrun_code" => false, "return_data" => "Invalid parameter");
        }
        $params1 = array(
            array(":Code", $data["code"]),
            array(":Data", $data["data"]),
        );
        if (!isset($_SESSION['UserID']) || $_SESSION['UserType'] != 2) {
            return array("retrun_code" => false, "return_data" => "Invalid user");
        }


        $params2 = array(
            array(":UserID", $_SESSION['UserID']),
        );
        $query2 = "select UserID,UserType,StaffID, isActive from Users where UserID=:UserID";
        $res2 = DBController::sendData($query2, $params2);

        if ($res2) {
            if ($res2['isActive'] == false) {
                return array("retrun_code" => false, "return_data" => "Unauthorized User !!");
            }
            $params3 = array(
                array(":StaffID", $res2['StaffID']),
            );
            //check if attendance exist for this staff
            $query3 = "SELECT * FROM `Staff_Attendance` WHERE `StaffID`=:StaffID and AttendanceDate=CURDATE()";
            $res3 = DBController::sendData($query3, $params3);
            if ($res3) {
                $params4 = array(
                    array(":StaffID", $res2['StaffID']),
                );
                //check if the attendance IN entry is made or not
                $query4 = "SELECT `LatitudeIN`, `LongtitudeIN` FROM `Staff_Attendance` WHERE `StaffID`=:StaffID and `AttendanceDate`=CURDATE()";
                $res4 = DBController::sendData($query4, $params4);
                if ($res4) {   // check if entry out is made or not if not then update
                    $query6 = "SELECT `LatitudeOut`,`LongtitudeOut` FROM `Staff_Attendance` WHERE `StaffID`=:StaffID and `AttendanceDate`=CURDATE()";
                    $res6 = DBController::sendData($query6, $params4);
                    if ($res6) {
                        return array("retrun_code" => true, "return_data" => "Sucessfully Mark attendance for today");
                    } else {
                        $params5 = array(
                            array(":Latitudeout", $data['Latitudeout']),
                            array(":Latitudeout", $data['Latitudeout']),
                            array(":EntryBy", $data['EntryBy']),
                            array(":AcademicSessionID", $data['AcademicSessionID']),
                            array(":StaffID", $data['StaffID']),
                        );
                        //is half_day and is early_out need to be update later
                        //update entry out
                        $query5 = "UPDATE `Staff_Attendance` SET `LatitudeOut`=:Latitudeout,`LongtitudeOut`=:Longtitudeout,`StaffOut`=CURRENT_TIME(),`EntryBy`=:EntryBy,`SessionID`=:AcademicSessionID,`isHalfDay`=1,`isEarlyOut`=1 WHERE `StaffID`=:StaffID and AttendanceDate=CURDATE()";
                        $res5 = DBController::ExecuteSQL($query5, $params5);
                        Log::UserEvent(["Module" => "STAFF", "Details" => "Updating Staff Attendance"]);
                    }
                }

                //it Attendance-IN is made, then check if attendance out is made or not 
                //if not attendance out is null, then update attendance out 

                //return array("retrun_code" => false, "return_data" => "Attendance already Mark");
            } else {
                //enter new attendance 
                $params5 = array(
                    array(":SchoolId", $data['Schoolid']),
                    array(":StaffID", $data['StaffID']),
                    array(":AttendanceModeID", $data['AttendanceModeID']),
                    array(":LAtitudeIN", $data['LAtitudeIN']),
                    array(":LongtitudeIN", $data['LongtitudeIN']),
                    array(":RIFDCardno", $data['RIFDCardno']),
                    array(":LocationID", $data['LocationID']),
                    array(":EntryBy", $data['EntryBy']),
                    array(":AcademicSessionID", $data['AcademicSessionID']),
                );
                //0 for late entry and half day
                $query5 = "INSERT INTO `Staff_Attendance`(`SchoolID`, `AttendanceDate`, `StaffID`, `Status`, `isWorkFromHome`, `AttendanceModeId`, `LatitudeIN`, `LongtitudeIN`,`StaffIn`, `RFIDCardNo`, `LocationID`, `EntryBy`,`SessionID`, `IsLateIn`, `isHalfDay`)
                         VALUES (:SchoolID,CURDATE(),:StaffID,1,0,:AttendanceModeID,:LAtitudeIN,:LongtitudeIN,CURRENT_TIME(),:RIFDCardno,:LocationID,:EntryBy,:AcademicSessionID,0,0";
                $res5 = DBController::ExecuteSQL($query5, $params5);
                if ($res5) {
                    Log::UserEvent(["Module" => "STAFF", "Details" => "Sucessfully Added Staff Attendance"]);
                    return array("retrun_code" => true, "return_data" => "Sucessfully mark attendance");
                }
                return array("retrun_code" => false, "return_data" => "Some Error  Occurs");
            }
        } else {
            return array("retrun_code" => false, "return_data" => "Not a valid user");
        }
    }

    function deleteAcademicCalendar($data)
    {
        $params = array(
            array(":AcademicsCalendarID", $data["AcademicsCalendarID"]),
        );

        $query = "DELETE FROM `Academics_Calendar` where `AcademicsCalendarID`=:AcademicsCalendarID;";
        $res = DBController::ExecuteSQL($query, $params);
        Log::UserEvent(["Module" => "ACADEMIC", "Details" => "Deleting Academic Calendar"]);
        return array("retrun_code" => true, "return_data" => "Sucessfully Removed");
    }
  
    function savesTaffAttendanceSetting($data)
    {
        $params = array(
            array(":StaffId", $data["StaffId"]),
        );


        $query = "SELECT  `staffID` FROM `Staff_Attendance_Settings` where `staffID`=:StaffId";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            $params2 = array(
                array(":StaffId", $data["StaffId"]),
                array(":staffAttendanceSettingID", $data["staffAttendanceSettingID"]),
                array(":attendanceMode", $data["attendanceMode"]),
                array(":startTime", $data["startTime"]),
                array(":EndTime", $data["EndTime"]),
            );

            //update
            $query2 = "UPDATE `Staff_Attendance_Settings` SET `AttendanceModeID`=:attendanceMode,`StartTime`=:startTime,`EndTime`=:EndTime WHERE staffID=:StaffId  AND StaffAttendanceSettingID=:staffAttendanceSettingID";
            $res2 = DBController::executeSQL($query2, $params2);

            Log::UserEvent(["Module" => "STAFF", "Details" => "Updating Staff-Attendance-Setting", "UserID" => $data["StaffId"]]);
            //Log::UserEvent(["Module" => "STAFF", "Details" => "Update Staff-Attendance-Setting"]);

            return array("return_code" => true, "return_data" => $res2);
        } else {
            $params3 = array(
                array(":StaffId", $data["StaffId"]),
                // array(":staffAttendanceSettingID",$data["staffAttendanceSettingID"]),
                array(":attendanceMode", $data["attendanceMode"]),
                array(":startTime", $data["startTime"]),
                array(":EndTime", $data["EndTime"]),
            );
            //insert
            $query3 = "INSERT INTO `Staff_Attendance_Settings`(`AttendanceModeID`, `StartTime`, `EndTime`, `staffID`) VALUES (:attendanceMode,:startTime,:EndTime,:StaffId);";
            Log::UserEvent(["Module" => "STAFF", "Details" => "Adding new data for Staff-Attendance-Setting"]);
            $res3 = DBController::ExecuteSQL($query3, $params3);


            return array("return_code" => true, "return_data" => $res3);
        }
    }
    function SaveStaffSetting($data)
    {
        for ($i = 0; $i < count($data["StaffSetting"]); $i++) {
            $params = array(
                array(":StaffSettingID", $data["StaffSetting"][$i]["StaffSettingID"]),
                array(":AttendanceMode", $data["StaffSetting"][$i]["AttendanceMode"]),
            );
            $query = "UPDATE `Staff_Attendance_Settings` SET `AttendanceModeID`=:AttendanceMode WHERE `StaffAttendanceSettingID`=:StaffSettingID";
            $res = DBController::executeSQL($query, $params);
            Log::UserEvent(["Module" => "STAFF", "Details" => "Updating Staff Attendance Setting "]);
            return array("return_code" => true, "return_data" => $res);
        }
    }
    function getAttendanceMode()
    {
        $query = "SELECT `AttendanceModeID`, `AttendanceMode` FROM `Attendance_Mode`;";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }

    function StaffTiming($data)
    {
        for ($i = 0; $i < count($data["AttendanceData"]); $i++) {

            $params = array(
                array(":StaffAttendanceTimingID", $data["AttendanceData"][$i]["StaffAttendanceTiming"]),
                array(":StartTime", $data["AttendanceData"][$i]["StartTime"]),
                array(":EndTime", $data["AttendanceData"][$i]["EndTime"]),
            );
            $params1 = array(
                array(":StartTime", $data["AttendanceData"][$i]["StartTime"]),
                array(":EndTime", $data["AttendanceData"][$i]["EndTime"]),
                array(":DesignationID", $data["AttendanceData"][$i]["DesignationID"]),
            );

            $query1 = "UPDATE `Staff_Attendance_Settings` SET `StartTime`=:StartTime,`EndTime`=:EndTime WHERE `DesignationID`=:DesignationID;";
            $res1 = DBController::executeSQL($query1, $params1);

            Log::UserEvent(["Module" => "STAFF", "Details" => "Update Staff-Attendance-Setting"]);

            return array("return_code" => true, "return_data" => $res1);

            $query = "UPDATE `Staff_Attendance_Timing` SET `StartTime`=:StartTime,`EndTime`=:EndTime WHERE `StaffAttendanceTimingID`=:StaffAttendanceTimingID;";
            $res = DBController::executeSQL($query, $params);
            Log::UserEvent(["Module" => "STAFF", "Details" => "Update Staff-Attendance-Timing"]);
            return array("return_code" => true, "return_data" => $res);
        }
    }

    //Staff_Attendance_Timing
    function getStaffStartTimeEndtime($data)
    {
        $query = "SELECT d.DesignationID,d.DesignationName,sat.StartTime,sat.StaffAttendanceTimingID,sat.EndTime FROM `Designation` d 
                    LEFT JOIN Staff_Attendance_Timing sat on sat.DesignationID=d.DesignationID;";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }

    //Staff_Attendance_Setting
    function getStaffDesignationStartTimeEndtime($data)
    //DATE_FORMAT(SessionStartDateTime,"%r") AS Time
    {
        $query = "SELECT s.StaffID,s.StaffName,sas.`StaffAttendanceSettingID`,attm.AttendanceMode, sas.`AttendanceModeID`,DATE_FORMAT(sas.StartTime,'%r') as StartTime , DATE_FORMAT(sas.EndTime,'%r') as EndTime FROM `Staff_Attendance_Settings` sas
                    right join  Staff s on s.StaffID=sas.staffID
                    left join Attendance_Mode attm on attm.AttendanceModeID=sas.AttendanceModeID;";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }

    function getStaffDesignationTime($data)
    {
        $params = array(
            array(":Designation", $data["designation"]),
        );

        $query = "SELECT s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status FROM `Staff` s
                INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                INNER JOIN Designation d on d.DesignationID=s.DesignationID
                where s.DesignationID=:Designation;";

        $res = DBController::getDataSet($query, $params);
        // Log::UserEvent(["Module" => "STAFF", "Details" => "Getting Staff Attendance base on Designation"]);
        return array("return_code" => true, "return_data" => $res);
    }

    function getreportByDesignation($data)
    {
        $params = array(
            array(":Designation", $data["designation"]),
        );

        $query = "SELECT s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status FROM `Staff` s
                INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                INNER JOIN Designation d on d.DesignationID=s.DesignationID
                where s.DesignationID=:Designation;";

        $res = DBController::getDataSet($query, $params);
        // Log::UserEvent(["Module" => "STAFF", "Details" => "Getting Staff Attendance report by Designation"]);
        return array("return_code" => true, "return_data" => $res);
    }

    function getreportByYear($data)
    {
        $params = array(
            array(":attendanceyear", $data["attendanceYear"]),
        );

        $query = "SELECT s.`StaffID`,sum(case when Staff_Attendance.Status=1 then 1 else 0 END) AS Present,sum(case when Staff_Attendance.Status=0 then 1 else 0 END) AS 'Absent' ,sum(case when Staff_Attendance.Status=2 then 1 else 0 END) AS 'Onleave',count(Staff_Attendance.Status) AS 'All',
                s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName
                FROM `Staff_Attendance`
                INNER JOIN Staff s on Staff_Attendance.StaffID=s.StaffID
                INNER JOIN Designation d on d.DesignationID=s.DesignationID
                where Year(Staff_Attendance.AttendanceDate)=:attendanceyear
                group BY s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName;";

        $res = DBController::getDataSet($query, $params);
        // Log::UserEvent(["Module" => "STAFF", "Details" => "Getting Staff Attendance report by Year"]);
        if($res)
        {
            return array("return_code" => true, "return_data" => $res); 
        }
        else{
            return array("return_code" => false, "return_data" => "Data Not Available");
        }
    }
    function getreportBydate($data)
    {
        $params = array(

            array(":attendanceDate", $data["attendanceDate"]),
        );

        $query = "SELECT s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status,sat.EntryDateTime FROM `Staff` s
                INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                INNER JOIN Designation d on d.DesignationID=s.DesignationID
                where sat.AttendanceDate=:attendanceDate;";

        $res = DBController::getDataSet($query, $params);
        Log::UserEvent(["Module" => "STAFF", "Details" => "Getting Staff Attendance report by Date"]);
        if($res)
        {
            return array("return_code" => true, "return_data" => $res);
        }
        else{
            return array("return_code" => false, "return_data" => "Data Not Available");
        }
      
    }
    public function getTodayPresentStaff($data)
    {
        $query = "SELECT s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status FROM `Staff` s
                    INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                    INNER JOIN Designation d on d.DesignationID=s.DesignationID
                    where sat.AttendanceDate=CURDATE() and sat.Status=1;";
        $res = DBController::getDataSet($query);
        //Log::UserEvent(["Module" => "STAFF", "Details" => "Getting Today Present Staff"]);
        return array("return_code" => true, "return_data" => $res);
    }
    public function getTodayAbsentStaff($data)
    {
        $query = "SELECT s.StaffID,s.StaffName,s.ContactNo,s.DepartmentID,s.DesignationID,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status FROM `Staff` s
                    INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                    INNER JOIN Designation d on d.DesignationID=s.DesignationID
                    where sat.AttendanceDate=CURDATE() and sat.Status=0;";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }

    public function getYesterdayAttendanceReport($data)
    {
        $query = "SELECT s.StaffID,s.StaffName,s.ContactNo,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status FROM `Staff` s
                    INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                    INNER JOIN Designation d on d.DesignationID=s.DesignationID
                    where sat.AttendanceDate=DATE_ADD(CURDATE(),INTERVAL -1 DAY)";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }


    public function getTodayAttendanceReport($data)
    {
        $query = "SELECT s.StaffID,s.StaffName,s.ContactNo,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status FROM `Staff` s
                    INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                    INNER JOIN Designation d on d.DesignationID=s.DesignationID
                    where sat.AttendanceDate=CURDATE();";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }

    public function giveManualAttendance($data)
    {
        $data["AttendanceDate"] = date('Y-m-d', strtotime($data["AttendanceDate"]));
        $status = 0;
        for ($i = 0; $i < count($data["AttendanceData"]); $i++) {
            $params = array(
                array(":AttendanceDate", $data["AttendanceDate"]),
                array(":EntryBy", $_SESSION["UserID"]),
                 array(":StaffID", $data["AttendanceData"][$i]["StaffID"]),
                array(":Status", $data["AttendanceData"][$i]["Status"]),
                array(":SessionID", $_SESSION["AcademicsSessionID"]),

            );
            $query = "INSERT INTO Staff_Attendance(AttendanceDate,EntryBy,StaffID,Status,SessionID) 
                    VALUES (:AttendanceDate,:EntryBy,:StaffID,:Status,:SessionID);";
            $res = DBController::ExecuteSQL($query, $params);
            if ($res) {
                $status = $data["AttendanceData"][$i]["Status"];
            }
        }
        //Log::UserEvent(["Module" => "STAFF", "Details" => "Gave Manual Attendance To Staff"]);
        return array("return_code" => true, "return_data" => "Successfully Added");
    }

    public function getDesignation($data)
    {
        $query = "SELECT DesignationID,DesignationName FROM `Designation`;";

        $res = DBController::getDataSet($query);
        if ($res)
            return array("return_code" => true, "return_data" => $res);

        return array("return_code" => false, "return_data" => "unable to get");
    }

    /*  Info:
        Param : {AttendanceDate,StaffDesignationID}
        Description: get all the staff for attendance
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
        $query = "SELECT d.DesignationID,d.DesignationName,s.StaffName,s.StaffID,IFNULL(sat.StaffAttendanceID,-1) as StaffAttendanceID,IFNULL(sat.Status,-1) as Status ,  IFNULL(sat.AttendanceModeId,-1) as AttendanceModeId 
        from Staff s
        INNER JOIN `Designation` d on s.DesignationID=d.DesignationID
        LEFT JOIN Staff_Attendance  sat on sat.StaffID=s.StaffID and DATE_FORMAT(sat.AttendanceDate,'%Y/%m/%d') = DATE_FORMAT(:AttendanceDate,'%Y/%m/%d')
        where s.DesignationID=:StaffDesignationID;";
        $res = DBController::getDataSet($query, $params);
        return array("return_code" => true, "return_data" => $res);
    }

    public function updateIndividualAttendance($data)
    {

         $params = array(
            array(":AttendanceDate", $data["AttendanceDate"]), 
            array(":staffId", $data["staffId"])
         );
         $query="SELECT StaffAttendanceID from Staff_Attendance where 
         StaffID=:staffId and AttendanceDate=:AttendanceDate";
        //either attendance avaible or not
        $attendncedetails  = DBController::sendData($query, $params);
         

        if(!$attendncedetails) //if not available then insert 
         {

            //get IN time and out time of the staff and add here LAT IN and LAT out of the school, SessionID , AttendanceModeId


            $params = array(
                array(":AttendanceDate", $data["AttendanceDate"]),
                array(":EntryBy", $_SESSION["UserID"]), 
                array(":staffId", $data["staffId"]),
                array(":Status",$data["Status"]),
               array(":SessionID",$_SESSION["AcademicsSessionID"]),

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

    function getreportByMonth($data)
    {

        $params = array(
            array(":Month", $data["Month"]),
        );

        $query = "SELECT s.`StaffID`,sum(case when Staff_Attendance.Status=1 then 1 else 0 END) AS Present,sum(case when Staff_Attendance.Status=0 then 1 else 0 END) AS 'Absent' ,sum(case when Staff_Attendance.Status=2 then 1 else 0 END) AS 'Onleave',count(Staff_Attendance.Status) AS 'All',
        s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName
        FROM `Staff_Attendance`
        INNER JOIN Staff s on Staff_Attendance.StaffID=s.StaffID
        INNER JOIN Designation d on d.DesignationID=s.DesignationID
        where Month(Staff_Attendance.AttendanceDate)=:Month
        group BY s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName;";
        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        }
    }
    function getreportByStaff($data)
    {
        $params = array(
            array(":StaffID", $data["StaffID"]),
        );


        $query = " SELECT s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName,sat.AttendanceDate,sat.Status,sat.EntryDateTime,
                sat.LatitudeIN,sat.LatitudeOut,sat.LongtitudeIN,sat.LongtitudeOut FROM `Staff` s
                INNER JOIN Staff_Attendance sat on sat.StaffID=s.StaffID
                INNER JOIN Designation d on d.DesignationID=s.DesignationID
                where s.StaffID=:StaffID;";

        $res = DBController::getDataSet($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        }
    }

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

    function generateAttendanceQRSheet()
    {

        $query = "SELECT * FROM Settings_School Limit 1";
        $school = DBController::sendData($query);
        $name = uniqid("s", true);
        $qrdata = json_encode(array("QRCODE" => $name, "CreationDate" => md5(date("Y-m-d H:i:s"))));
        $data = Sodium::safeEncrypt($qrdata);
        $data = json_encode(array("schoolcode" => $school["SchoolID"], "locationcode" => 109, "DATA" => $data));
        //for local
        // $logo= "http://$_SERVER[HTTP_HOST]/prayagedu/public/"."file?type=SchoolLogo&name=".$school["Logo"]; //to be changed for live site
        //for live
        $logo = "https://$_SERVER[HTTP_HOST]/" . "file?type=SchoolLogo&name=" . $school["Logo"]; //to be changed for live site

        $output =  "../app/data/qr"; //to be changed for live site
        if (!file_exists($output)) {
            mkdir($output, 0755, true);
        }
        GenerateQR::generate($name, $data, 500, $output, $logo);

        $params = array(
            array(":qrname", $name . ".png"),
            array(":qrdata", $qrdata),
            array(":SchoolID",  $school["SchoolID"])
        );

        $query = "UPDATE Settings_School SET QRCode=:qrname, QRData=:qrdata WHERE SchoolID=:SchoolID";
        $array = DBController::ExecuteSQL($query, $params);

        // try {
        unlink($output . "/" . $school["QRCode"]);
        // } catch (Exception $e) {
        //throw $th;
        // }
        return array("return_code" => true, "return_data" => "Successfull Created. Loading...");
    }




    public function getAttendanceMonthWise($data)
    {
        //get the staffID
        $staffdata = (new Staff())->getStaffDataByUserID([]);
        if ($staffdata["return_code"] == true) {
            $staffdata = $staffdata["return_data"];
        } else {
            return array("return_code" => false, "return_data" => "Not a valid Staff");
        }
        $params = array(
            array(":StaffID",  $staffdata["StaffID"]),
            array(":Month", $data["month"]),
            array(":Year", $data["year"]),
        );
        $sq = "SELECT AttendanceDate, Status, (case when IFNULL(StaffOut,0) =0 THEN 1 ELSE 0 END) isCurrentlyWorking FROM `Staff_Attendance` where Month(AttendanceDate)=:Month AND Year(AttendanceDate)=:Year and StaffID=:StaffID";
        $sq2 = "SELECT SUM(case when Status =1 then 1 else 0 END) as 'Present',   SUM(case when Status =0 then 1 else 0 END) as 'Absent', SUM(case when Status =2 then 1 else 0 END) as 'Leave'  FROM `Staff_Attendance`  where Month(AttendanceDate)=:Month AND Year(AttendanceDate)=:Year and StaffID=:StaffID  ";
        $attendancedatewise = DBController::getDataSet($sq, $params);
        $attendancesummary = DBController::sendData($sq2, $params);
        return array("return_code" => true, "return_data" => $attendancedatewise, "attendance_summary" =>  $attendancesummary);
    }


    public function getAttendanceByUserID($data)
    {
        //get the staffID
        $staffdata = (new Staff())->getStaffDataByUserID([]);
        if ($staffdata["return_code"] == true) {
            $staffdata = $staffdata["return_data"];
        } else {
            return array("return_code" => false, "return_data" => "Not a valid Staff");
        }
        $params = array(
            array(":StaffID",  $staffdata["StaffID"])
        );
        $sq = "SELECT AttendanceDate, Status, (case when IFNULL(StaffOut,0) =0 THEN 1 ELSE 0 END) isCurrentlyWorking FROM `Staff_Attendance` where StaffID=:StaffID";
        $attendancedatewise = DBController::getDataSet($sq, $params);
        return array("return_code" => true, "return_data" => $attendancedatewise);
    }
    public function markQRattendanceStaff($data)
    { 
        if (!isset($data['DATA'])) {
            return array("retrun_code" => false, "return_data" => "DATA parameter is not supplied");
        }

        // $params1=array(
        //     array(":Code",$data["schoolcode"]),
        //     array(":Data",$data["locationcode"])
        // );
        if (!isset($_SESSION['UserID']) || $_SESSION['UserType'] != 2) {
            return array("retrun_code" => false, "return_data" => "Invalid user");
        }

        // $param = array(
        //     array(":SchoolCode",$data["schoolcode"]),
        //     array(":QRData", Sodium::safeDecrypt($data['data']))
        // );

        // $query = "SELECT * FROM Settings_School WHERE SchoolID=:SchoolCode AND QRData=:QRData;";
        // $school = DBController::sendData($query, $param);

        // if ($school || isset($school["SchoolID"])) {
        if (true) {

            $params2 = array(
                array(":UserID", $_SESSION['UserID'])
            );
            $query2 = "select UserID,UserType,StaffID, isActive from Users where UserID=:UserID";
            $res2 = DBController::sendData($query2, $params2);
            if ($res2) {
                if ($res2['isActive'] == false) //user is inactive
                    return array("retrun_code" => false, "return_data" => " User is not Active");

                $params3 = array(
                    array(":StaffID", $res2['StaffID'])
                );
                //check if attendance exist for this staff
                $query3 = "SELECT * FROM `Staff_Attendance` WHERE `StaffID`=:StaffID and AttendanceDate=CURDATE()";
                $res3 = DBController::sendData($query3, $params3);
                if ($res3) {
                    //check if the in out entry is made or not 
                    if ($res3["StaffOut"] == null) {
                        //not existed till now 
                        $params5 = array(
                            array(":StaffAttendanceID", $res3['StaffAttendanceID']),
                            array(":LatitudeOut", $data['lat']),
                            array(":LongtitudeOut", $data['long']),
                            array(":StaffID", $res2['StaffID'])
                        );
                        //is half_day and is early_out need to be update later
                        //update entry out
                        $query5 = "UPDATE `Staff_Attendance` SET `LatitudeOut`=:LatitudeOut,`LongtitudeOut`=:LongtitudeOut,`StaffOut`=CURRENT_TIME(), `isHalfDay`=0,`isEarlyOut`=0 WHERE `StaffID`=:StaffID and StaffAttendanceID=:StaffAttendanceID";
                        $res5 = DBController::ExecuteSQL($query5, $params5);
                        if ($res5) {
                            return array("retrun_code" => true, "return_data" => "Sucessfully Logged out");
                        }
                        return array("retrun_code" => false, "return_data" => "Error while exit entry");
                    }
                    return array("retrun_code" => false, "return_data" => "Attendance IN & OUT completed for today.");

                    //it Attendance-IN is made, then check if attendance out is made or not 
                    //if not attendance out is null, then update attendance out 

                    //return array("retrun_code" => false, "return_data" => "Attendance already Mark");
                } else {
                    //enter new attendance 
                    $params5 = array(
                        array(":SchoolID", 1), //$data['schoolcode']
                        array(":StaffID", $res2['StaffID']),
                        array(":AttendanceModeID", $data['mode']), //1 manual, 2 QR, 3 RFID
                        array(":LatitudeIN", $data['lat']),
                        array(":LongtitudeIN", $data['long']),
                        array(":RIFDCardno", ''),
                        array(":LocationID", 1), //$data['locationcode']
                        array(":EntryBy", $_SESSION['UserID']),
                        array(":AcademicSessionID", $_SESSION['AcademicsSessionID'])
                    );
                    //0 for late entry and half day
                    $query5 = "INSERT INTO `Staff_Attendance`(`SchoolID`, `AttendanceDate`, `StaffID`, `Status`, `isWorkFromHome`, `AttendanceModeId`, `LatitudeIN`, `LongtitudeIN`,`StaffIn`, `RFIDCardNo`, `LocationID`, `EntryBy`,`SessionID`, `IsLateIn`, `isHalfDay`)
                     VALUES (:SchoolID,CURDATE(),:StaffID,1,0,:AttendanceModeID,:LatitudeIN,:LongtitudeIN,CURRENT_TIME(),:RIFDCardno,:LocationID,:EntryBy,:AcademicSessionID,0,0) ";
                    $res5 = DBController::ExecuteSQL($query5, $params5);
                    if ($res5) {
                        return array("retrun_code" => true, "return_data" => "Attendance Marked.");
                    }
                    return array("retrun_code" => false, "return_data" => "Error occured while registring attendance");
                }
            } else {
                return array("retrun_code" => false, "return_data" => "Not a valid user");
            }
        }
        return array("retrun_code" => false, "return_data" => "Not a valid Attendance QR");
    }
    function getTodayStaffAttendanceReport()
    {
        $query = "SELECT sa.AttendanceDate,sa.StaffIn,sa.StaffOut,sa.Status,s.StaffID,s.StaffName FROM `Staff_Attendance` sa
        inner join Staff s on s.StaffID=sa.StaffID
        where AttendanceDate=CURDATE();";
        $res = DBController::getDataSet($query);

        return array("return_code" => true, "return_data" => $res);
    }

    function getStaffAttendanceForChart()
    {

        //today
        //get chart of today Attendance
        //   $query1='SELECT if(Status=0, "Absent","Present") as status, count(StaffAttendanceID) as Total FROM `Staff_Attendance` where AttendanceDate=CURDATE() GROUP BY Status;';
        //    $query1="SELECT (SELECT count(*)  from Staff_Attendance where status=0 and  AttendanceDate=CURDATE() )  as TotalAbsent,
        //    (SELECT count(*)  from Staff_Attendance where status=1 and  AttendanceDate=CURDATE())  as TotalPresent
        //    from Staff_Attendance  where  AttendanceDate=CURDATE() limit 1;";

        $query1 = 'SELECT if(Status=0, "Absent","Present") as status, 
                    count(StaffAttendanceID) as Total 
                    FROM `Staff_Attendance` where AttendanceDate=CURDATE() GROUP BY Status;';

        $res1 = DBController::getDataSet($query1);

        //yesterday
        $query2 = 'SELECT if(Status=0, "Absent","Present") as status,count(StaffAttendanceID) as Total FROM `Staff_Attendance` where AttendanceDate=DATE_SUB(CURDATE(), INTERVAL 1 DAY)GROUP BY Status;';
        $res2 = DBController::getDataSet($query2);

        $data['TodayReport'] = $res1;
        $data['YesterdayReport'] = $res2;

        return array("return_code" => true, "return_data" => $data);
    }


    //get staffAttendance By month
    function getIndividualStaffAttendancebyMonth($data)
    {
        $param = array(
            array(":Month", $data['Month']),
            array(":StaffID", $data['StaffID'])
        );

        //get total present,absent,laeve
        /*$query="SELECT s.`StaffID`,sum(case when Staff_Attendance.Status=1 then 1 else 0 END) AS Present,sum(case when Staff_Attendance.Status=0 then 1 else 0 END) AS 'Absent' ,sum(case when Staff_Attendance.Status=2 then 1 else 0 END) AS 'Onleave',count(Staff_Attendance.Status) AS 'All',
            s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName
            FROM `Staff_Attendance`
            INNER JOIN Staff s on Staff_Attendance.StaffID=s.StaffID
            INNER JOIN Designation d on d.DesignationID=s.DesignationID
            where Month(Staff_Attendance.AttendanceDate)=1 and s.StaffID=9
            group BY s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName;";*/

        $query = "SELECT sa.AttendanceDate,sa.Status,sa.StaffIn,sa.StaffOut FROM `Staff_Attendance` sa where sa.StaffID=:StaffID and Month(sa.AttendanceDate)=:Month;";

        $res = DBController::getDataSet($query, $param);
        return array("return_code" => true, "return_data" => $res);
    }
    function getIndividualStaffAttendancebyYear($data)
    {
        $param = array(
            array(":Year", $data['Year']),
            array(":StaffID", $data['StaffID'])
        );

        $query = "SELECT s.`StaffID`,sum(case when Staff_Attendance.Status=1 then 1 else 0 END) AS Present,sum(case when Staff_Attendance.Status=0 then 1 else 0 END) AS 'Absent' ,sum(case when Staff_Attendance.Status=2 then 1 else 0 END) AS 'Onleave',count(Staff_Attendance.Status) AS 'All',
        MONTH(Staff_Attendance.AttendanceDate) AS Month
         FROM `Staff_Attendance`
         INNER JOIN Staff s on Staff_Attendance.StaffID=s.StaffID
         INNER JOIN Designation d on d.DesignationID=s.DesignationID
         where Year(Staff_Attendance.AttendanceDate)=:Year and  Staff_Attendance.StaffID=:StaffID
         GROUP BY s.StaffID,MONTH(Staff_Attendance.AttendanceDate);";

        $res = DBController::getDataSet($query, $param);

        return array("return_code" => true, "return_data" => $res);
    }

 

    function getSettingTiming()
    {
        $query = "SELECT sat.StaffAttendanceSettingID,sat.StartTime,sat.EndTime,Designation.DesignationID,Designation.DesignationName FROM `Staff_Attendance_Settings` sat
     RIGHT JOIN Designation on Designation.DesignationID=sat.DesignationID;";
        $res = DBController::getDataSet($query);
        return array("return_code" => true, "return_data" => $res);
    }

    function getStaffTiming()
    {

        $query = "SELECT sat.StaffAttendanceTimingID,sat.DesignationID,sat.StartTime,sat.EndTime,sat.AttendanceModeID,Staff.StaffID,Staff.StaffName,attendance_mode.AttendanceMode FROM `Staff_Attendance_Timing` sat LEFT JOIN Attendance_Mode on Attendance_Mode.AttendanceModeID=sat.AttendanceModeID RIGHT JOIN Staff on Staff.StaffID=sat.StaffID  order by sat.StaffAttendanceTimingID desc;";

        // $query="SELECT s.StaffID,s.StaffName,sas.StaffAttendanceTimingID,attm.AttendanceMode, sas.`AttendanceModeID`,DATE_FORMAT(sas.StartTime,'%r') as StartTime , DATE_FORMAT(sas.EndTime,'%r') as EndTime
        // FROM `Staff_Attendance_timing` sas
        // right join  Staff s on s.StaffID=sas.staffID
        // left join Attendance_mode attm on attm.AttendanceModeID=sas.AttendanceModeID;";

        $res = DBController::getDataSet($query);

        return array("return_code" => true, "return_data" => $res);
    }

    function UpdatesettingTiming($data)
    //  function StaffTiming($data) 
    {

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
                $query = "select DesignationID from  `Staff_Attendance_Timing`  WHERE `DesignationID`=:DesignationID";
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


    //get Staff Attendance report by month and designation
    function getreportByMonthDesignation($data)
    {
        //leave the session  for now because there no data 
        $param=array(  
            array(":Month",$data['Month']),
            array(":Designation",$data['Designation'])   
        );
        $query="SELECT s.`StaffID`,sum(case when Staff_Attendance.Status=1 then 1 else 0 END) AS Present,sum(case when Staff_Attendance.Status=0 then 1 else 0 END) AS 'Absent' ,sum(case when Staff_Attendance.Status=2 then 1 else 0 END) AS 'Onleave',count(Staff_Attendance.Status) AS 'All',
        s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName
        FROM `Staff_Attendance`
        INNER JOIN Staff s on Staff_Attendance.StaffID=s.StaffID
        INNER JOIN Designation d on d.DesignationID=s.DesignationID
        where Month(Staff_Attendance.AttendanceDate)=:Month and s.DesignationID=:Designation
        group BY s.StaffID,s.StaffName,s.ContactNo,s.DesignationID,s.DepartmentID,d.DesignationName;";
        $res=DBController::getDataSet($query,$param);
        if($res)
        {
            return array("return_code" => true, "return_data" => $res);  
        }
        else{
            return array("return_code" => false, "return_data" => "Data is not Available for this Month..");
        }
    }

    /*
        get the list of Staff CATEGORIES WISE who have not marked (beth/from app) 
        where the attendance given by staff is more than 50 %
    */
    function getStaffListNotMarkedAttendanceByPercent($data)
    {
        //date also we passs  in paramter 
        // get the % of staff present in tht day (Category Wise)

        // get the total staff Category Wise
        $param1=array(
            array(":Designation",$data['Designation'])
        );
        $query1="SELECT count(*) as TotalStaff FROM `Staff` where DesignationID=:Designation and isRemoved=0;";
        $TotalStaff=DBController::sendData($query1,$param1);

        //get the total Staff present in a day (Category Wise)
        $param=array(
            array(":Designation",$data['Designation']),
            array(":Date",$data['Date'])
        );
        $query="SELECT count(sa.StaffAttendanceID) as totalpresent 
        FROM `Staff_Attendance` sa
        INNER JOIN Staff s on s.StaffID=sa.StaffID
        INNER JOIN Designation d on d.DesignationID=s.DesignationID
        where   sa.Status=1 and d.DesignationID=:Designation and DATE(sa.AttendanceDate)=:Date;";
        $TotalPresentInaDay=DBController::sendData($query,$param);

        //calculate %
        $d=$TotalPresentInaDay['totalpresent']/$TotalStaff['TotalStaff'];
        $Percent=$d*100;

        //check if less than 50 then get the list of Absent Staff
        if($Percent>50)
        {
            $param3=array(
                array(":Designation",$data['Designation']),
                array(":Date",$data['Date']),
            );
            $query3="SELECT s.StaffID,s.StaffName,s.ContactNo,s.EmailID,s.DOB,s.Address,s.Photo,s.RFIDcardNo,s.isRemoved 
            FROM `Staff` s  
            WHERE NOT EXISTS 
                (SELECT sa.`StaffAttendanceID`, sa.`AttendanceDate`, sa.`StaffID`, sa.`Status`, sa.`AttendanceModeId`, sa.`StaffIn`,  sa.`RFIDCardNo`  
                FROM `Staff_Attendance` sa
                WHERE s.StaffID=sa.StaffID and  DATE(sa.AttendanceDate)='2023-01-14' and s.DesignationID=3);";

            $StaffList=DBController::getDataSet($query3,$param3);

            return array("return_code" => true, "return_data" => $StaffList);    
        }

        return array("return_code" => true, "return_data" => "No. of Present Data is less than 50%"); 
    }
}
