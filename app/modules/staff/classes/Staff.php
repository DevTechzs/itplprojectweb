<?php
 /* 
    Current Version: 1.0.0
    Created By: Angelbert,     prayagedu@techz.in
    Created On: 19/01/2024
    Modified By:
    Modified On:  
*/
namespace app\modules\staff\classes; 
use app\database\DBController;
use app\misc\FCM;
use app\misc\SMS;
use app\modules\settings\classes\Session;
use app\modules\auth\classes\Signup;

class Staff
{


    /*  Info:
        Description: get the basic information of  all the active staff
            11-01-2024 (Angelbert) :
    */
    public function getStaff($data)
    {
        $query="SELECT `StaffID`, `StaffName`, Staff.`StaffCode`, Staff.`ContactNo`, Staff.`EmailID`, Staff.`GenderCode`, `DOB`, Staff.ReligionID,Settings_Religion.Religion,Staff.CasteCode, Settings_Caste.Caste,Staff.CommunityID, Settings_Community.`CommunityName`, Staff.NationalityID,Settings_Nationality.NationalityName, Staff.`Address`, `Photo`, Staff.`DesignationID`, Staff.`DepartmentID`, Staff.`OfficeID`, `JoinedDate`, `BloodGroup`, `isPhotoUpdateEnable`, Staff.`isRemoved`,so.OfficeName,Designation.DesignationName FROM Staff
        INNER JOIN Designation ON Designation.DesignationID=Staff.DesignationID
        INNER JOIN Settings_Gender ON Settings_Gender.GenderCode=Staff.GenderCode 
        LEFT JOIN Settings_Caste ON Settings_Caste.CasteCode=Staff.CasteCode 
        LEFT JOIN Settings_Religion ON Settings_Religion.ReligionID=Staff.ReligionID 
        LEFT JOIN Settings_Community ON Settings_Community.CommunityID=Staff.CommunityID 
        LEFT JOIN Settings_Nationality on Settings_Nationality.NationalityID=Staff.NationalityID
        LEFT JOIN Settings_Office so on so.OfficeID=Staff.OfficeID
        WHERE Staff.isRemoved=0;";
        $res = DBController::getDataSet($query);
        if ($res)
            return array("return_code" => true, "return_data" => $res);

        return array("return_code" => false, "return_data" => "unable to get");
    }


