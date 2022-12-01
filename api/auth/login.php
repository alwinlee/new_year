<?php
    header("Content-type: application/json; charset=utf-8");
    require_once("../lib/connmysql.php");
    ini_set("error_reporting",0);
    ini_set("display_errors","Off"); // On : open, O

    $code=0;
    $desc="data unknown";
    unset($_SESSION["account"]);
    unset($_SESSION["auth"]);
    unset($_SESSION["area"]);
    unset($_SESSION["expire"]);

    $user=json_decode(file_get_contents('php://input'), true);

    if(isset($user['user'])==false||isset($user['user']['account'])==false||isset($user['user']['password'])==false){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }

    if($user['user']['account']==""||$user['user']['password']==""){
        $desc="data empty";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }

    session_start();
    $account=$user['user']['account'];
    $password=$user['user']['password'];

    //查詢登入會員資料
    $sql="select * FROM `member_newyear` where `account`='".$account."' AND `password`=PASSWORD('".$password."')";
    $record=mysql_query($sql);
    $numrows=mysql_num_rows($record);
    if($numrows<=0){
        $code=-1;
        $desc="data error";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    $row=mysql_fetch_array($record, MYSQL_ASSOC);
    // success - keep session data
    $_SESSION["account"]=$account;
    $_SESSION["username"]=$row["name"];
    $_SESSION["userlevel"]=$row["level"];
    $_SESSION["auth"]=$row["auth"];
    $_SESSION["key"]=$row["key"];
    $_SESSION["area"]="newyear";
    $_SESSION["expire"]=$row["expire"];
    $code=1;
    $desc="succcess";
    $json_ret=array("code"=>$code,"desc"=>$desc);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

