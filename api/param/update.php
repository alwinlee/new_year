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
    $tbname="param";

    $code=-1;
    $desc="data unknown";   
    $jsonval=json_decode(file_get_contents('php://input'), true);
    if(isset($jsonval['data']['group11S'])==false||isset($jsonval['data']['group11R'])==false||
       isset($jsonval['data']['group12S'])==false||isset($jsonval['data']['group12R'])==false||
       isset($jsonval['data']['group13S'])==false||isset($jsonval['data']['group13R'])==false||
       isset($jsonval['data']['group14S'])==false||isset($jsonval['data']['group14R'])==false||
       isset($jsonval['data']['group15S'])==false||isset($jsonval['data']['group15R'])==false){
       $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    $group11S=$jsonval['data']['group11S'];
    $group11R=$jsonval['data']['group11R'];
    $group12S=$jsonval['data']['group12S'];
    $group12R=$jsonval['data']['group12R'];
    $group13S=$jsonval['data']['group13S'];
    $group13R=$jsonval['data']['group13R'];
    $group14S=$jsonval['data']['group14S'];
    $group14R=$jsonval['data']['group14R'];
    $group15S=$jsonval['data']['group15S'];
    $group15R=$jsonval['data']['group15R'];
    
    //更新義工報到資料
    mysql_query("SET autocommit=0");	
    $sql="update `".$tbname."` set `valS`=".$group11S.",`valR`=".$group11R." where (`main`='善法實踐' AND `sub`='大組') limit 1";
    $record=mysql_query($sql);

    $sql="update `".$tbname."` set `valS`=".$group12S.",`valR`=".$group12R." where (`main`='善法實踐' AND `sub`='平安麵') limit 1";
    $record=mysql_query($sql);

    $sql="update `".$tbname."` set `valS`=".$group13S.",`valR`=".$group13R." where (`main`='善法實踐' AND `sub`='企業善法') limit 1";
    $record=mysql_query($sql);

    $sql="update `".$tbname."` set `valS`=".$group14S.",`valR`=".$group14R." where (`main`='善法實踐' AND `sub`='美食展') limit 1";
    $record=mysql_query($sql);

    $sql="update `".$tbname."` set `valS`=".$group15S.",`valR`=".$group15R." where (`main`='善法實踐' AND `sub`='傳心小組') limit 1";
    $record=mysql_query($sql);
    mysql_query("COMMIT");

    $code=1;
    $desc="success";
    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$record);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

