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
    
    // check db exist
    $currY=date('Y');
    $currM=date('m');
    if ($currM>=10){$currY+=1;}
    $tbname="newyear_".$currY;
    check_newyear_db($tbname);
    
    $code=-1;
    $desc="data unknown";   
    $data=json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['id'])==false||isset($data['livewhere'])==false){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    $id=$data['id'];
    $livewhere=$data['livewhere'];
    if ($livewhere=="0"||$livewhere=="-"){
        $livewhere="";
    }

    if($id<=0){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    //更新義工報到資料
    $sql="update `".$tbname."` set `livewhere`='".$livewhere."' where `id`=".$id." limit 1";
    $record=mysql_query($sql);
    
    $code=1;
    $desc="success";
    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$record);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

