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
    
    if(isset($data['keyword'])==false||$data['keyword']==""){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    $keyword = $data['keyword'];
    
    //查詢登入會員資料
    $sql="select * from ".$tbname." where (`barcode` LIKE '%".$keyword."%' OR `name` LIKE '%".$keyword."%') order by `id`";
    $record=mysql_query($sql);	
    $numrows=mysql_num_rows($record);
    if($numrows<=0){
        $code=0;
        $desc="data not found - ".$sql;
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }    
    
    while($row=mysql_fetch_array($record, MYSQL_ASSOC))
    {
        $member[] = $row;
    }
    
    $code=1;
    $desc="success";
    $json_ret=array("code"=>$code,"desc"=>$desc,"member"=>$member);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

