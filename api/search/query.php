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
    
    if(isset($data['keyword'])==false||$data['keyword']==""){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    $keyword = $data['keyword'];
    
    //查詢登入會員資料
    $sql="select * from `student` where (`group` LIKE '%".$keyword."%' OR `sn` LIKE '%".$keyword."%' OR `name` LIKE '%".$keyword."%' OR `cp` LIKE '%".$keyword."%'  OR `school` LIKE '%".$keyword."%') order by `id`";
    $record=mysql_query($sql);	
    $numrows=mysql_num_rows($record);
    if($numrows<=0){
        $code=0;
        $desc="data not found";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }    
    
    while($row=mysql_fetch_array($record, MYSQL_ASSOC))
    {
        $student[] = $row;
    }
    
    $traffitem=array("台北專車","桃園專車","新竹專車","台中專車","台南專車","高雄專車","火車站接駁","自行前往","");//台北專車,桃園專車,新竹專車,台中專車,台南專車,高雄專車,火車站接駁,自行前往
    $trafffee=array(500,460,450,275,200,150,0,0,0);
    $code=1;
    $desc="success";
    $json_ret=array("code"=>$code,"desc"=>$desc,"student"=>$student,"trafficitem"=>$traffitem,"trafficfee"=>$trafffee);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