    /*  Info: {StaffID,} Need To Update this function 
        Description: get the detail information of particular staff
            11-01-2024 (Angelbert) : adding the function
    */
    function getStaffProfileData($data)
    {
        $has_right = -1;
        $staff_id = -1;
        $user_id = -1;

        if (isset($data['StaffID']) && $data['StaffID'] != "-1") {
            $staff_id = $data['StaffID'];

            $q1 = "SELECT `UserID` FROM `Users` WHERE `StaffID`=:StaffID;";
            $p1 = array(array(":StaffID",  $staff_id ));
            $r1 = DBController::getDataSet($q1, $p1);

            if (isset($r1[0]['UserID'])) {
                $user_id = $r1[0]['UserID'];
            } else {
                return array("return_code" => false, "return_data" => "User not found !!");
            }
        } else {
            $q = "SELECT `StaffID` FROM `Users` WHERE `UserID`=:UserID;";
            $p = array(array(":UserID", $_SESSION['UserID']));
            $r = DBController::getDataSet($q, $p);

            if (isset($r[0]['StaffID'])) {
                $staff_id = $r[0]['StaffID'];
            } else {
                return array("return_code" => false, "return_data" => "Staff not found !!");
            }

            $user_id = $_SESSION['UserID'];
            $has_right = 1;
        }

        $prm = [
            [":StaffID", $staff_id]
        ];
        $prm1 = [
            [":UserID", $user_id]
        ];

        $qry1 = "SELECT `s`.`StaffID`,
                        `s`.`StaffName`,
                        `s`.`StaffCode`,
                        `s`.`ContactNo`,
                        `s`.`EmailID`,
                        `s`.`GenderCode`,
                        `gr`.`Gender`,
                        `s`.`DOB`,
                        DATE_FORMAT(`s`.`DOB`, '%D %M %Y') AS 'DOB0',
                        DATE_FORMAT(`s`.`DOB`, '%m/%d/%Y') AS 'DOB1',
                        TIMESTAMPDIFF(YEAR, `s`.`DOB`, NOW()) AS 'Age',
                        `s`.`ReligionID`,
                        `rn`.`Religion`,
                        `s`.`CasteCode`,
                        `ce`.`Caste`,
                        `s`.`CommunityID`,
                        `cy`.`CommunityName`,
                        `s`.`NationalityID`,
                        `ny`.`NationalityName`,
                        `s`.`Address`,
                        `s`.`Photo`,
                        `s`.`DesignationID`,
                        `dn`.`DesignationName`,
                        `s`.`DepartmentID`,
                        `dt`.`DepartmentName`,
                        `s`.`JoinedDate`,
                        DATE_FORMAT(`s`.`JoinedDate`, '%D %M %Y') AS 'JoinedDate0',
                        DATE_FORMAT(`s`.`JoinedDate`, '%m/%d/%Y') AS 'JoinedDate1',
                        TIMESTAMPDIFF(YEAR, `s`.`JoinedDate`, NOW()) AS 'YearOfExperience',
                        `s`.`BloodGroup`,
                        `s`.`RFIDcardNo`,
                        `s`.`isPhotoUpdateEnable`,
                        `s`.`isRemoved`,
                        `s`.`SessionID`
                    FROM `Staff` `s` 
                    LEFT JOIN `Settings_Gender` `gr` ON `s`.`GenderCode`=`gr`.`GenderCode` 
                    LEFT JOIN `Settings_Religion` `rn` ON `s`.`ReligionID`=`rn`.`ReligionID` 
                    LEFT JOIN `Settings_Caste` `ce` ON `s`.`CasteCode`=`ce`.`CasteCode` 
                    LEFT JOIN `Settings_Community` `cy` ON `s`.`CommunityID`=`cy`.`CommunityID` 
                    LEFT JOIN `Settings_Nationality` `ny` ON `s`.`NationalityID`=`ny`.`NationalityID` 
                    LEFT JOIN `Designation` `dn` ON `s`.`DesignationID`=`dn`.`DesignationID` 
                    LEFT JOIN `Settings_Department` `dt` ON `s`.`DepartmentID`=`dt`.`DepartmentID` 
                    LEFT JOIN `Settings_BloodGroups` `bs` ON `s`.`BloodGroup`=`bs`.`BloodGroup` 
                    WHERE `s`.`isRemoved`!='1' AND `s`.`StaffID`=:StaffID;";
        $res1 = DBController::getDataSet($qry1, $prm);

        $qry2 = "SELECT `g`.`GenderCode` AS 'Value', `g`.`Gender` AS 'Text', (CASE WHEN `g`.`GenderCode`=`s`.`GenderCode` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Settings_Gender` `g`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res2 = DBController::getDataSet($qry2, $prm);

        $qry3 = "SELECT `r`.`ReligionID` AS 'Value', `r`.`Religion` AS 'Text', (CASE WHEN `r`.`ReligionID`=`s`.`ReligionID` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Settings_Religion` `r`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res3 = DBController::getDataSet($qry3, $prm);

        $qry4 = "SELECT `c`.`CasteCode` AS 'Value', `c`.`Caste` AS 'Text', (CASE WHEN `c`.`CasteCode`=`s`.`CasteCode` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Settings_Caste` `c`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res4 = DBController::getDataSet($qry4, $prm);

        $qry5 = "SELECT `c`.`CommunityID` AS 'Value', `c`.`CommunityName` AS 'Text', (CASE WHEN `c`.`CommunityID`=`s`.`CommunityID` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Settings_Community` `c`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res5 = DBController::getDataSet($qry5, $prm);

        $qry6 = "SELECT `n`.`NationalityID` AS 'Value', `n`.`NationalityName` AS 'Text', (CASE WHEN `n`.`NationalityID`=`s`.`NationalityID` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Settings_Nationality` `n`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res6 = DBController::getDataSet($qry6, $prm);

        $qry7 = "SELECT `d`.`DesignationID` AS 'Value', `d`.`DesignationName` AS 'Text', (CASE WHEN `d`.`DesignationID`=`s`.`DesignationID` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Designation` `d`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res7 = DBController::getDataSet($qry7, $prm);

        $qry8 = "SELECT `d`.`DepartmentID` AS 'Value', `d`.`DepartmentName` AS 'Text', (CASE WHEN `d`.`DepartmentID`=`s`.`DepartmentID` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Settings_Department` `d`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res8 = DBController::getDataSet($qry8, $prm);

        $qry9 = "SELECT `b`.`BloodGroup` AS 'Value', `b`.`BloodGroup` AS 'Text', (CASE WHEN `b`.`BloodGroup`=`s`.`BloodGroup` THEN 'YES' ELSE 'NO' END) AS 'IsOptionSelected'
                    FROM `Settings_BloodGroups` `b`, `Staff` `s`
                    WHERE `s`.`StaffID`=:StaffID;";
        $res9 = DBController::getDataSet($qry9, $prm);

        $qry10 = "SELECT `WorkDetailID`, `Organisation`, `Designation`, DATE_FORMAT(`StartDate`, '%m/%d/%Y') AS 'StartDate', DATE_FORMAT(`StartDate`, '%D %M %Y') AS 'StartDate1', DATE_FORMAT(`EndDate`, '%m/%d/%Y') AS 'EndDate', DATE_FORMAT(`EndDate`, '%D %M %Y') AS 'EndDate1', `IsCurrentlyWorking` AS 'Status' 
                    FROM `Staff_WorkDetails` 
                    WHERE `StaffID`=:StaffID;";
        $res10 = DBController::getDataSet($qry10, $prm);

        $qry11 = "SELECT `InternalExternalBodyDetailID` AS 'ID', `Type`, `InternalExternalBodyName` AS 'Title', `Role`, DATE_FORMAT(`StartDate`, '%m/%d/%Y') AS 'StartDate', DATE_FORMAT(`StartDate`, '%D %M %Y') AS 'StartDate1', DATE_FORMAT(`EndDate`, '%m/%d/%Y') AS 'EndDate', DATE_FORMAT(`EndDate`, '%D %M %Y') AS 'EndDate1', `IsActive` AS 'Status' 
                    FROM `Staff_InternalExternalBodyDetails` 
                    WHERE `StaffID`=:StaffID;";
        $res11 = DBController::getDataSet($qry11, $prm);

        $qry12 = "SELECT `VehicleDetailsID`, `VehicleTypeID`, `VehicleBrand`, `VehicleModel`, `VehicleColor`, `VehicleNumber`, `IsVehicleOwner`, IFNULL(`VehicleOwnerName`, '') AS 'VehicleOwnerName', (CASE WHEN `VehicleTypeID`=1 THEN 'Light Motor Vehicle' WHEN `VehicleTypeID`=2 THEN 'Motorcycle' ELSE 'Scooter' END) AS 'VehicleType' 
                    FROM `VehicleDetails` 
                    WHERE `UserID`=:UserID;";
        $res12 = DBController::getDataSet($qry12, $prm1);

        $qry13 = "SELECT `q`.`QualificationTypeID` AS 'Value', `q`.`Qualification` AS 'Text', 'NO' AS 'IsOptionSelected'
                    FROM `Settings_QualificationTypes` `q` 
                    WHERE `q`.`QualificationTypeID`!='7';";
        $res13 = DBController::getDataSet($qry13);

        $qry14 = "SELECT `b`.`BoardID` AS 'Value', `b`.`BoardName` AS 'Text', 'NO' AS 'IsOptionSelected'
                    FROM `Settings_Board` `b`;";
        $res14 = DBController::getDataSet($qry14);

        $qry15 = "SELECT * FROM `Staff_QualificationDetails` `q`
                    LEFT JOIN `Settings_QualificationTypes` `t` ON `q`.`QualificationTypeID`=`t`.`QualificationTypeID`
                    LEFT JOIN `Settings_Board` `b` ON `q`.`BoardUniversityID`=`b`.`BoardID`
                    WHERE `q`.`StaffID`=:StaffID ORDER BY `q`.`YearOfPassing` DESC;";
        $res15 = DBController::getDataSet($qry15, $prm);

        $qry16 = "SELECT `RelationTypeID` AS 'Value', `RelationTitle` AS 'Text', 'NO' AS 'IsOptionSelected'
                    FROM `Settings_RelationTypes`;";
        $res16 = DBController::getDataSet($qry16);

        //we don't need this one
        // $qry17 = "SELECT `ClassSectionID` AS 'Value', `ClassSectionName` AS 'Text', 'NO' AS 'IsOptionSelected'
        //             FROM `Academics_ClassSection`;";
        // $res17 = DBController::getDataSet($qry17);

        $qry18 = "SELECT `u`.`UserID`, `s`.`StaffID`, `s`.`StaffName`, `s`.`DepartmentID` 
                    FROM `Staff` `s` 
                    INNER JOIN `Users` `u` ON `s`.`StaffID`=`u`.`StaffID`  ";
        $res18 = DBController::getDataSet($qry18);

        $qry19 = "SELECT `u`.`UserID`, `s`.`StudentID`, `s`.`StudentName`, `a`.`ClassSectionID` 
                    FROM `Academics_Info` `a` 
                    INNER JOIN `Student_Info` `s` ON `a`.`StudentID`=`s`.`StudentID` 
                    INNER JOIN `Users` `u` ON `s`.`StudentID`=`u`.`StudentID` 
                    WHERE `a`.`isAcademicSessionCompeted`='0'  ;";
        $res19 = DBController::getDataSet($qry19);

        $qry20 = "SELECT `r`.`RelationID`, `r`.`UserID`, `r`.`RelationTypeID`, `r`.`IsGuardian`, `t`.`RelationTitle`, `r`.`IsStayingTogether`, 
        IFNULL(`r`.`Address`, '') AS 'Address', `r`.`IsSchoolPassOut`, IFNULL(`r`.`PassOutYear`, '') AS 'PassOutYear', 
        IFNULL(`r`.`ClassSectionID`, '') AS 'PassOutClassSectionID', `r`.`IsSchoolStudentStaff`, `r`.`MemberUserID`, 
        (CASE WHEN `r`.`IsSchoolStudentStaff`='1' THEN (SELECT `StaffName` FROM `Staff` WHERE `StaffID`=(SELECT `StaffID` FROM `Users` WHERE `UserID`=`r`.`MemberUserID`)) WHEN `r`.`IsSchoolStudentStaff`='2' THEN (SELECT `StudentName` FROM `Student_Info` WHERE `StudentID`=(SELECT `StudentID` FROM `Users` WHERE `UserID`=`r`.`MemberUserID`)) ELSE `r`.`Name` END) AS 'Name', 
        (CASE WHEN `r`.`IsSchoolStudentStaff`='0' THEN `r`.`ContactNumber` ELSE (SELECT `ContactNo` FROM `Users` WHERE `UserID`=`r`.`MemberUserID`) END) AS 'ContactNumber', 
        `r`.`IsWorking`, 
        (CASE WHEN `r`.`IsSchoolStudentStaff`='0' THEN `r`.`OrganisationName` ELSE 'Same School' END) AS 'OrganisationName', IFNULL(`r`.`Designation`, '') AS 'Designation', IFNULL(`r`.`OrganisationAddress`, '') AS 'OrganisationAddress', `r`.`IsGuardian` 
                      FROM `StudentStaff_Relations` `r` 
                      INNER JOIN `Settings_RelationTypes` `t` ON `r`.`RelationTypeID`=`t`.`RelationTypeID`
                      WHERE `r`.`UserID`=:UserID;";
        $res20 = DBController::getDataSet($qry20, $prm1);

        $res['has_right'] = 1;  // $has_right;
        $res['personal_data'] = $res1;
        $res['gender_list'] = $res2;
        $res['religion_list'] = $res3;
        $res['caste_list'] = $res4;
        $res['community_list'] = $res5;
        $res['nationality_list'] = $res6;
        $res['designation_list'] = $res7;
        $res['department_list'] = $res8;
        $res['bloodgroups_list'] = $res9;
        $res['work_data'] = $res10;
        $res['iebody_data'] = $res11;
        $res['vehicle_data'] = $res12;
        $res['qualificationtype_list'] = $res13;
        $res['board_list'] = $res14;
        $res['qualification_data'] = $res15;
        $res['relationtype_list'] = $res16;
        // $res['classsection_list'] = $res17;
        $res['staff_list'] = $res18;
        $res['student_list'] = $res19;
        $res['familyrelative_data'] = $res20;

        return array("return_code" => true, "return_data" => $res);
    }

