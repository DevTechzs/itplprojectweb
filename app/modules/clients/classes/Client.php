<?php

namespace app\modules\clients\classes;

use app\database\DBController;
use app\misc\FCM;
use app\misc\SMS;
use app\modules\settings\classes\Session;

class Client
{


    function clientAboutToExpired()
    {
        $query = "SELECT c.ClientName,p.Name,ps.SubscriptionName,cs.Enddate,cs.Amount,cs.Installment,cs.NextDueDate, DATEDIFF(EndDate,CURDATE()) AS daysleft 
        FROM `clientsubscriptions` cs 
        INNER JOIN clients c on cs.ClientID=c.ClientID
        INNER JOIN products p on cs.ProductID=p.ProductID
        INNER JOIN productsubscriptions ps on cs.ProductSubscriptionID=ps.ProductSubscriptionID
        where EndDate > CURDATE();";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data found!");
    }


    function getMostSubscribeClients()
    {
        $query = "SELECT
        c.ClientName,c.MobileNo,sts.StateName,std.DistrictName, count(cs.clientID) as numberofsubscribe
        FROM clients c 
        inner join clientsubscriptions cs on c.ClientID=cs.ClientID
        inner join setting_state sts on c.StateID=sts.StateID
        inner JOIN settings_districts std on c.DistrictID=std.DistrictID
        GROUP BY
        cs.ClientID
        ORDER BY
        SUM(cs.ClientID) DESC;";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data found!");
    }

    function getMostSubscribeProduct()
    {
        $query = "SELECT
                p.Name,p.Code,p.isActive,p.Website, count(c.productID) as numberofsubscribe
                FROM
                clientsubscriptions c inner join products p on c.ProductID=p.ProductID
                GROUP BY
                c.productID
                ORDER BY
                SUM(c.productID) DESC;";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data found!");
    }

    function getUnsubscribeClients()
    {
        $query = "SELECT c.`ClientName`,p.`Name`,ps.`SubscriptionName`,cs.`MaxUsers`,cs.`Remarks`,cs.`Installment`,cs.`Amount`,cs.`NextDueAmount`,cs.`NextDueDate`,cs.`SubscriptionEndReason`,cs.`SubscriptionEndedDateTime`
                from clientsubscriptions cs inner join clients c on cs.ClientID=c.ClientID 
                inner JOIN products p on cs.ProductID=p.ProductID
                inner join productsubscriptions ps on cs.ProductSubscriptionID=ps.ProductSubscriptionID
                where `isSubscriptionEnded`=1;";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data found!");
    }

    function getActiveClients()
    {
        $query = "select c.`clientName`,c.`MobileNo`,cs.`ProductSubscriptionID`,cs.`NextDueDate`,cs.`amount`
        from clients as c
        inner join clientsubscriptions as cs on c.`ClientID`=cs.`ClientID`
        where EndDate >= CURDATE()";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data found!");
    }

    function getExpiredClients()
    {
        // $query="select c.`clientName`,c.`MobileNo`,cs.`ProductSubscriptionID`,cs.`EndDate` 
        // from clients as c
        // inner join clientsubscriptions as cs on c.`ClientID`=cs.`ClientID`
        // where EndDate < CURDATE();";

        $query = "select concat(c.`clientName`,' , ',p.`Name`,' ,  ',ps.SubscriptionName) as clientdescription ,c.`MobileNo`,cs.`ProductSubscriptionID`,cs.`EndDate` 
        from clients as c
        inner join clientsubscriptions as cs on c.`ClientID`=cs.`ClientID`
        INNER JOIN products p on cs.ProductID=p.ProductID
        INNER JOIN productsubscriptions ps on cs.ProductSubscriptionID=ps.ProductSubscriptionID
        where EndDate < CURDATE();";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data found!");
    }

    function Unsubscribe($data)
    {
        $params = array(
            array(":ClientSubscriptionID", $data["ClientSubscriptionID"]),
            array(":unsubscribereason", $data["unsubscribereason"]),
        );
        $query = "UPDATE `clientsubscriptions` SET `SubscriptionEndReason`=:unsubscribereason,`isSubscriptionEnded`=1 WHERE `ClientSubscriptionID`=:ClientSubscriptionID;";
        $res = DBController::ExecuteSQL($query, $params);
        if ($res) {
            return array("return_code" => true, "return_data" => "Added Subscription");
        }
        return array("return_code" => false, "return_data" => " Error while saving");
    }

    function deleteClientSubscription($data)
    {
        $params = array(
            array(":subscriptionID", $data["subscriptionId"]),
        );
        $query = "DELETE FROM `clientsubscriptions` where `ClientSubscriptionID`=:subscriptionID;";
        $res = DBController::ExecuteSQL($query, $params);
        return array("retrun_code" => true, "return_data" => "Sucessfully Removed subscription");
    }

    function getClient_subscription()
    {
        $query = "SELECT cs.`ClientSubscriptionID`, c.`ClientID`,c.`ClientName`, p.`ProductID`,p.`Name`, ps.`ProductSubscriptionID`,ps.`SubscriptionName`,ps.`Amount` as productAmount, cs.`StartDate`, cs.`EndDate`, cs.`Amount`, cs.`MaxUsers`, cs.`TransectionID`, cs.`Remarks`, cs.`Installment`, cs.`NextDueDate`, cs.`NextDueAmount`, cs.`API`, cs.`ProductLogoPath`, cs.`TermsPath` 
        FROM `ClientSubscriptions` as cs  
        inner JOIN Clients  as c on cs.ClientID=c.ClientID
        inner JOIN Products as p on p.ProductID=cs.ProductID
        INNER JOIN productsubscriptions as ps on ps.ProductSubscriptionID=cs.`ProductSubscriptionID`
        where cs.`isSubscriptionEnded`=0;";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data for Client Subscription!");
    }

    function addClientSubscription($data)
    {
        //update
        if (isset($data["ClientSubscriptionID"])) { //update  
            $params = array(
                array(":clientId", $data["clientId"]),
                array(":ProductId", $data["ProductId"]),
                array(":productSubscriptionId", $data["SubscriptionId"]),
                array(":StartDate", $data["StartDate"]),
                array(":Enddate", $data["Enddate"]),
                array(":Amount", $data["Amount"]),
                array(":MaxUser", $data["MaxUser"]),
                array(":Remarks", $data["Remarks"]),
                array(":Installment", $data["Installment"]),
                array(":NextDueDate", $data["NextDueDate"]),
                array(":nextDueAmount", $data["nextDueAmount"]),
                array(":aPi", $data["aPi"]),
                array(":Terms", $data["Terms"]),
                array(":Logo", $data["Logo"]),
                array(":UserID", $_SESSION['UserID']),
                array(":ClientSubscriptionID", $data['ClientSubscriptionID'])
            );

            $query = "UPDATE `clientsubscriptions` SET `ClientID`=:clientId,`ProductID`=:ProductId,`ProductSubscriptionID`=:productSubscriptionId,`StartDate`=:StartDate,`EndDate`=:Enddate,
                `Amount`=:Amount,`MaxUsers`=:MaxUser,`Remarks`=:Remarks,`CreatedBy`=:UserID,`Installment`=:Installment,`NextDueDate`=:NextDueDate,
                `NextDueAmount`=:nextDueAmount,`API`=:aPi,`ProductLogoPath`=:Logo,`TermsPath`=:Terms WHERE `ClientSubscriptionID`=:ClientSubscriptionID;";
            $res = DBController::ExecuteSQL($query, $params);
        }
        //add new
        else {
            $params = array(
                array(":clientId", $data["clientId"]),
                array(":ProductId", $data["ProductId"]),
                array(":SubscriptionId", $data["SubscriptionId"]),
                array(":StartDate", $data["StartDate"]),
                array(":Enddate", $data["Enddate"]),
                array(":Amount", $data["Amount"]),
                array(":MaxUser", $data["MaxUser"]),
                array(":Remarks", $data["Remarks"]),
                array(":Installment", $data["Installment"]),
                array(":NextDueDate", $data["NextDueDate"]),
                array(":nextDueAmount", $data["nextDueAmount"]),
                array(":aPi", $data["aPi"]),
                array(":Terms", $data["Terms"]),
                array(":Logo", $data["Logo"]),
                array(":UserID", $_SESSION['UserID']),
            );

            $query = "INSERT INTO `ClientSubscriptions`( `ClientID`, `ProductID`, `ProductSubscriptionID`, `StartDate`, `EndDate`, `Amount`, `MaxUsers`,`Remarks`, `CreatedBy`, `Installment`, `NextDueDate`, `NextDueAmount`, `API`, `ProductLogoPath`, `TermsPath`)
                VALUES (:clientId,:ProductId,:SubscriptionId,:StartDate,:Enddate,:Amount,:MaxUser,:Remarks,:UserID,:Installment,:NextDueDate,:nextDueAmount,:aPi,:Logo,:Terms)";
            $res = DBController::ExecuteSQLID($query, $params);
        }

        if ($res) {
            return array("return_code" => true, "return_data" => "Added Subscription", "data" => $res);
        }
        return array("return_code" => false, "return_data" => " Error while saving");
    }


    function getDomainNameById($data) // added by dev on 26/10/23
    {
        // Prepare array
        $params = array(
            array(":ClientSubscriptionID", $data["ClientSubscriptionID"])
        );
        $domainName = "SELECT api ,ClientID from `clientsubscriptions`  WHERE `ClientSubscriptionID`=:ClientSubscriptionID;";
        $res = DBController::sendData($domainName, $params);
        //checking is it valid or not 
        if ($res) {
            $domain_url = parse_url($res['api']);
            $domain = $domain_url['host'];
            return array("return_code" => true, "return_data" => $res, "domain" => $domain);
        }
        return array("return_code" => false, "return_data" => "Could not find the domain for the subscription.");
    }

    //  function getBasedURLByProductId($data) // added by dev on 01/11/2
    // {
    //       // Prepare array
    //       $params=array(
    //         array(":ProductId",$data["ProductId"]),
    //     ); 
    //     $query= "SELECT  `DBBasedSource`  from `products_basedfiles`  WHERE `ProductID`=:ProductId";
    //     $res= DBController::sendData($query, $params);
    //     if($res){
    //         $basedURL = $res['DBBasedSource'];
    //         return array("return_code" => true, "return_data"=> $res, "basedURL"=> $basedURL);  
    //     }
    //     return array("return_code" => false, "return_data"=> "Could not find the Path");  

    // }


    function deleteClient($data)
    {

        $params = array(
            array(":ClientID", $data["ClientID"])
        );
        $query = "SELECT ClientID  FROM `clientsubscriptions` WHERE `ClientID`=:ClientID;";
        $resultss = DBController::sendData($query, $params);
        if ($resultss) {
            return array("return_code" => false, "return_data" => "Client cannot be deleted. As Subscription Exists. ");
        }

        $query = "update  `Clients` set isActive=0 WHERE `ClientID`=:ClientID";
        $res = DBController::ExecuteSQL($query, $params);
        return array("return_code" => true, "return_data" => "Successfully Removed & Disabled !!!");
    }


    function getClients($data)
    {
        $query = "SELECT  `ClientID`,`ClientName`, `TelephoneNo`, `MobileNo`, `Fax`, `ContactPersonName`, `ContactPersonMobileNo`, 
        `ContactPersonDesignation`,sd.DesignatonName, Clients.DistrictID, `DistrictName`,Clients.StateID,  `StateName`, `CityName`, `PinCode`, `Landmark`, `Logo`, `MaxUsers`  
        FROM `Clients` inner join Setting_State on Clients.StateID=Setting_State.StateID 
        left join Setting_Designation sd on sd.DesignationID=Clients.ContactPersonDesignation
        left join Settings_Districts on Clients.DistrictID=Settings_Districts.DistrictID where  ifnull(isActive,0)=1 ;";

        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No data for clients");
    }

    function addClient($data)
    {
        if (isset($data["ClientID"])) { //update  
            $params = array(
                array(":ClientName", $data["ClientName"]),
                array(":telephoneNumber", $data["telephoneName"]),
                array(":MobileNo", $data["MobileNo"]),
                array(":Fax", $data["Fax"]),
                array(":ContactName", $data["ContactName"]),
                array(":ContactPersonMobile", $data["ContactNumber"]),
                array(":PersonDesignation", $data["PersonDesignation"]),
                array(":State", $data["State"]),
                array(":District", $data["District"]),
                array(":City", $data["City"]),
                array(":Pincode", $data["Pincode"]),
                array(":Landmark", $data["Landmark"]),
                array(":Maxuser", $data["Maxuser"]),
                array(":Logo", $data["Logo"]),
                array(":ClientID", $data['ClientID'])
            );

            $query = "UPDATE `Clients` SET `ClientName`=:ClientName,`TelephoneNo`=:telephoneNumber,`MobileNo`=:MobileNo,`Fax`=:Fax,`ContactPersonName`=:ContactName,`ContactPersonMobileNo`=:ContactPersonMobile,`ContactPersonDesignation`=:PersonDesignation,`StateID`=:State,`DistrictID`=:District,`CityName`=:City,`PinCode`=:Pincode,`Landmark`=:Landmark,`Logo`=:Logo,`MaxUsers`=:Maxuser WHERE `ClientID`=:ClientID;";
            $res = DBController::ExecuteSQL($query, $params);
        } else {
            $params = array(
                array(":ClientName", $data["ClientName"]),
                array(":telephoneName", $data["telephoneName"]),
                array(":MobileNo", $data["MobileNo"]),
                array(":Fax", $data["Fax"]),
                array(":ContactName", $data["ContactName"]),
                array(":ContactNumber", $data["ContactNumber"]),
                array(":PersonDesignation", $data["PersonDesignation"]),
                array(":State", $data["State"]),
                array(":District", $data["District"]),
                array(":City", $data["City"]),
                array(":Pincode", $data["Pincode"]),
                array(":Landmark", $data["Landmark"]),
                array(":Maxuser", $data["Maxuser"]),
                array(":Logo", $data["Logo"]),
                array(":UserID", $_SESSION['UserID']),
            );


            $query = "INSERT INTO `Clients`( `ClientName`, `TelephoneNo`, `MobileNo`, `Fax`, `ContactPersonName`, `ContactPersonMobileNo`, `ContactPersonDesignation`, `StateID`, `DistrictID`, `CityName`, `PinCode`, `Landmark`, `Logo`, `MaxUsers`,`CreatedBy`)
    VALUES (:ClientName,:telephoneName,:MobileNo,:Fax,:ContactName,:ContactNumber,:PersonDesignation,:State,:District,:City,:Pincode,:Landmark,:Logo,:Maxuser,:UserID);";
            $res = DBController::ExecuteSQLID($query, $params);
        }
        if ($res) {
            return array("return_code" => true, "return_data" => "Client added successfully");
        }
        return array("return_code" => false, "return_data" => " Error while saving");
    }


    function getPrayageduLeads()
    {
        $query = "SELECT `LeadsID`, `Name`, `OrganizationTypeID`, `SchoolGroupName`, `BrandCount`, `ContactNo`, `Email`, `Role`, `isContacted`, `ContactedRemarks`, `ContactedDate`, `isPositive`,`EntryDateTime`
        FROM `Prayagedu_Leads`;";
        $res = DBController::getDataSet($query);
        if ($res) {
            return array("return_code" => true, "return_data" => $res);
        } else {
            return array("return_code" => false, "return_data" => "NO Leads Data");
        }
    }

    function getClient_subscriptionById($data)
    {
        $query = "SELECT cs.`ClientSubscriptionID`, c.`ClientName`,c.`ClientID`, cs.`API`
        FROM `ClientSubscriptions` as cs  
        LEFT JOIN Clients  as c on cs.ClientID=c.ClientID
        where cs.`isSubscriptionEnded`=0;";
        $notices = DBController::getDataSet($query);
        if ($notices) {
            return array("return_code" => true, "return_data" =>  $notices);
        }
        return array("return_code" => false, "return_data" => "No Data for Client Subscription!");
    }


    // function getDataFromAPI($data, $method = 'GET')
    // {
    //     // Your code to fetch API and generate secret key

    //     // Fetch API based on ClientSubscriptionID
    //     $params = array(
    //         array(":ClientSubscriptionID", (int)strip_tags($data["ClientSubscriptionID"]))
    //     );
    //     $query = "SELECT `ClientSubscriptionID`, `API`
    //               FROM `ClientSubscriptions` 
    //               WHERE `ClientSubscriptionID` = :ClientSubscriptionID;";
    //     $notices = DBController::sendData($query, $params);

    //     if ($notices) {
    //         $API = $notices['API'];
    //         $requestData = array(
    //             "Module" => "publics",
    //             "Page_key" => "getUserInfoBasedOnContact",
    //             "JSON" => array(
    //                 "Contact" => strip_tags($data['PhoneNumber']),
    //                 "Key" => "Test123"
    //             ),
    //             "MSC" => "751d31dd6b56b26b29dac2c0e1839e34"
    //         );

    //         // Convert the array to JSON format
    //         $json = json_encode($requestData);
    //         $api_url = $API; // Static for testing
    //         $ch = curl_init($api_url);

    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //         if ($method === 'GET') {
    //             // Use GET method
    //             $queryData = http_build_query($requestData);
    //             $api_url .= '?' . $queryData;
    //         } else {
    //             // Use POST method
    //             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //                 'Content-Type: application/json',
    //                 'Content-Length: ' . strlen($json)
    //             ));
    //         }

    //         curl_setopt($ch, CURLOPT_URL, $api_url);

    //         $response = curl_exec($ch);
    //         if (curl_errno($ch)) {
    //             // Handle curl errors
    //             // For example: echo 'Error: ' . curl_error($ch);
    //         } else {
    //             // Handle response
    //             // For example: echo $response;
    //         }

    //         curl_close($ch);

    //         $response = json_decode($response);

    //         if ($response->return_code == true) {
    //             return array("return_code" => true, "return_data" => $response->return_data);
    //         } else {
    //             return array("return_code" => false, "return_data" => "Not associated with this number.");
    //         }
    //     }

    //     return array("return_code" => false, "return_data" => "No Data for Client Subscription!");
    // }




    //getAPIByClientSubscriptionId

    function getDataFromAPI($data)
    {


        //get  API (based on ID)
        //generate secret key

        // send to API
        //return thr reult getting from API


        // Prepare array
        //  array(":Contact", strip_tags($data["PhoneNumber"]));
        $params = array(
            array(":ClientSubscriptionID", (int)strip_tags($data["ClientSubscriptionID"]))
        );
        $query = "SELECT `ClientSubscriptionID`,`API`
    FROM `ClientSubscriptions` 
    WHERE `ClientSubscriptionID`=:ClientSubscriptionID;";
        $notices = DBController::sendData($query, $params);
        if ($notices) {
            $API = $notices['API'];
            $data = array(
                "Module" => "publics",
                "Page_key" => "getUserInfoBasedOnContact",
                "JSON" => array(
                    "Contact" => strip_tags($data['PhoneNumber']),
                    "Key" => "Test123"
                ),
                "MSC" => "751d31dd6b56b26b29dac2c0e1839e34"
            );
            //Key,Contact
            // Convert the array to JSON format
            $json = json_encode($data);
            $api_url = $API; //static for testing
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json)
            ));

            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                // echo 'Error: ' . curl_error($ch);
            } else {
                // echo $response;
            }
            curl_close($ch);
            $response = json_decode($response);

            if ($response->return_code == true)
                return array("return_code" => true, "return_data" =>  $response->return_data);
            else
                return array("return_code" => false, "return_data" =>  "Not associated with this number.");
        }
        return array("return_code" => false, "return_data" => "No Data for Client Subscription!");
    }


    function sendotp($data)
    {

        // function generateEncryptionKey()
        // {
        //     return openssl_random_pseudo_bytes(32); // 32 bytes for AES-256
        // }

        // function encryptData($datas, $key)
        // {
        //     $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        //     $encryptedData = openssl_encrypt($datas, 'aes-256-cbc', $key, 0, $iv);
        //     return [
        //         'data' => base64_encode($encryptedData),
        //         'iv' => base64_encode($iv)
        //     ];
        // }
        // $key = generateEncryptionKey();
        // $dataToEncrypt = strip_tags($data['PhoneNumber']);

        $params = array(
            array(":ClientSubscriptionID", (int)strip_tags($data["ClientSubscriptionID"]))
        );
        $query = "SELECT `ClientSubscriptionID`,`API`
    FROM `ClientSubscriptions` 
    WHERE `ClientSubscriptionID`=:ClientSubscriptionID;";
        $notices = DBController::sendData($query, $params);
        if ($notices) {
            $API = $notices['API'];
            $data = array(
                "Module" => "publics",
                "Page_key" => "getUserInfoBasedOnContact",
                "JSON" => array(
                    "Contact" => strip_tags($data['PhoneNumber']),
                    "Key" => "Test123"
                ),
                "MSC" => "751d31dd6b56b26b29dac2c0e1839e34"
            );
            //Key,Contact

            $json = json_encode($data);
            $api_url = $API; //static for testing
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json)
            ));

            // $encrypted = encryptData($dataToEncrypt, $key);

            // echo "Original Data: " . $dataToEncrypt . "\n";
            // echo "Encrypted Data: " . $encrypted['data'] . "\n";
            // echo "IV: " . $encrypted['iv'] . "\n";

            // function decryptData($encryptedData, $key, $iv)
            // {
            //     $data = openssl_decrypt(base64_decode($encryptedData), 'aes-256-cbc', $key, 0, base64_decode($iv));
            //     return $data;
            // }

            // $decryptedData = decryptData($encrypted['data'], $key, $encrypted['iv']);

            // echo "Decrypted Data: " . $decryptedData . "\n";
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                // echo 'Error: ' . curl_error($ch);
            } else {
                // echo $response;
            }
            curl_close($ch);
            $response = json_decode($response);

            if ($response->return_code == true)
                return array("return_code" => true, "return_data" => "Send OTP");
            else
                return array("return_code" => false, "return_data" =>  "Not associated with this number.");
        }
        return array("return_code" => false, "return_data" => "No Data for Client Subscription!");
    }
}
