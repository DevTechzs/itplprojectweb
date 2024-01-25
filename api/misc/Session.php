<?php

class Session{
	public static function isValidSession($MSC){
		$today = date("d");
		$mk=md5($today);
		if($mk!=$MSC){
			return false;
		}

		if(!isset($_SESSION["userid"]) || !isset($_SESSION["sessionkey"])){
			return false;
		}

		$params = array(
			array(":userid", $_SESSION["userid"]),
			array(":sessionkey", $_SESSION["sessionkey"])
		);
		
		$query = "SELECT * FROM `logindetail` WHERE `userid` = :userid AND `sessionkey` = :sessionkey AND `isActive` = 1";
		
		$array = DBController::sendData($MSC,$query,$params);
		
		if($array){
			if(new DateTime($array['sessionkeyexpirydatetime'])> new DateTime()){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>