    //not using for now
    // public function getStaffDataByUserID($data)
    // {
    //     $param = array(
    //         array("UserID",$_SESSION["UserID"]),
    //     );
    //     $query = "SELECT Staff.Photo, Staff.StaffName, Designation.DesignationName,
    //     Staff.ContactNo, Staff.JoinedDate, Staff.DOB, Staff.BloodGroup, Staff.StaffID FROM Staff 
    //     INNER JOIN Designation ON Designation.DesignationID=Staff.DesignationID
    //     INNER JOIN Settings_Gender ON Settings_Gender.GenderCode=Staff.GenderCode 
    //     INNER JOIN Settings_Caste ON Settings_Caste.CasteCode=Staff.CasteCode 
    //     INNER JOIN Settings_Religion ON Settings_Religion.ReligionID=Staff.ReligionID 
    //     INNER JOIN Settings_Community ON Settings_Community.CommunityID=Staff.CommunityID 
    //     INNER JOIN Users ON Users.StaffID = Staff.StaffID 
    //     WHERE Users.UserID=:UserID";
    //     $res = DBController::sendData($query,$param);
    //     if ($res)
    //         return array("return_code" => true, "return_data" => $res);

    //     return array("return_code" => false, "return_data" => "unable to get");
    // }

    // TODO
    /*  Info:
        Description: Update the photo of staff {PassportPhoto,}
            19-01-2024 (Angelbert Riahtam)  Adding the funtion     
    */
    // function updateStaffPhoto($data)
    // {
 
