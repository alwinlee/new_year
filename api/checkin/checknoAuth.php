<?php
//    session_start();
//    if(isset($_SESSION["account"])==false||$_SESSION["account"]==""){
//        $code=-2;
//        $desc="auth failed";
//        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
//    }

    header("Content-type: application/json; charset=utf-8");   
    require_once("../lib/connmysql.php");
    ini_set("error_reporting",0);
    ini_set("display_errors","Off"); // On : open, O 
    
    $code=-1;
    $desc="data unknown";   
    $data=json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['id'])==false||isset($data['checkin'])==false||isset($data['go'])==false){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    $id = $data['id'];
    $checkin = $data['checkin'];
    $go = $data['go'];
    if($id <= 0 || $checkin < 0 || $checkin > 1){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    //更新學生報到資料
    $sql="update student set `checkin`=".$checkin.", `realgo`='".$go."' where `id`=".$id." limit 1";
    $record=mysql_query($sql);
    
    $code=1;
    $desc="success";
    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$record);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

