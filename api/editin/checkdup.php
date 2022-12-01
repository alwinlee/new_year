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
    //$sql="select * from `".$tbname."` where (`name`='".$jsonval['data']['name']."' AND `tel`='".$jsonval['data']['tel']."' AND `classroomid`='".$jsonval['data']['classroomid']."')";
    $sql="select * from `".$tbname."` where (`name`='".$jsonval['data']['name']."' AND `tel`='".$jsonval['data']['tel']."' AND (`classroomid`='".$jsonval['data']['classroomid']."' AND `classother`='".$jsonval['data']['classother']."' ))";
    $record=mysql_query($sql);
    $numrows=mysql_num_rows($record);
    if ($numrows>0) {
        $code=1;
        $desc="duplication!";
        $record=false;
    } else {
        $code=0;
        $desc="no duplication data";
        $record=true;
    }

    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$record);
    $ret = json_encode($json_ret);
    echo $ret;//header("Content-Type: text/html; charset=utf-8");
?>

