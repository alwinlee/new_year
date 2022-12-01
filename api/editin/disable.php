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
    $desc="data unknown.";   
    $jval=json_decode(file_get_contents('php://input'), true);
    
    if(isset($jval['userdata'])==false){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    $idx=intval($jval['userdata']['id']);
    $name=$jval['userdata']['name'];
    $tel=$jval['userdata']['tel'];
    $classroomid=$jval['userdata']['classroomid'];
    $classother=$jval['userdata']['classother'];
    if($idx<=0){
        $desc="data invalidate.";   
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    // check db exist
    $currY=date('Y');
    $currM=date('m');
    if ($currM>=10){$currY+=1;}
    $tbname="newyear_".$currY;
    check_newyear_db($tbname);
    
    // dup ... 剛好有另一個人資料重覆 => 另一個人變不重覆
    $sqldup="select `id` from `".$tbname."` where (`name`='".$name."' AND `tel`='".$tel."' AND `classroomid`='".$classroomid."' AND `classother`='".$classother."' AND `id`!=".$idx.")";
    $record=mysql_query($sqldup);
    $numrows=mysql_num_rows($record);
    if ($numrows==1){
        $row=mysql_fetch_array($record, MYSQL_ASSOC);
        $id=$row['id'];
        $sqlfreedup="update `".$tbname."` set `duplication`=0 where `id`=".$id.";";
        $record=mysql_query($sqlfreedup);
    }

    // check disable item
    $sql="update `".$tbname."` set `invalidate`=1 where `id`=".$idx.";"; 
    $ret=mysql_query($sql);
     if (!$ret) {
        $code=-1;
        $desc="delete failed!";
    } else {
        $code=1;
        $desc="success";        
    }

    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$ret);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

