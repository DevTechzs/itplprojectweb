<?php
namespace app\modules\auth\classes;
use \app\database\DBController;

class Login
{
    function requestLogin($data)
    {

        DBController::logs("Reached request Login");
        $params = array(
            array(":Username", $data["Username"]),
            array(":Password", hash("sha256", substr($data["Username"], 0, 1) . $data["Password"]))
        );
        
        $query = "SELECT * FROM Users WHERE Username = :Username AND Password = :Password";

        $res = DBController::sendData($query, $params);

        if ($res && $res['UserID']) {

            $sessionkey = substr(md5(mt_rand()), 0, 32);

            $sessionkeyexpirydatetime = new \DateTime();
            $sessionkeyexpirydatetime->modify('next month');

            $params = array(
                array(":userid", $res['UserID']),
                array(":sessionkey", $sessionkey),
                array(":sessionkeyexpirydatetime", $sessionkeyexpirydatetime->format('Y-m-d H:i:s')),
                array(":ipaddress", $_SERVER['REMOTE_ADDR']),
                array(":isSuccessfull", 1),
                array(":isActive", 1)
            );

            $query = "INSERT INTO LoginDetails(UserID, SessionKey, SessionExpiryDateTime, IPAddress, isSuccessfull, isActive) 
                VALUES (:userid,:sessionkey,:sessionkeyexpirydatetime,:ipaddress,:isSuccessfull,:isActive)";


            if (DBController::ExecuteSQL($query, $params)) {
                $_SESSION['UserID'] = $res['UserID'];
                $_SESSION['SessionKey'] = $sessionkey;
                $_SESSION['Username'] = $data['Username'];
                $_SESSION['UserType'] = $res['UserType'];

                if ($_SESSION['UserType']==1) {
                    $nextpage="dashboard";
                }else if($_SESSION['UserType']==2){
                    $nextpage="home";
                }else if($_SESSION['UserType']==3){
                    $nextpage="user";

                }

                if (isset($data['FCMToken'])){
                    $params = array(
                        array(":FCMToken", $data['FCMToken']),
                        array(":UserID", $res['UserID'])
                    );

                    $query = "UPDATE Users SET FCMToken=:FCMToken WHERE UserID=:UserID";

                    DBController::ExecuteSQL($query, $params);
                }

                return array("return_code" => true, "return_data" => array( "Name" => $res['Name'],"Username" => $data['Username'],"EmailID"=>$res['EmailID'], "SessionKey" => $sessionkey, "SessionExpiryDate" => $sessionkeyexpirydatetime->format('Y-m-d H:i:s'),"UserType"=>$res['UserType'], "nextPage" => $nextpage));
            }
        }
        return array("return_code" => false, "return_data" =>  "Username or Password does not match");
    }
}
