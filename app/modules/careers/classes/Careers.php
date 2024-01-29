<?php

namespace app\modules\careers\classes;
use app\database\DBController;
use app\misc\FCM;
use app\misc\SMS;
use app\modules\settings\classes\Session;

class Careers{

    function getallApplicantsList()
    {
        $query="SELECT pa.`ApplicantID`, pa.`JobID`, pa.`Name`, pa.`Email`, pa.`Address`, pa.`City`, pa.`Zipcode`, pa.`Contact`, pa.`Designation`, pa.`Documents`, pa.`CreatedDateTime`,pa.`isActive`, pc.`CareersID`, pc.`Role`, pc.`RoleType`, pc.`WorkLocation`, pc.`PreferredWorkType`, pc.`Duration`, pc.`Description`, pc.`Overview`, pc.`Requirements`, pc.`isActive` as isActiveJob  FROM `Prayagedu_Applicants` pa
        INNER JOIN Prayagedu_Careers pc on pc.CareersID=pa.JobID;";
        $res=DBController::getDataSet($query);
        if($res)
        {
            return array("return_code" => true, "return_data" =>  $res);
        }
        else{
            return array("return_code" => false, "return_data" =>  "Data not Available");
        }
    }

    function getAllJObPosted()
    {
        // $query="SELECT * FROM `Prayagedu_Careers` WHERE `isActive`=1"; //active only
        $query="SELECT * FROM `Prayagedu_Careers`";  //all
        $res=DBController::getDataSet($query);
        if($res){
            return array("return_code" => true, "return_data" =>  $res);
        }
        else{
            return array("return_code" => false, "return_data" =>  "No data available");
        }
    }

    function postaJob($data)
    {
         //update
        if(isset($data['CareerID']))
        { 
                $param=array(
                    array(":Role",strip_tags($data['JobRole'])),
                    array(":RoleType",strip_tags($data['RoleType'])),
                    array(":Location",strip_tags($data['Location'])),
                    array(":Worktype",strip_tags($data['Worktype'])),
                    array(":Duration",strip_tags($data['Duration'])),
                    array(":Description",strip_tags($data['Description'])),
                    array(":overview",strip_tags($data['overview'])),
                    array(":Requirements", strip_tags($data['Requirements'])),
                    array(":UpdatedBy",$_SESSION['UserID']),
                    array(":CareerID",$data['CareerID'])
                );
                $query="UPDATE `Prayagedu_Careers` SET `Role`=:Role,`RoleType`=:RoleType,`WorkLocation`=:Location,
                `PreferredWorkType`=:Worktype,`Duration`=:Duration,`Description`=:Description,`Overview`=:overview,
                `Requirements`=:Requirements,`UpdatedBy`=:UpdatedBy WHERE `CareersID`=:CareerID";
        }

        //insert
        else
        {
            $param=array(
                array(":Role",strip_tags($data['JobRole'])),
                array(":RoleType",strip_tags($data['RoleType'])),
                array(":Location",strip_tags($data['Location'])),
                array(":Worktype",strip_tags($data['Worktype'])),
                array(":Duration",strip_tags($data['Duration'])),
                array(":Description",strip_tags($data['Description'])),
                array(":overview",strip_tags($data['overview'])),
                array(":Requirements", strip_tags($data['Requirements'])),
                array(":CreatedBy",$_SESSION['UserID']),
                array(":isActive",1)
            );
            $query="INSERT INTO `Prayagedu_Careers`( `Role`, `RoleType`, `WorkLocation`, `PreferredWorkType`, `Duration`, `Description`, `Overview`, `Requirements`, `CreatedBy`, `isActive`)
            VALUES(:Role,:RoleType,:Location,:Worktype,:Duration,:Description,:overview,:Requirements,:CreatedBy,:isActive)";
        }

        $res=DBController::ExecuteSQL($query,$param);
        if($res)
        {
            return array("return_code" => true, "return_data" => "Job Posted Sucessfully");
        }
        else{
            return array("return_code" => false, "return_data" => "Failed to post a job");
        }
    }

    function deletePostedJob($data)
    {
        $param=array(
            array(":isActive",0),
            array(":JobID",$data['JobID']),
        );

        // $query="DELETE FROM `Prayagedu_Careers` WHERE `CareersID`=:JobID";
        $query="UPDATE `Prayagedu_Careers` SET  `isActive`=:isActive WHERE `CareersID`=:JobID";
        $res=DBController::ExecuteSQL($query,$param);
        if($res)
        {
            return array("return_code" => true, "return_data" => "Disable & Delete Sucessfully");
        }
        else{
            return array("return_code" => false, "return_data" => "Failed to Delete.Please try again");
        }
    }
    

}
