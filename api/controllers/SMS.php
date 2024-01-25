<?php

 // use api\controllers\database\DBController;
// use api\misc\mailer\PHPMailer\PHPMailer\Exception;

 
class SMS
{

    /*
     * $SMSChannel = Channel on which SMS will be send
     * $Message = Message to be sent
     * $MobileNumber= Mobile number of target
     */



    public static function SendSms($flowname, $mobiles,$variables)
    {
        //check if the flow
        //    return true;
        //setup parameter
        $params = array(
            array(":FlowName", $flowname)
        );
        $query= "SELECT SMSID, TemplateID, FlowID, SMSText, SMSVariables, CreatedOn, ModifiedOn FROM SMSTemplate WHERE FlowName=:FlowName ";


        $data =DBController::sendData($query, $params);;
        if ($data){
            $message = $data['SMSText'];

            $param = [
                "flow_id" => $data['FlowID'],
                "recipients" => []
            ];

            foreach($variables as $x => $val)
            {
                $message = str_replace("##".$x."##",$val,$message);
            }

            foreach(explode(",",$mobiles) as $m)
            {
                $recp = [
                    "mobiles"=> "91".substr($m, -10)
                ];
                $recp = array_merge($recp, $variables);
                array_push($param["recipients"],$recp);
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.msg91.com/api/v5/flow/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($param),
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'authkey: 154485AU8JnX9cnIBs61fcf373P1'
                ),
            ));

            $response="";
             $response = curl_exec($curl);
             $smsres = json_decode($response,true);
             $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                //save message to DB
                DBController::logs($err);
                $emessage= $err;
                return $emessage;
            } else {
                //UPDAYE TO THE DATABASE
            try{

                    $messagecount = strlen($message);
                    $mesc = 1;

                    while ($messagecount > 154) {
                        $mesc = $mesc + 1;
                        $messagecount = $messagecount - 154;
                    }
                    $mobiles=explode(",",$mobiles);
                    for($i=0;$i<count($mobiles);$i++){
                        $param = array(
                            array(":SMS", $message),
                            array(":ContactNo", $mobiles[$i]),
                            array(":SMSCount", $mesc),
                             array(":UserID",   isset($_SESSION['UserID'])? $_SESSION['UserID']:-1),

                        );

                        $query = "INSERT INTO SMSDetails(SMS, ContactNo, SMSCount,UserID  ) 
                                VALUES (:SMS,:ContactNo,:SMSCount,:UserID);";
                        $result = DBController::ExecuteSQL( $query, $param);
                    }


            }catch(Exception $e){
                DBController::logs("Unable to save the SMS details to the database");
            }

                return $response;
            }
        }

        return $data;
        // $certificate = "C:\cacert\cacert.pem";
    }

}