    //     $user = (new Users())->getUser();
 
    //     if ($user["return_code"]){
    //         $user = $user["return_data"];
 
    //         $image_info = getimagesize($data["PassportPhoto"]);
    //         $PassportPhoto = uniqid("PP").".".(isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");
    //         file_put_contents("../app/data/temp/" . $PassportPhoto, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data["PassportPhoto"])));


    //         //get the old photo
    //         $params = array(
    //             array(":StaffID", $user["StaffID"])
    //         );
    //         $query = "SELECT  Photo FROM Staff  WHERE StaffID=:StaffID;";
    //         $photo = DBController::sendData($query, $params);

    //         $params = array(
    //             array(":Photo", $PassportPhoto),
    //             array(":StaffID", $user["StaffID"])
    //         );

    //         $query = "UPDATE Staff SET Photo=:Photo WHERE StaffID=:StaffID;";
    //         $res = DBController::ExecuteSQL($query, $params);


    //         if ($res){
    //             $directory="../app/data/PassportPhoto/";
    //             //create directory if does not exists
    //             if(!file_exists($directory)){
    //                 mkdir($directory, 0755, true);
    //             }
    //             rename("../app/data/temp/" . $PassportPhoto, $directory . pathinfo($PassportPhoto, PATHINFO_BASENAME));
    //              if($photo){
    //                 $photo=$directory . pathinfo($photo["Photo"], PATHINFO_BASENAME);
    //                 if (file_exists( $photo))
    //                     unlink($photo);
    //             }


