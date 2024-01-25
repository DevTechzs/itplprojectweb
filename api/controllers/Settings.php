<?php

 
class Settings
{



	function getallActiveCareers()
	{
		$query="SELECT `CareersID`, `Role`, `RoleType`, `WorkLocation`, `PreferredWorkType`, `Duration`, `Description`, `Overview`, `Requirements`,  `isActive` FROM `Prayagedu_Careers` WHERE `isActive`=1;";
		$res=DBController::getDataSet($query);
		if($res)
		{
			return array("return_code" => true, "return_data" => $res);
		}
		else{
			return array("return_code" => false, "return_data" => "There no Active job posting for now.You can just submit your CV to Our EmailID");
		}
	}

	function submitApplication($data)
	{

		
		if(!isset($data['documents'])){
			return array("return_code" => false, "return_data" => "Attach Resume");

		}
		
		$filearray = array(
            'ext' => 'pdf',
            'file' => $data['documents']
        );
        $path = self::storeDocuments('CV', $filearray);

		$param=array(
			array(":JobID",1),
			array(":Name",strip_tags($data['name'])),
			array(":Email",strip_tags($data['email'])),
			array(":Address",($data['address'])),
			array(":City",($data['city'])),
			array(":Zipcode",$data['zipcode']),
			array(":Contact",$data['contact']),
			array(":Applyfor",$data['applyfor']),
			array(":CV",$path),
			array(":CreatedBy",2),
			array(":isActive",1)
		);

		$query="INSERT INTO `Prayagedu_Applicants`(`JobID`,`Name`, `Email`, `Address`, `City`, `Zipcode`, `Contact`, `Designation`, `Documents`, `CreatedBy`,  `isActive`)
		VALUES (:JobID,:Name,:Email,:Address,:City,:Zipcode,:Contact,:Applyfor,:CV,:CreatedBy,:isActive)";
		$res=DBController::ExecuteSQL($query,$param);
		if($res)
		{
			return array("return_code" => true, "return_data" => "Application Submitted Sucessfullly");
		}
		else{
			return array("return_code" => false, "return_data" => "Some Error Occur while submitting your Applications");
		}
	}


	static function storeDocuments($category, $data)
    {
        //NOTE : Create a thumbnail of the image only 
        $filepath = '';
        $document = $data["file"];
        $root = '../app/data/';
        switch ($data["ext"]) {
            case "pdf":
                $Filename = uniqid("DOC_") . "." . $data["ext"];
                $document = preg_replace('#^data:application/\w+;base64,#i', '', $document);
                break;
            case "jpeg" || "png" || "jpg":
                $Filename = uniqid("IMG_") . "." . $data["ext"];
                $document = preg_replace('#^data:image/\w+;base64,#i', '', $document);
                break;
        }
        switch ($category) {
            
            case "CV":
                $folder = 'cv/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;  
   
            default:
                $folder = 'default/';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .=  $Filename;
        }
        $fp = fopen($root . $folder . $filepath, "w+");
        fwrite($fp, base64_decode($document));
        fclose($fp);
        return $filepath;
    }

	
	static function logIP()
	{
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

		if (isset($_SESSION['userid'])) {
			$userid = $_SESSION['userid'];
		} else {
			$userid = 2;
		}

		$ip = getenv('HTTP_CLIENT_IP') ?: getenv('HTTP_X_FORWARDED_FOR') ?: getenv('HTTP_X_FORWARDED') ?: getenv('HTTP_FORWARDED_FOR') ?: getenv('HTTP_FORWARDED') ?: getenv('REMOTE_ADDR');

		$param = array(
			array(":IPAddress", $ip),
			array(":UserID", $userid),
			array(":URL", $actual_link)
		);

		$query = "INSERT INTO `iplogging`(`IPAddress`, `UserID`, `URL`)
				 VALUES (:IPAddress,:UserID,:URL)";
		$val = DBController::ExecuteSQL($query, $param);
		return array("return_code" => true, "return_data" => $val);
	}



function AddLeads($data)
{
	$param=array(
		array(":Name",strip_tags($data['Name'])),
		array(":EmailID",strip_tags($data['EmailID'])),
		array(":Contact",strip_tags($data['Contact'])),
		array(":TitleName",strip_tags($data['Subject'])),
		array(":Description",strip_tags($data['Description'])),
		array(":IPAddress",$_SERVER['REMOTE_ADDR']),
		array(":DeviceInfo",$_SERVER['HTTP_USER_AGENT'])
	);

	$query="INSERT INTO `ITPL_Leads`(`Name`,`EmailID`,`Contact`, `TitleName`, `Description`, `IPAddress`, `DeviceInfo`)
	VALUES (:Name,:EmailID,:Contact,:TitleName,:Description,:IPAddress,:DeviceInfo)";

	$AddLeadsResult=DBController::ExecuteSQL($query,$param);
	if($AddLeadsResult)
	{
		return array("return_code" => true, "return_data" => "Thank you for Contacting us");
	}
	else{
		return array("return_code" => false, "return_data" => "Some Error occurs.Please try again");
	}	
}

function AddItplRequirements($data)
{
	$param=array(
		array(":Name",strip_tags($data['Name'])),
		array(":EmailID",strip_tags($data['EmailID'])),	
		array(":Contact",strip_tags($data['Contact'])),
		array(":BusinessName",strip_tags($data['BusinessName'])),
		array(":Description",strip_tags($data['Description'])), 
		array(":RequiredService",implode(',',$data['RequiredService'])) // value separateed by comas
	);
	$query="INSERT INTO `ITPL_Requirements`(`Name`, `EmailID`, `Contact`, `BusinessName`, `Description`, `RequiredService`)
	VALUES (:Name,:EmailID,:Contact,:BusinessName,:Description,:RequiredService)";
	$AddRequirementsResult=DBController::ExecuteSQL($query,$param);
	if($AddRequirementsResult)
	{
		return array("return_code" => true, "return_data" => "Thank you for Contacting us");
	}
	else{
		return array("return_code" => false, "return_data" => "Some error occur.Please try again");
	}
	
}


}
