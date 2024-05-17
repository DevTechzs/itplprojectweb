<?php

/**  Current Version: 1.0.0
 *  Createdby : Angelbert (01/02/2024)
 *  Created On:
 *  Modified By: 
 *  Modified On:
 */

namespace app\modules\documents\classes;

use app\database\DBController;
use \app\database\Helper;
use app\misc\URL;

class Documents
{
    /**
     * parameters{Title,Description,SDate,EDate,ApplicableFor,isAll,isPublic,File,Link,Staff[],Intern[]}
     *  Description: Add the Notice
     *  Createdby : Angelbert (01/02/2024)
     *  Updates:
     *    07-02-2024 (Angelbert):  Adding param in info so that it will be easy for future used   
     * 
     */

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
                //added by angelbert for admission fee receipt

            case "LETTER":
                $folder = 'letters/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;

            case "ADMISSION_FEE_RECEIPT":
                $folder = 'admissionfeereceipt/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                $fp = fopen($root . $folder . $filepath, "w+");
                fwrite($fp, ($document));
                fclose($fp);
                return $filepath;
            case "DOCUMENT":
                $folder = 'document/';
                $filepath =  date('y') . "/";
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .=  $Filename;
                break;
            case "PASSPORTPHOTO":
                $folder = 'passportphoto/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "FEEVERIFICATION":
                $folder = 'fee/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "FEE_RECEIPT":
                $folder = 'feereceipt/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                $fp = fopen($root . $folder . $filepath, "w+");
                fwrite($fp, ($document));
                fclose($fp);
                return $filepath;
                // case "HOMEWORK_ASSIGNMENT":
                //     $folder = 'elearning/' . Session::getCurrentSessionID() . '/student/';
                //     $filepath = '';
                //     if (!file_exists($root . $folder . $filepath)) {
                //         mkdir($root . $folder . $filepath, 0755, true);
                //     }
                //     $filepath .= $Filename;
                //     break;
            case "ELEARNING":
                $folder = 'courses/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "MEETING":
                $folder = 'meeting/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "EXAMINATION":
                $folder = 'examination/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "NOTICE":
                $folder = 'notice/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "FATHERPHOTO":
                $folder = 'fatherphoto/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "MOTHERPHOTO":
                $folder = 'motherphoto/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "GUARDIANPHOTO":
                $folder = 'guardianphoto/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;
            case "STUDENT":
                $folder = 'student/';
                $filepath = '';
                if (!file_exists($root . $folder . $filepath)) {
                    mkdir($root . $folder . $filepath, 0755, true);
                }
                $filepath .= $Filename;
                break;





            case "OTHERS":
                $folder = 'others/';
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
}
