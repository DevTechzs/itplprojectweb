<?php

 namespace app\modules\filemanager;

use app\database\DBController;
use app\misc\AES;
// use app\misc\GenerateQR;
// use app\misc\Sodium;
// use app\misc\VideoStream; 
use app\modules\settings\classes\Session;

class FileController
{
    static function File()
    {
        $imagetypes = array("zeroindex","jpeg", "jpg", "png", "svg", "tiff");
        $documenttypes=array("zeroindexdoc","doc","docx","pdf","html","xls","xlsx","txt"); 

        $path = "../app/data/"; 
        $filetype = strtolower($_GET['type']);

        switch ($filetype) {

            case 'image':
                $file = $path . "images/" . $_GET['name'];
                    if( !isset( $_GET['name']) || $_GET['name']==null || $_GET['name']=='') {
                        header("HTTP/1.0 404 Not Found");
                        exit;
                    }
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Image Transfer');
                    header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                    exit;
                }
                break;
                
            case 'qr':
                $file = $path . "qr/" . $_GET['name'];
                self::loadDocument($file);
                break;
            
            //  case 'others': 
             case 'student': 
             case 'fatherphoto':
             case 'guardianphoto': 
             case 'motherphoto':
                $file = $path . $filetype."/" . $_GET['name'];
                FileController::loadDocument(  $file); 
                break;

            case 'passportphoto':
            case 'PassportPhoto':
                if( !isset( $_GET['name']) || $_GET['name']==null || $_GET['name']=='') {
                    //header("HTTP/1.0 404 Not Found");
                     exit;
                }
                $file = $path . "PassportPhoto/" . $_GET['name'];

                if (file_exists($file)) {
                    $headers = headers_list();

                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Image Transfer');
                    header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                   // header("Content-Encoding: gzip");
                   // header('Connection: Keep-Alive');
                   // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                     $headers = headers_list();

                
                    @readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                    header('Content-Description: Image Transfer');
                    header('Content-Type: image/png');
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    // header('Content-Length: ' . filesize($path . "passportphoto/student.png"));
                    readfile($path . "PassportPhoto/student.png");
                    exit;
                }

                break;
            case 'schoollogo':
                $file = $path . "schoollogo/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Image Transfer');
                    header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                    exit;
                }


