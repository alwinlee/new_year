<?php
    session_start();
    if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="newyear"){
        $code=-2;
        $desc="auth failed";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }

    header("Content-type: application/json; charset=utf-8");   
    require_once("../lib/connmysql.php");
    require_once("../lib/common.php");

    ini_set("error_reporting",0);
    ini_set("display_errors","Off"); // On : open, O 
    
    $code=-1;
    $desc="data unknown";   
    $jsonval=json_decode(file_get_contents('php://input'), true);
    
    if(isset($jsonval['result'])==false||isset($jsonval['data'])==false||$jsonval['result']==false){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }

    // check db exist
    $currY=date('Y');
    $currM=date('m');
    if ($currM>=10){$currY+=1;}
    $tbname="newyear_".$currY;
    check_newyear_db($tbname);
    
    // check duplication
    if($jsonval['data']['duplication']>0){
        $sql="update `".$tbname."` set `duplication`=1 where (`name`='".$jsonval['data']['name']."' AND `tel`='".$jsonval['data']['tel']."' AND (`classroomid`='".$jsonval['data']['classroomid']."' OR `classother`='".$jsonval['data']['classother']."' ))";
        $record=mysql_query($sql);
    }

    // check barcode
    $sql="select `tel`, `barcode` from `".$tbname."` where `tel`='".$jsonval['data']['tel']."' order by `barcode` DESC";
    $record=mysql_query($sql);
    $numrows=mysql_num_rows($record);
    $barcodeserial=1;
    if ($numrows>0){
        $row=mysql_fetch_array($record, MYSQL_ASSOC);
        $tel=$jsonval['data']['tel'];
        $string=str_replace($tel, '', $row["barcode"]);
        $barcodeserial=(int)$string;
        $barcodeserial+=1;
    }
    $barcode=$jsonval['data']['tel'].str_pad($barcodeserial, 3, '0', STR_PAD_LEFT); 

    // insert to db
    $sql="INSERT INTO `".$tbname."` VALUES (NULL,";
    $sql.="'".$barcode."',";//$sql.="'".$jsonval['data']['barcode']."',";    
    $sql.="'".$jsonval['data']['name']."',";
    $sql.="'".$jsonval['data']['tel']."',";    
    $sql.="'".$jsonval['data']['sex']."',";
    $sql.=$jsonval['data']['age'].",";
    $sql.="'".$jsonval['data']['area']."',";
    $sql.="'".$jsonval['data']['classarea']."',";  
    $sql.="'".$jsonval['data']['classroom']."',";  
    $sql.="'".$jsonval['data']['classroomid']."',";
    $sql.="'".$jsonval['data']['classother']."',";
    $sql.="'".$jsonval['data']['group']."',";  
    $sql.="'".$jsonval['data']['subgroup']."',";
    
    $sql.="'".$jsonval['data']['join']."',";
    $sql.=$jsonval['data']['join1'].",";
    $sql.=$jsonval['data']['join2'].",";
    $sql.=$jsonval['data']['join3'].",";
    $sql.=$jsonval['data']['join4'].",";
    $sql.=$jsonval['data']['join5'].",";
    $sql.=$jsonval['data']['join6'].",";
    $sql.=$jsonval['data']['join7'].",";
    $sql.=$jsonval['data']['join8'].",";
    $sql.=$jsonval['data']['join9'].",";
    $sql.=$jsonval['data']['joinx'].",";
    
    $sql.="'".$jsonval['data']['live']."',";    
    $sql.=$jsonval['data']['live1'].",";    
    $sql.=$jsonval['data']['live2'].",";    
    $sql.=$jsonval['data']['live3'].",";    
    $sql.=$jsonval['data']['live4'].",";  
    $sql.=$jsonval['data']['live5'].",";    
    $sql.=$jsonval['data']['live6'].",";  
    $sql.=$jsonval['data']['live7'].",";    
    $sql.=$jsonval['data']['live8'].",";  
    $sql.=$jsonval['data']['live9'].",";    
    $sql.=$jsonval['data']['livex'].",";  
    
    $sql.="'".$jsonval['data']['livewhere']."',";  
    $sql.="'".$jsonval['data']['liveroom']."',";  
    $sql.="'".$jsonval['data']['type']."',";
    $sql.=$jsonval['data']['notify'].",";
    $sql.="'".$jsonval['data']['specialcase']."',";
    $sql.="'".$jsonval['data']['request']."',";
    $sql.="'".$jsonval['data']['trafficgo']."',";
    $sql.="'".$jsonval['data']['trafficback']."',";    
    $sql.=$jsonval['data']['pay'].",";
    $sql.=$jsonval['data']['trafficself'].",";
    $sql.="'".$jsonval['data']['joinclean']."',";
    $sql.="'".$jsonval['data']['trafficclean']."',";
    $sql.="'".$jsonval['data']['memo']."',";
    $sql.="'".$jsonval['data']['applydate']."',";
    $sql.="'".$jsonval['data']['applyby']."',";
    
    $sql.=$jsonval['data']['checkin'].",";    
    $sql.=$jsonval['data']['checkin1'].",";    
    $sql.=$jsonval['data']['checkin2'].",";    
    $sql.=$jsonval['data']['checkin3'].",";    
    $sql.=$jsonval['data']['checkin4'].",";  
    $sql.=$jsonval['data']['checkin5'].",";    
    $sql.=$jsonval['data']['checkin6'].",";  
    $sql.=$jsonval['data']['checkin7'].",";    
    $sql.=$jsonval['data']['checkin8'].",";  
    $sql.=$jsonval['data']['checkin9'].",";    
    $sql.=$jsonval['data']['checkinx'].",";  

    $sql.=$jsonval['data']['duplication'].",";
    $sql.=$jsonval['data']['invalidate'];
    $sql.=");";
    $record=mysql_query($sql);

    if (!$record) {
        $code=-1;
        $desc="record insert failed!";//.$sql;
    } else {
        $code=1;
        $desc="success";        
    }

/*
    //require_once("../../resource/barcode/barcode.php");
    require_once("../../resource/barcode/BarcodeGenerator.php");
    require_once("../../resource/barcode/BarcodeGeneratorPNG.php");
    require_once("../../resource/barcode/BarcodeGeneratorJPG.php");

    header("Content-type: image/jpeg");
    $generatorJPG = new Picqer\Barcode\BarcodeGeneratorJPG();
    $img=$generatorJPG->getBarcode('081231723897', $generatorJPG::TYPE_CODE_128);
    $savefolder="C:/Windows/Temp/images/";//$_SERVER['DOCUMENT_ROOT'] . "/images/";
    //chmod($savefolder, 775);
    $write=is_writable($savefolder);
    $save=$savefolder.strtolower($barcode) . ".jpg";
    $re=imagejpeg($img, $save);
    imagedestroy($img);
    header("Content-type: application/json; charset=utf-8");
*/

    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$record);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

