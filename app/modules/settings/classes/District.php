<?php
namespace app\modules\settings\classes;

use \app\database\DBController;
class District{
    function getAllDistrict($data) {
        //$query = "SELECT `DistrictID`, `DistrictName`, `StateName` FROM `Settings_Districts` join Setting_State on Settings_Districts.StateID=Setting_State.StateID;";
        $query="SELECT sd.`DistrictID`, sd.`DistrictName`,sd.`StateID`, s.`StateName` FROM `Settings_Districts` sd inner join Setting_State s on sd.StateID=s.StateID;";
        $res = DBController::getDataSet($query);

        return array("return_code" => true, "return_data" => $res);
    }

    function addDistrict($data){

        //prepare array 
        $params=array(
            array(":StateID",$data["StateId"]),
            array(":DistrictName",$data["DistrictName"]),
            array(":UserID",$_SESSION['UserID']),
        );
        //save the product
        $query="INSERT INTO `Settings_Districts`( `DistrictName`, `StateID`,`CreatedByID`) VALUES (:DistrictName,:StateID,:UserID);";
        //$query="INSERT INTO `Setting_State`( `StateName`) VALUES (:StateName); ";
        $res=DBController::ExecuteSQL($query,$params);
         if($res){
            return array("return_code" => true, "return_data"=>"States added successfully");  
         }
         return array("return_code" => false, "return_data" => " Error while saving the product");  

    }
}