            case 'document':
                 $file = $path . "documents"."/" . $_GET['name'];
                self::loadDocument($file);
                exit;

                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Document transfer');
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
                        header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                      }
                    else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
                        if($extension== "xlsx"){  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); }
                        else if ($extension== "xls"){  header('Content-Type: application/vnd.ms-excel'); }
                        else header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
 
                        }
                    else
                    {
                         header('Content-Type: ' . mime_content_type($file)); 
                    }

                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                     exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
            case 'marksheet':
            case 'certificate': 
                $file = $path . $filetype."/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Document transfer');
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
                        header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                      }
                    else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
                        if($extension== "xlsx"){  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); }
                        else if ($extension== "xls"){  header('Content-Type: application/vnd.ms-excel'); }
                        else header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
 
                        }
                    else
                    {
                         header('Content-Type: ' . mime_content_type($file)); 
                    }

                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;


            case 'certificate':
                $file = $path . "certificate/" . $_GET['name'];

                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Image Transfer');
                    header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
            case 'answerqr':

                //                $qrdata = json_decode(Sodium::safeDecrypt("CyOMPwKsPQuReqaGKM7cJrlcbcH3uGfBBXADTUINEgON1BHrGkgvRN82cHmXzU9t5aiMQfsUdj87O3UkpoWIeHqCA1QBwgUiHOiE1zLIV8N9/GB1aLnTrjmKWw01yLto7Qy2j73FnWi3HEM5haRb1SGDy5fdatOEShs5ieIKHtpCkR/FTeoy xpjVLsZmOuFf0985CrZPOgIm40vNRgr N5rLgyO5YZpcVofZOb3UDGyKnUDrwrJ5gecfYN54txR0R7WInqCSLGDuuZK2430V4RSISAI 2SrRRXz5gs98IcNaGN6JhSBCQES/RyJdd10aFRh6 YmDgg7d/L D3OLlKhfJOwueGUdWi0067xilBsy98fAiCw="));

                header('Content-Type: image/png');
                $qrdata = json_encode(
                    [
                        "ExaminationAllotmentID" => $_GET['ExaminationAllotmentID'],
                        "AssessmentDetailsID" => $_GET['AssessmentDetailsID'],
                        "UserID" => $_SESSION['UserID'],
                        "SessionKey" => $_SESSION['SessionKey'],
                        "CreationDate" => AES::encrypt(date("Y-m-d H:i:s"))
                    ]
                );
                $qrdata = AES::encrypt($qrdata);

                $link = pathinfo((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);

                $qrdata = urlencode($qrdata);

                $url = $link["dirname"] . "/uploadanswer?question=" . $qrdata;

                //                $qrdata=AES::decrypt(urldecode($qrdata));


              //  GenerateQR::get($url, 500);
                exit;
                break;
            case 'admission':
                $file = $path . "admissions/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Document Transfer');
                    header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }

            case 'fee':
                $file = $path . "fee/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Document Transfer');
                    header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
            case 'fee_receipt':
                $file = $path . "feereceipt/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Document Transfer');
                    header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;

            case 'meeting':
                $file = $path . "meeting/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Document Transfer');
                    header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;


            case 'html':
                $file = $path . "elearning/" . $_GET['sid'] . '/' . $_GET['cid'] . '/pages/' . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Type: text/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }

            case 'homeassign':
                $file = $path . "elearning/" . $_GET['sid'] . '/' . $_GET['cid'] . '/homeassign/' . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Description: Document Transfer');
                    header("Content-Encoding: gzip");
                    header('Connection: Keep-Alive');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');                    
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;

            case 'viewhomeassign':
                if(!isset($_GET['sid']))
                    $sid=  Session::getCurrentSessionID(); //current sessionID
                else
                    $sid=$_GET['sid'];

                $file = $path . "elearning/" .  $sid . '/student/' . $_GET['name'];
                if (file_exists($file)) {

                    FileController::loadDocument($file);
                    // header('HTTP/1.0 200 OK');
                    // header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    // header('Expires: 0');
                    // header('Cache-Control: must-revalidate');
                    // header('Pragma: public');
                    // header('Content-Length: ' . filesize($file));
                    // readfile($file);
                    // exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;

                /* updated on 14-02-2022 */
            case 'video':
                $file = $path . "elearning/" . $_GET['sid'] . '/' . $_GET['cid'] . '/videos/' . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    header('Content-Type: video/' .  $extension);

                    //header('Content-Type: video/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
                // for elearning only (Not to be confuse with 'document' as mention above)
            case 'documents':
                $file = $path . "elearning/" . $_GET['sid'] . '/' . $_GET['cid'] . '/documents/' . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;

            case 'grievance':
             
                $file = $path . "grievance/" . $_GET['sid'] . '/' . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK'); 
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
                        header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                       // header('Content-Type: image/' .$extension);  // strtolower(substr(strrchr(basename($file), "."), 1))
                    }
                    else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
                            //  header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                        header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                    }
                    else
                    {
                        header('Content-Type: ' . mime_content_type($file)); 
                    }
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;

            case 'examination':
                $file = $path . "examination/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
                        header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                     }
                    else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
                        header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                            //  header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    }
                    else
                    {
                        header('Content-Type: ' . mime_content_type($file)); 
                    } 
                     // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
              /* TC section starts here */
            case 'tc':
                $file = $path . "tc/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
                        header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                     }
                    else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
                        header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                            //  header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    }
                    else
                    {
                        header('Content-Type: ' . mime_content_type($file)); 
                    } 
                     // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
            /* TC section ends here */

            /* Gallery section starts here */
            case 'gallery':
                $file = $path . "gallery/" . $_GET['name'];
                 if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
 
                        header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                     }
                    else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
 
                        header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                            //  header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    }
                    else
                    {
 
                        header('Content-Type: ' . mime_content_type($file)); 
                    } 
                     // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
 
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
            /* Gallery section ends here */

            /* Custom Notice section starts here */
            case 'notice':
                $file = $path . "notice/" . $_GET['name'];
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    $extension= pathinfo($file, PATHINFO_EXTENSION);
                    if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
                        header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
                    }
                    else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
                        header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1)));
                            //  header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    }
                    else
                    {
                        header('Content-Type: ' . mime_content_type($file)); 
                    } 
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
            /* Custom Notice section ends here */
            case 'log':
                $file = "../log.txt";
                if (file_exists($file)) {
                    header('HTTP/1.0 200 OK');
                    header('Content-Type: text/plain');
                    // header('Content-Disposition: attachment; filename="' . preg_replace("/\.[^.]+$/", "", basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                break;
            default:
                // session_destroy();
                include '404.php';
                header('HTTP/1.1 401  Unauthorized Access');
                header("Status: 401 ");
                break;
        }
    }

    static function loadDocument($file){
       
        $imagetypes = array("zeroindex","jpeg", "jpg", "png", "svg", "tiff");
        $documenttypes=array("zeroindexdoc","doc","docx","pdf","html","xls","xlsx","txt"); 

        $path = "../app/data/"; 
        if (file_exists($file)) {
            header('HTTP/1.0 200 OK');
            $extension= pathinfo($file, PATHINFO_EXTENSION); 
            if( array_search($extension,$imagetypes)!=false && array_search($extension,$imagetypes)>=0){
                header('Content-Type: image/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
              }
            else if(array_search($extension,$documenttypes)!=false && array_search($extension,$documenttypes)>=0){
                if($extension== "xlsx"){  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); }
                else if ($extension== "xls"){  header('Content-Type: application/vnd.ms-excel'); }
                else header('Content-Type: application/' . strtolower(substr(strrchr(basename($file), "."), 1))); 
     
                }
            else
            {
                 header('Content-Type: ' . mime_content_type($file)); 
            } 
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
             exit;

        }
        

      
    }
}
?>