<?php
    session_start();
    if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="newyear"){
        $json_ret=array("draw"=>$draw,"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>"");
        echo json_encode($json_ret);
        exit;
    }

    header("Content-type: application/json; charset=utf-8");
    require_once("../lib/connmysql.php");
    require_once("../lib/common.php");
    ini_set("error_reporting",0);
    ini_set("display_errors","Off"); // On : open, O

    $code=-1;
    $desc="data unknown";
    $data=json_decode(file_get_contents('php://input'), true);

    if(isset($data['data']['draw'])==false||isset($data['data']['start'])==false||isset($data['data']['length'])==false||isset($data['data']['type'])==false){
        $json_ret=array("draw"=>$draw,"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>"");
        echo json_encode($json_ret);
        exit;
    }


    $draw=$data['data']['draw'];
    $start=$data['data']['start'];
    $length=$data['data']['length'];
    $type=$data['data']['type'];

    //查詢登入會員資料
    $sql="select * from `member` where `account`!='root' order by `idx` ";
    $record=mysql_query($sql);
    $numrows=mysql_num_rows($record);
    if($numrows<=0){
        $json_ret=array("draw"=>$draw,"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>"");
        echo json_encode($json_ret);
        exit;
    }

    while($row=mysql_fetch_array($record, MYSQL_ASSOC)) {
        $member[] = $row;
    }

    $sql="select COUNT(*) from `member_newyear` where `account`!='root'";
    $record=mysql_query($sql);
    $totalrows=100;
    $numrows=mysql_num_rows($record);
    if($numrows>0){
        $row1=mysql_fetch_array($record, MYSQL_NUM);
        $totalrows=$row1[0];
    }

    $code=1;
    $desc="success";
    $json_ret=array("draw"=>$draw,"recordsTotal"=>$totalrows,"recordsFiltered"=>$totalrows,"data"=>$member);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

