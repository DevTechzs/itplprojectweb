<?php

 

// use app\misc\File;
// use Exception;
// use \PDO;

class DBController
{

    //local configuration
	static $servername = "localhost:3306";
	static $username = "root";
	static $password = "";
	static $database = "tz_clients";


	   //  server Configuration
	//      static $servername = "localhost:3306";
	//    static $username = "nearchive";
	//    static $password = "Techz-789*";
	//    static $database = "tz_clients";


	static $conn = false;

	/*
	*	@return Connection
	*/
	static function init()
	{
		if (self::$conn === false) {
			self::$conn = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$database, self::$username, self::$password);
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	/*
	*	@param Machine Session Code 
	*	@param query/SQL Query
	*	@param Parameters to be passed(Can be an empty array)
	*	@return Boolean Value/DataSet as Array
	*/
	static function getDataSet($query, $params = array())
	{
 		try {
			self::init();
			$stmt = self::$conn->prepare($query);

			foreach ($params as $v) {

				$paramType = PDO::PARAM_STR;

				if (is_bool($v[1])) {
					$paramType = PDO::PARAM_BOOL;
				} elseif (is_null($v[1])) {
					$paramType = PDO::PARAM_NULL;
				} elseif (is_int($v[1])) {
					$paramType = PDO::PARAM_INT;
				}

				$stmt->bindParam($v[0], $v[1], $paramType);
			}

			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

			if ($result)
				return $stmt->fetchAll();
			else
				return false;
		} catch (exception $e) {
			self::logs($query . " \n " . json_encode($params) . " \n " . $e->getMessage());
			return false;
		}
	}

	/*
	*	@param Machine Session Code 
	*	@param query/SQL Query
	*	@param Parameters to be passed(Can be an empty array)
	*	@return Boolean Value as Array
	*/
	static function sendData($query, $params = array())
	{
		try {
			self::init();
			$stmt = self::$conn->prepare($query);

			foreach ($params as $v) {

				$paramType = PDO::PARAM_STR;

				if (is_bool($v[1])) {
					$paramType = PDO::PARAM_BOOL;
				} elseif (is_null($v[1])) {
					$paramType = PDO::PARAM_NULL;
				} elseif (is_int($v[1])) {
					$paramType = PDO::PARAM_INT;
				}

				$stmt->bindParam($v[0], $v[1], $paramType);
			}

			$stmt->execute();

			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);


			if ($result)
				return $stmt->fetch();
			else
				return false;
		} catch (exception $e) {
			self::logs($query . " \n " . json_encode($params) . " \n " . $e->getMessage());
			return false;
		}
	}


	/*
	*	@param Machine Session Code 
	*	@param query/SQL Query
	*	@param Parameters to be passed(Can be an empty array)
	*	@return Boolean Value 
	*/
	static function ExecuteSQL($query, $params = array())
	{
		try {
			self::init();
			$stmt = self::$conn->prepare($query);

			foreach ($params as $v) {

				$paramType = PDO::PARAM_STR; 

				if (is_bool($v[1])) {
					$paramType = PDO::PARAM_BOOL;
				} elseif (is_null($v[1])) {
					$paramType = PDO::PARAM_NULL;
				} elseif (is_int($v[1])) {
					$paramType = PDO::PARAM_INT;
				}

				$stmt->bindParam($v[0], $v[1], $paramType);
			}

			return $stmt->execute();
		} catch (exception $e) {
			self::logs($query . " \n " . json_encode($params) . " \n " . $e->getMessage());
			return false;
		}
	}  

	static function ExecuteSQLID($query, $params = array())
	{
		try {
			self::init();
			$stmt = self::$conn->prepare($query);

			foreach ($params as $v) {

				$paramType = PDO::PARAM_STR;

				if (is_bool($v[1])) {
					$paramType = PDO::PARAM_BOOL;
				} elseif (is_null($v[1])) {
					$paramType = PDO::PARAM_NULL;
				} elseif (is_int($v[1])) {
					$paramType = PDO::PARAM_INT;
				}

				$stmt->bindParam($v[0], $v[1], $paramType);
			}
			$stmt->execute();
			$result = self::$conn->lastInsertId();
			return $result;
		} catch (exception $e) {
			self::logs($query . " \n " . json_encode($params) . " \n " . $e->getMessage());
			return false;
		}
	}

	/*
	*	@param Table Name 
	*	@param Column Name
	*	@param Prefix
	*	@param Code Length
	*	@return RESULT CODE
	*/
	static function GenerateCode($tablename, $columnname, $prefix, $CodeLength)
	{
		$params = array(
			array(":TableName", $tablename),
			array(":ColumnName", $columnname),
			array(":Prefix", $prefix),
			array(":CodeLength", $CodeLength)
		);

		$query = 'call p_GenerateCode(:TableName, :ColumnName, :Prefix, :CodeLength)';
		$res = DBController::sendData($query, $params);
		if ($res) {
			return $res["RESULTCODE"];
		}
		return $res;
	}
	static function logs($log)
	{
		try{
			//create the log file if it does not exists
			if (file_exists('log.txt')){
				$fp = fopen('log.txt', 'a')  ; //opens file in append mode  
			}else{
				$fp = fopen('log.txt', 'w')  ; 
			} 

		//	$fp = fopen('../log.txt', 'a'); //opens file in append mode  
			fwrite($fp, "\r\n\r\n->" . date('d-m-y h:i:s') . " : " . $log);
			fclose($fp);
		}catch (exception $e) {
 			
		}  
	}
	static function logMe($module,$log)
	{
		//check the filename from the server for the log 
		$filepath='../logs/'.$module.'/'.$module.'.txt';
		if( !is_dir('../logs/'.$module) ) {
			mkdir( '../logs/'.$module, 0750, true );
		  }

		if (file_exists($filepath)){
			$fp = fopen($filepath, 'a')  ; //opens file in append mode  
		}else{
			$fp = fopen($filepath, 'w')  ; 
		} 
		try{
		
			fwrite($fp, "\r\n\r\n" . date('d-m-y h:i:s') . " : " . $log);
			fclose($fp);
		}catch (exception $e) {			
 			
		}  
	}
	
	static function isMobileDevice() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
	|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
	, $_SERVER["HTTP_USER_AGENT"]);
	}

	static function CloseDB()
	{
		if (self::$conn != false)
			self::$conn = null;
	}

    static function isMenuAccess($menuname)
    {
        $params = array(
            array(":MenuName", trim($menuname)),
            array(":UserTypeID", $_SESSION["UserType"])
        );
        $query ="SELECT  MenuName from  MenuAccess   where UserTypeID=:UserTypeID and MenuName=:MenuName; ";
        $res = DBController::sendData($query, $params);
        if($res)
            return  true;
        return  false;
//        return array("return_code" => false, "return_data" =>"No Access is defined for this usertype. Contact Administrator");


    }
 

}

class Helper
{
    static function generate_string($length = 5){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
    	    $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    } 
}
