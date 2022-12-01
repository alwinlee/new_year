<?php
    header("Content-Type: text/html; charset=utf-8");
    require_once("./api/lib/connmysql.php");
    session_start();
    date_default_timezone_set('Asia/Taipei');
    $nowDate=date('Y-m-d');

    // 將SESSION資料清除，並重導回首頁
    unset($_SESSION["account"]);
    unset($_SESSION["username"]);
    unset($_SESSION["auth"]);
    unset($_SESSION["userlevel"]);
    unset($_SESSION["key"]);
    unset($_SESSION["group"]);
    unset($_SESSION["subgroup"]);
    unset($_SESSION["groupexpire"]);
    unset($_SESSION["area"]);
    unset($_SESSION["expireday"]);
    unset($_SESSION["expire1"]);
    unset($_SESSION["expire2"]);
    unset($_SESSION["expire3"]);
    unset($_SESSION["expire4"]);
    unset($_SESSION["expire5"]);
    unset($_SESSION["expire6"]);
    unset($_SESSION["expire7"]);
    unset($_SESSION["expire8"]);
    unset($_SESSION["expire9"]);
    unset($_SESSION["expire10"]);
    unset($_SESSION["expire11"]);
    unset($_SESSION["expire12"]);
    unset($_SESSION["expire13"]);
    unset($_SESSION["expire14"]);
    unset($_SESSION["expire15"]);
    unset($_SESSION["expire16"]);
    unset($_SESSION["expire17"]);
    unset($_SESSION["expire18"]);
    unset($_SESSION["expire19"]);
    unset($_SESSION["expire20"]);

    //查詢登入會員資料
    $sql="select * from `member_newyear` where `account`='".$_POST["account"]."' and `password`=PASSWORD('".$_POST["password"]."')";
    $record=mysql_query($sql);
    $numrows=mysql_num_rows($record);
    if($numrows<=0){unset($_SESSION["area"]);header("Location: index.php");exit;}

    $row=mysql_fetch_array($record, MYSQL_ASSOC);
    $expire_date=$row["expire"];
    $today_date=new DateTime();
    $today_date=date_format($today_date, 'Y-m-d');
    //echo strtotime($expire_date)."-expire_date<br>";
    //echo strtotime($today_date)."-today_date<br>";
    if (strtotime($today_date) > strtotime($expire_date)){//帳號過期
        unset($_SESSION["area"]);
        unset($_SESSION["username"]);
        unset($_SESSION["account"]);
        unset($_SESSION["username"]);
        unset($_SESSION["userlevel"]);
        unset($_SESSION["auth"]);
        unset($_SESSION["key"]);
        unset($_SESSION["expireday"]);
        unset($_SESSION["expire"]);
        header("Location: index.php");
        //echo "account expire";
        exit;
    }else {
        //echo "account not expire";
        //exit;
    }

    // success - keep session data
    $_SESSION["account"]=$row["account"];
    $_SESSION["username"]=$row["name"];
    $_SESSION["userlevel"]=$row["level"];
    $_SESSION["auth"]=$row["auth"];
    $_SESSION["key"]=$row["key"];
    $_SESSION["area"]="newyear";
    $_SESSION["expireday"]=$row["expire"];

    $_SESSION["group"]=$row["group"];
    $_SESSION["subgroup"]=$row["subgroup"];
    $_SESSION["groupexpire"]=$row["groupexpire"];
    $_SESSION["expire"]=$row["expire"];
    $_SESSION["expire1"]=$row["expire1"];
    $_SESSION["expire2"]=$row["expire2"];
    $_SESSION["expire3"]=$row["expire3"];
    $_SESSION["expire4"]=$row["expire4"];
    $_SESSION["expire5"]=$row["expire5"];
    $_SESSION["expire6"]=$row["expire6"];
    $_SESSION["expire7"]=$row["expire7"];
    $_SESSION["expire8"]=$row["expire8"];
    $_SESSION["expire9"]=$row["expire9"];
    $_SESSION["expire10"]=$row["expire10"];
    $_SESSION["expire11"]=$row["expire11"];
    $_SESSION["expire12"]=$row["expire12"];
    $_SESSION["expire13"]=$row["expire13"];
    $_SESSION["expire14"]=$row["expire14"];
    $_SESSION["expire15"]=$row["expire15"];
    $_SESSION["expire16"]=$row["expire16"];
    $_SESSION["expire17"]=$row["expire17"];
    $_SESSION["expire18"]=$row["expire18"];
    $_SESSION["expire19"]=$row["expire19"];
    $_SESSION["expire20"]=$row["expire20"];
    header("Location: ./pages/main.php");
    exit;
