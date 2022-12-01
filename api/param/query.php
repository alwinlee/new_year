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
    
    $tbname="param";

    $code=-1;
    $desc="data unknown";   
 
    //查詢資料
    $sql="select * from `".$tbname."` order by `id` ";
    $record=mysql_query($sql);
    $numrows=mysql_num_rows($record);
    if($numrows<=0){
        $code=-1;
        $desc="no data";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }

    while($row=mysql_fetch_array($record, MYSQL_ASSOC))
    {
        $param[] = $row;
    }
    
    $json_ret=array("code"=>1,"desc"=>"success","data"=>$param);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

