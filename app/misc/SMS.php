<?php

namespace app\misc;
use app\database\DBController;

class SMS
{

    /*
     * $SMSChannel = Channel on which SMS will be send
     * $Message = Message to be sent
     * $MobileNumber= Mobile number of target
     */
	public static function send($SMSChannel, $Message, $MobileNumber)
	{
		$messagecount = strlen($Message);
		$mesc = 1;

		while ($messagecount > 154) {
			$mesc = $mesc + 1;
			$messagecount = $messagecount - 154;
		}

		if (is_array($MobileNumber)){

            for($i=0;$i<count($MobileNumber);$i++){
                $param = array(
                    array(":SMS", $Message),
                    array(":ContactNo", $MobileNumber[$i]),
                    array(":SMSCount", $mesc)
                );

                $query = "INSERT INTO SMSDetails(SMS, ContactNo, SMSCount) VALUES (:SMS,:ContactNo,:SMSCount);";

                $result = DBController::ExecuteSQL( $query, $param);
            }
            $numbers = $MobileNumber;
        }else{
            $param = array(
                array(":SMS", $Message),
                array(":ContactNo", $MobileNumber),
                array(":SMSCount", $mesc)
            );

            $query = "INSERT INTO SMSDetails(SMS, ContactNo, SMSCount) VALUES (:SMS,:ContactNo,:SMSCount);";

            $result = DBController::ExecuteSQL( $query, $param);

            $numbers=array($MobileNumber);
        }

        if ($result) {
            $postDataJson = json_encode(
                array(
                    'sender' => $SMSChannel,
                    'campaign' => "Test",
                    'country' => "91",
                    'route' => "4",
                    'sms' => array(
                        array(
                            'message' => $Message,
                            'to' => is_array($numbers) ? $numbers : array($numbers)
                        )
                    )
                )
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.msg91.com/api/v2/sendsms",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $postDataJson,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_HTTPHEADER => array(
					"authkey: 154485AI3Y0WVke5b3b12aa",
					"content-type: application/json"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			$response = json_decode($response, true);
			curl_close($curl);

			if ($err == "" && $response['type'] == "success") {
				return true;
			} else {
				return false;
			}
		}else {
			return false;
		}
	}
}