    //             return array("return_code" => true, "return_data" => "file?type=PassportPhoto&name=".$PassportPhoto);
    //         }
    //     }
    //     return array("return_code" => false, "return_data" => "Could Not Update!!!");
    // } 

    /*  Info:
        Description: Add new Staff
            19-01-2024 (Angelbert Riahtam)      
    */
    public function addStaff($data)
    { 
        if (isset($data["Photo"])){
            $image_info = getimagesize($data["Photo"]);
            $Photo = uniqid("PP").".".(isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

            file_put_contents("../app/data/temp/" . $Photo, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data["Photo"])));
        }

        $param = [
            [":StaffName",$data["Name"]],
            [":ContactNo",$data["ContactNo"]],
            [":EmailID",$data["EmailID"]],
            [":GenderCode",$data["GenderCode"]],
            [":DOB",$data["DOB"]],
            [":DOJ",$data["DOJ"]],
            [":ReligionID",$data["ReligionID"]],
            [":CasteCode",$data["CasteCode"]],
            [":CommunityID",$data["CommunityID"]],
            [":NationalityID",$data["NationalityID"]],
            [":Address",$data["Address"]],
            [":Photo", $Photo ?? NULL],
            [":DesignationID",$data["DesignationID"]],
            [":SessionID",1]
        ];

