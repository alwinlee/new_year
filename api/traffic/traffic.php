<?php
    session_start();
    if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="zucamp"){
        $code=-2;
        $desc="auth failed";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }

    header("Content-type: application/json; charset=utf-8");   
    require_once("../lib/connmysql.php");
    ini_set("error_reporting",0);
    ini_set("display_errors","Off"); // On : open, O 
    
    $code=-1;
    $desc="data unknown";   
    $data=json_decode(file_get_contents('php://input'), true);
    
    if(isset($data['id'])==false||isset($data['go'])==false||isset($data['back'])==false){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    $id=$data['id'];
    $go=$data['go'];
    $back=$data['back'];    
    if($id<=0){
        $desc="id error"; 
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    //更新學生報到資料

    
    if($go!="NULL"&&$back!="NULL"){
        $sql="update `student` set `realgo`='".$go."',`realback`='".$back."' where `id`=".$id." limit 1";
    }elseif($go!="NULL"){
        $sql="update `student` set `realgo`='".$go."' where `id`=".$id." limit 1";
    }elseif($back!="NULL"){
        $sql="update `student` set `realback`='".$back."' where `id`=".$id." limit 1";
    }else{
        $desc="no update"; 
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    mysql_query("SET autocommit=0");
    $result=mysql_query($sql);
    mysql_query("COMMIT");
    
    // 重新讀取-供資料比對    
    //$sql="select * from `student` where `id`=1";
    /*
    $sql="select * from `student` where `id`=1";//"select `id`,`realgo`,`realback` from `student` where `id`=".$id;
    $result=mysql_query($sql);
    $numrows=mysql_num_rows($result);
    if($numrows<=0){
        $code=-1;
        $desc="update failed";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    $row=mysql_fetch_array($result, MYSQL_ASSOC);
    $traffic[] = $row;
    */
    
    /*
    如果 (去程或回程其中有一樣變更) 
    {
        如果((已繳金額)-(去程確定金額+回程確定金額)) < 0
        {
            補費用  : ((去程確定金額+回程確定金額) - (已繳金額));
        }
        否則
        {
            什麼事都沒發生; (PS : 不用補繳也不用退費);
        }        
    } 
    否則 
    {
        如果 ((已繳金額)-(原去程金額+原回程金額) > 0 且剛好 = (原去程金額+原回程金額))
        {
            退費用:(原去程金額+原回程金額);
        }
        否則 如果 ((已繳金額)-(原去程金額+原回程金額) < 0)
        {
            補費用:((已繳金額)-(原去程金額+原回程金額));
        }
        否則
        {
            什麼事都沒發生;
        }
    }
*/
    
    
    
    $code=1;
    $desc="success";
    
    $traffitem=array("台北專車","桃園專車","新竹專車","台中專車","台南專車","高雄專車","火車站接駁","自行前往","");//台北專車,桃園專車,新竹專車,台中專車,台南專車,高雄專車,火車站接駁,自行前往
    $trafffee=array(500,460,450,275,200,150,0,0,0);
    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$result,"trafficitem"=>$traffitem,"trafficfee"=>$trafffee);//,"traffic"=>$traffic);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

