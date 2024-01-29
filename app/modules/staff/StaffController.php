<?php


/* 
    Current Version: 1.0.0
    Created By: Devkanta,     dev1@techz.in
    Created On: 19/01/2024
    Modified By:
    Modified On: 

*/

namespace app\modules\staff;

use app\core\Controller;
use app\modules\staff\classes\Intern;
use app\modules\staff\classes\Staff;
use app\modules\staff\classes\StaffAttendance;
use app\modules\staff\classes\InternAttendance;
use app\modules\staff\classes\StaffAttendanceSettings;
use app\modules\staff\classes\InternAttendanceSettings;

class StaffController implements Controller
{
    public function Route($data)
    {
        $jsondata = $data["JSON"];

        switch ($data["Page_key"]) {

                //staff
            case "addStaff":
                return (new Staff())->addStaff($jsondata);

                //update all field (NOT USING FOR NOW)
            case "updateStaff":
                return (new Staff())->updateStaff($jsondata);

                //only one field
            case "updateStaffInfo":
                return (new Staff())->updateStaffInfo($jsondata);

            case 'getStaff':
                return (new Staff())->getStaff($jsondata);

            case "getStaffProfileData":
                return (new Staff())->getStaffProfileData($jsondata);

                //intern 
            case 'addIntern':
                return (new Intern())->addIntern($jsondata);

            case 'getInternList':
                return (new Intern())->getInternList($jsondata);  //added by Dev on 19/01/2024

            case 'deleteStaffIntern':
                return (new Intern())->deleteStaffIntern($jsondata);  //added by Dev on 22/01/2024 

            case 'getInternCategories':
                return (new Intern())->getInternCategories($jsondata);  //added by Dev on 23/01/2024

            case 'updateInternInfo':
                return (new Intern())->updateInternInfo($jsondata);  //added by Dev on 24/01/2024


                //Staff Attendance
            case "getStaffForAttendance":
                return (new StaffAttendance())->getStaffForAttendance($jsondata);

            case "updateIndividualAttendance":
                return (new StaffAttendance())->updateIndividualAttendance($jsondata);

            case "giveManualAttendance":
                return (new StaffAttendance())->giveManualAttendance($jsondata);

            case "SignOutUserForToday":
                return (new StaffAttendance())->SignOutUserForToday($jsondata);
            case "StaffBreakInOut":
                return (new StaffAttendance())->StaffBreakInOut($jsondata);

                // staff attendance settings
            case "getAttendanceMode":
                return (new StaffAttendanceSettings())->getAttendanceMode();

            case "getSettingTiming":
                return (new StaffAttendanceSettings())->getSettingTiming();

            case "getStaffTiming":
                return (new StaffAttendanceSettings())->getStaffTiming();

            case "saveStaffAttendanceTiming":
                return (new StaffAttendanceSettings())->saveStaffAttendanceTiming($jsondata);

            case "getAllBreakOption":
                return (new StaffAttendanceSettings())->getAllBreakOption($jsondata);

                //inter attendance
            case "getInternForAttendance":
                return (new InternAttendance())->getInternForAttendance($jsondata);

            case "giveInternManualAttendance":
                return (new InternAttendance())->giveInternManualAttendance($jsondata);

            case "InternBreakInOut":
                return (new InternAttendance())->InternBreakInOut($jsondata); //added by dev on 29/01/2024

            case "getInternTiming":
                return (new InternAttendanceSettings())->getInternTiming($jsondata);

            case "updateInternIndividualAttendance":
                return (new InternAttendance())->updateInternIndividualAttendance($jsondata);

            case "saveInternAttendanceTiming":
                return (new InternAttendanceSettings())->saveInternAttendanceTiming($jsondata);
        }
    }

    static function Views($page)
    {

        $viewpath = "../app/modules/staff/views/";

        switch ($page[1]) {

            case 'internList':
                load($viewpath . "intern/internlist.php");
                break;

            case 'InternAttendance':
                load($viewpath . "intern/attendance/attendance.php");
                break;

            case 'InternAttendanceSetting':
                load($viewpath . "intern/attendance/settings.php");
                break;


            case 'InternAttendanceReports':
                load($viewpath . "intern/attendance/InternAttendanceReports.php");
                break;


            case 'staffList':
                load($viewpath . "staff/staffList.php");
                break;

            case 'profile':
                load($viewpath . "staff/profile.php");
                break;


                //staff Attendance
            case "staffAttendance":
                load($viewpath . "staff/attendance/attendance.php");
                break;

            case "staffAttendanceSetting":
                load($viewpath . "staff/attendance/settings.php");
                break;

            case "staffAttendanceReports":
                load($viewpath . "staff/attendance/staffAttendanceReports.php");
                break;

                //QR code generate
            case "printqr":
                load($viewpath . "staff/attendance/printqr.php");
                break;



            default:
                // session_destroy();
                include '404.php';
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                break;
        }
    }
}
