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
    
    if(isset($data['data']['keyword'])==false||$data['data']['keyword']==""||isset($data['data']['draw'])==false){
        $json_ret=array("draw"=>$draw,"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>"");
        echo json_encode($json_ret);
        exit;
    }    
    if(isset($data['data']['start'])==false||isset($data['data']['length'])==false){
        $json_ret=array("draw"=>$draw,"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>"");
        echo json_encode($json_ret);
        exit;
    }  
    
    $keyword=$data['data']['keyword'];
    $draw=$data['data']['draw'];
    $start=$data['data']['start'];
    $length=$data['data']['length'];
    
    //查詢登入會員資料
    $sql="select * from `".$tbname."` where ((`name` LIKE '%".$keyword."%' OR `tel` LIKE '%".$keyword."%') AND `invalidate`<=0) order by `id` limit ".$start.",".($length);
 
    $record=mysql_query($sql);	
    $numrows=mysql_num_rows($record);
    if($numrows<=0){
        $json_ret=array("draw"=>$draw,"recordsTotal"=>0,"recordsFiltered"=>0,"data"=>"");
        echo json_encode($json_ret);
        exit;
    }
    $totalrows=$numrows;
    while($row=mysql_fetch_array($record, MYSQL_ASSOC))
    {
        $member[] = $row;
    }
    
    $sql="select COUNT(*) from `".$tbname."` where ((`name` LIKE '%".$keyword."%' OR `tel` LIKE '%".$keyword."%')  AND `invalidate`<=0)";
    $record=mysql_query($sql);    
    $numrows=mysql_num_rows($record);
    if($numrows>0){
        $row1=mysql_fetch_array($record, MYSQL_NUM);
        $totalrows=$row1[0];
    }    
    
    $json_ret=array("draw"=>$draw,"recordsTotal"=>$totalrows,"recordsFiltered"=>$totalrows,"data"=>$member);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