        $query = "INSERT INTO Staff(StaffName, ContactNo, EmailID, GenderCode, DOB, ReligionID, CasteCode, CommunityID, NationalityID, Address,
         Photo, DesignationID, SessionID,JoinedDate) VALUES (:StaffName, :ContactNo, :EmailID, :GenderCode, :DOB, :ReligionID, :CasteCode, :CommunityID, 
         :NationalityID, :Address, :Photo, :DesignationID, :SessionID,:DOJ)";

        $teacherID = DBController::ExecuteSQLID($query,$param);
        if ($teacherID){
            if (isset($data["Photo"])) {
                rename("../app/data/temp/" . $Photo, "../app/data/PassportPhoto/" . pathinfo($Photo, PATHINFO_BASENAME));
            }
            $user   =   array(
                "Username" => $data["ContactNo"],
                "Name" => $data["Name"],
                "ContactNo" => $data["ContactNo"],
                "EmailID" => $data["EmailID"],
                "StaffID" =>  $teacherID,
                "UserType" => 2,
                "ValidateUsernameOnly" =>  True
            );
            $userdata=(new Signup())->request($user);

           
            $isCreated=false;
            $giveup=0;
            if($userdata["return_code"]==false){

                    while($isCreated==false){
                    $user["Username"]=$data["ContactNo"].rand(0,100);
                    $userdata=(new Signup())->request($user);
                    if($userdata["return_code"]==true){
                        $isCreated=true;
                    }
                    $giveup +=1;
                    if($giveup==20) break;
                }
            } // end of creation of username

                DBController::logs("sucessFully added Staff");
                return array("return_code" => true, "return_data" => "Successfully Created");
        }
        return array("return_code" => false, "return_data" => "unable to get");
    }

    /*  Info:
        Description: Delete the staff {StaffID,}
            23-01-2024 (Angelbert Riahtam) : Adding the function
    */
    function deleteStaff($data)
    {
        if(isset($data['StaffID']))
        {
            $param=array(
                array(":StaffID",strip_tags($data['StaffID']))
            );
            //update in staff table and in user table also
            $query="UPDATE `Staff` SET `isRemoved`=1  WHERE  `StaffID`=:StaffID";
            $deletestaffRes=DBController::ExecuteSQL($query,$param);
            if($deletestaffRes)
            {
                // update in user table also
                $param1=array(
                    array(":StaffID",$data['StaffID'])
                );

                $query1="UPDATE `Users` SET  `isActive`=0 WHERE `StaffID`=:StaffID";
                $disaleUserRes=DBController::ExecuteSQL($query1,$param1);

                if($disaleUserRes)
                {
                    return array("return_code" => true, "return_data" => "Sucessfully deleted and disable Staff");
                }
                else{
                    return array("return_code" => false, "return_data" => "some error while deleting user.");
                } 
            }
        }
    }

    /*  Info:
        Description: Update the staff personalData
            23-01-2024 (Angelbert Riahtam) : Adding the function
            24-01-2024 (Angelbert Riahtam) : update the function add the param : { DepartmentID,Photo,BloodGroup }
    */
    public function updateStaff($data)
    {
        //check if update is done by admin/staff only
        $staff_id = -1;
            if (isset($data['StaffID'])) {
                $staff_id = $data['StaffID'];
            } else {
                $p = array(array(":UserID", $_SESSION['UserID']));
                $q = "SELECT `StaffID` FROM `Users` WHERE `UserID`=:UserID;";
                $r = DBController::sendData($q, $p);
                if($r)
                {
                    $staff_id=$r['StaffID'];
                }
                else {
                    return array("return_code" => false, "return_data" => "Error! Not a Valid Staff !!");
                }
            }

        if (isset($data["Photo"])){
            $image_info = getimagesize($data["Photo"]);
            $Photo = uniqid("PP").".".(isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

            file_put_contents("../app/data/temp/" . $Photo, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data["Photo"])));
        }

        $param = [
            [":StaffName",$data["Name"]],
            [":ContactNo",$data["ContactNo"]],
            [":EmailID",$data["EmailID"]],
            [":GenderCode",$data["GenderCode"]],
            [":DOB",$data["DOB"]],
            [":DOJ",$data["DOJ"]],
            [":ReligionID",$data["ReligionID"]],
            [":CasteCode",$data["CasteCode"]],
            [":CommunityID",$data["CommunityID"]],
            [":NationalityID",$data["NationalityID"]],
            [":Address",$data["Address"]],
            [":Photo", $Photo ?? NULL],
            [":DesignationID",$data["DesignationID"]],
            [":SessionID",1],
            [":StaffID",$staff_id]
        ];

        $query = "UPDATE Staff SET StaffName=:StaffName, ContactNo=:ContactNo, EmailID=:EmailID, GenderCode=:GenderCode, DOB=:DOB,JoinedDate=:DOJ, 
        ReligionID=:ReligionID, CasteCode=:CasteCode, CommunityID=:CommunityID, NationalityID=:NationalityID, Address=:Address, Photo=:Photo, 
        DesignationID=:DesignationID, SessionID=:SessionID WHERE StaffID=:StaffID";

        $teacherID = DBController::ExecuteSQL($query,$param);
        if ($teacherID){

            //update for department and blood group here (the data came from profile page)
            if(isset($data['DepartmentID']) && isset($data['BloodGroup']))
            {
                $param5=array(
                    array(":DepartmentID",$data['DepartmentID']),
                    array(":BloodGroup",$data['BloodGroup']),
                    array(":StaffID",$staff_id)
                );
                $query5="UPDATE `Staff` SET `DepartmentID`=:DepartmentID ,`BloodGroup`=:BloodGroup  WHERE `StaffID`=:StaffID";
                $UpdateStaffDeptandBloodgrp=DBController::ExecuteSQL($query5,$param5);

            }

            if (isset($data["Photo"])) {
                rename("../app/data/temp/" . $Photo, "../app/data/PassportPhoto/" . pathinfo($Photo, PATHINFO_BASENAME));
            }
            return array("return_code" => true, "return_data" => "Successfully Updated");
        }
        return array("return_code" => false, "return_data" => "unable to get");
    }

    /*  Info:
        Description: Update the staff personalData based on the field passed in the param
            24-01-2024 (Angelbert Riahtam) : Adding the function
    */
    function updateStaffInfo($data)
    {
        if(!isset($data['Id']))
        {
            return array("return_code" => false, "return_data" => "Unable to update Data");
        }
    
        $param=array(
            array(":Data",strip_tags($data['Data'])),
            array(":StaffID",strip_tags($data['Id']))
        );

        switch($data['Field'])
        {
            case "StaffName":
                $query="UPDATE `Staff` SET StaffName=:Data  WHERE `StaffID`=:StaffID";

                //update in user also
                $param1=array(
                    array(":Name",strip_tags($data['Data'])),
                    array(":StaffID",strip_tags($data['Id']))
                );
                $query1="UPDATE `Users` SET `Name`=:Name WHERE `StaffID`=:StaffID";
                $updateUserName=DBController::ExecuteSQL($query1,$param1);
                break;
            case "DOB":
                $query="UPDATE `Staff` SET DOB=:Data WHERE `StaffID`=:StaffID";
                break;
            case "JoinedDate":
                $query="UPDATE `Staff` SET JoinedDate=:Data WHERE `StaffID`=:StaffID";
                break;
            case "ContactNo":
                $query="UPDATE `Staff` SET ContactNo=:Data WHERE `StaffID`=:StaffID";
                //update in user also
                $param1=array(
                    array(":Contact",strip_tags($data['Data'])),
                    array(":StaffID",strip_tags($data['Id']))
                );
                $query1="UPDATE `Users` SET `ContactNo`=:Contact WHERE `StaffID`=:StaffID";
                $updateUserName=DBController::ExecuteSQL($query1,$param1);
                break;
            case "EmailID":
                $query="UPDATE `Staff` SET EmailID=:Data WHERE `StaffID`=:StaffID";
                //update in user also
                $param1=array(
                    array(":Email",strip_tags($data['EmailID'])),
                    array(":StaffID",strip_tags($data['Id']))
                );
                $query1="UPDATE `Users` SET `EmailID`=:Email WHERE `StaffID`=:StaffID";
                $updateUserName=DBController::ExecuteSQL($query1,$param1);
                break;
            case "GenderCode":
                $query="UPDATE `Staff` SET GenderCode=:Data WHERE `StaffID`=:StaffID";
                break;
            case "ReligionID":
                $query="UPDATE `Staff` SET ReligionID=:Data WHERE `StaffID`=:StaffID";
                break;
            case "CasteCode":
                $query="UPDATE `Staff` SET CasteCode=:Data WHERE `StaffID`=:StaffID";
                break;
            case "CommunityID":
                $query="UPDATE `Staff` SET CommunityID=:Data WHERE `StaffID`=:StaffID";
                break;

            case "NationalityID":
                $query="UPDATE `Staff` SET NationalityID=:Data WHERE `StaffID`=:StaffID";
                break;  
            case "DesignationID":
                $query="UPDATE `Staff` SET DesignationID=:Data WHERE `StaffID`=:StaffID";
                break;  
             case "Address":
                $query="UPDATE `Staff` SET Address=:Data WHERE `StaffID`=:StaffID";
                break;             
            default:
                return array("return_code" => false, "return_data" => "Invalid data to update");
        }

        $updateName=DBController::ExecuteSQL($query,$param);
        if($updateName)
        {
            return array("return_code" => true, "return_data" => "Sucessfully Updated");
        }
        else{
            return array("return_code" => false, "return_data" => "Unable to update the data");
        }
    }

   
}
