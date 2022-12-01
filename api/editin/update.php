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
    
    $code=-1;
    $desc="data unknown";   
    $jsonval=json_decode(file_get_contents('php://input'), true);
    
    if(isset($jsonval['newjson'])==false||isset($jsonval['orijson'])==false){
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }
    
    // check db exist
    $currY=date('Y');
    $currM=date('m');
    if ($currM>=10){$currY+=1;}
    $tbname="newyear_".$currY;
    check_newyear_db($tbname);
    
    $jsonNew=$jsonval['newjson'];
    $jsonOri=$jsonval['orijson'];
    
    // special update - name, tel and classroom change - need check dup issue
    $barcode="";
    $dupNew=0;
    if ($jsonNew['name']!=$jsonOri['name']||$jsonNew['tel']!=$jsonOri['tel']||$jsonNew['classroomid']!=$jsonOri['classroomid']||$jsonNew['classother']!=$jsonOri['classother'])
    {
        // check barcode - need to change for new tel
        if ($jsonNew['tel']!=$jsonOri['tel']){
            $tel=$jsonNew['tel'];
            $sqltel="select `tel`, `barcode` from `".$tbname."` where `tel`='".$tel."' order by `barcode` DESC";
            $record=mysql_query($sqltel);
            $numrows=mysql_num_rows($record);
            $barcodeserial=1;
            if ($numrows>0){
                $row=mysql_fetch_array($record, MYSQL_ASSOC);                
                $string=str_replace($tel, '', $row["barcode"]);
                $barcodeserial=(int)$string;
                $barcodeserial+=1;
            }
            $barcode=$tel.str_pad($barcodeserial, 3, '0', STR_PAD_LEFT);             
        }
        
        // dup ... 1. 剛好有另一個人跟舊資料重覆 => 另一個人變不重覆
        $sqldup="select `id` from `".$tbname."` where (`name`='".$jsonOri['name']."' AND `tel`='".$jsonOri['tel']."' AND (`classroomid`='".$jsonOri['classroomid']."' AND `classother`='".$jsonOri['classother']."') AND `id`!=".$jsonOri['id'].")";
        $record=mysql_query($sqldup);
        $numrows=mysql_num_rows($record);
        if ($numrows==1){
            $row=mysql_fetch_array($record, MYSQL_ASSOC);
            $id=$row['id'];
            $sqlfreedup="update `".$tbname."` set `duplication`=0 where `id`=".$id.";";
            $record=mysql_query($sqlfreedup);
        }
        // dup ... 2. 新資料是否與他人重覆 => 他人與我設為重覆
        $sqldup="select * from `".$tbname."` where (`name`='".$jsonNew['name']."' AND `tel`='".$jsonNew['tel']."' AND (`classroomid`='".$jsonNew['classroomid']."' AND `classother`='".$jsonNew['classother']."'))";
        $record=mysql_query($sqldup);
        $numrows=mysql_num_rows($record);
        if ($numrows>0) {
            $dupNew=1;
            $sqldup="update `".$tbname."` set `duplication`=1 where (`name`='".$jsonNew['name']."' AND `tel`='".$jsonNew['tel']."' AND `classroomid`='".$jsonNew['classroomid']."' AND `classother`='".$jsonNew['classother']."')";
            $record=mysql_query($sqldup);
        }
    }
    // check update item
    $bClearLiveroom=false;
    $sql="update `".$tbname."` set `name`='".$jsonNew['name']."'";
    if ($barcode!=""){$sql.=",`barcode`='".$barcode."'";}
    if ($jsonNew['tel']!=$jsonOri['tel']){$sql.=",`tel`='".$jsonNew['tel']."'";}
    if ($jsonNew['sex']!=$jsonOri['sex']){$sql.=",`sex`='".$jsonNew['sex']."'"; $bClearLiveroom=true;}
    if ($jsonNew['age']!=$jsonOri['age']){$sql.=",`age`=".$jsonNew['age'];}
    if ($jsonNew['area']!=$jsonOri['area']){$sql.=",`area`='".$jsonNew['area']."'";}
    if ($jsonNew['classarea']!=$jsonOri['classarea']){$sql.=",`classarea`='".$jsonNew['classarea']."'";}
    if ($jsonNew['classroom']!=$jsonOri['classroom']){$sql.=",`classroom`='".$jsonNew['classroom']."'";}
    if ($jsonNew['classother']!=$jsonOri['classother']){$sql.=",`classother`='".$jsonNew['classother']."'";}
    if ($jsonNew['classroomid']!=$jsonOri['classroomid']){$sql.=",`classroomid`='".$jsonNew['classroomid']."'";}
    if ($jsonNew['group']!=$jsonOri['group']){$sql.=",`group`='".$jsonNew['group']."'";}
    if ($jsonNew['subgroup']!=$jsonOri['subgroup']){$sql.=",`subgroup`='".$jsonNew['subgroup']."'";}
    if ($jsonNew['join']!=$jsonOri['join']){$sql.=",`join`='".$jsonNew['join']."'";}
    if ($jsonNew['join1']!=$jsonOri['join1']){$sql.=",`join1`=".$jsonNew['join1'];}
    if ($jsonNew['join2']!=$jsonOri['join2']){$sql.=",`join2`=".$jsonNew['join2'];}
    if ($jsonNew['join3']!=$jsonOri['join3']){$sql.=",`join3`=".$jsonNew['join3'];}
    if ($jsonNew['join4']!=$jsonOri['join4']){$sql.=",`join4`=".$jsonNew['join4'];}
    if ($jsonNew['join5']!=$jsonOri['join5']){$sql.=",`join5`=".$jsonNew['join5'];}
    if ($jsonNew['join6']!=$jsonOri['join6']){$sql.=",`join6`=".$jsonNew['join6'];}
    if ($jsonNew['join7']!=$jsonOri['join7']){$sql.=",`join7`=".$jsonNew['join7'];}
    if ($jsonNew['join8']!=$jsonOri['join8']){$sql.=",`join8`=".$jsonNew['join8'];}
    if ($jsonNew['join9']!=$jsonOri['join9']){$sql.=",`join9`=".$jsonNew['join9'];}
    if ($jsonNew['joinx']!=$jsonOri['joinx']){$sql.=",`joinx`=".$jsonNew['joinx'];}
    if ($jsonNew['live']!=$jsonOri['live']){$sql.=",`live`='".$jsonNew['live']."'";}
    if ($jsonNew['live1']!=$jsonOri['live1']){$sql.=",`live1`=".$jsonNew['live1'];}
    if ($jsonNew['live2']!=$jsonOri['live2']){$sql.=",`live2`=".$jsonNew['live2'];}
    if ($jsonNew['live3']!=$jsonOri['live3']){$sql.=",`live3`=".$jsonNew['live3'];}
    if ($jsonNew['live4']!=$jsonOri['live4']){$sql.=",`live4`=".$jsonNew['live4'];}
    if ($jsonNew['live5']!=$jsonOri['live5']){$sql.=",`live5`=".$jsonNew['live5'];}
    if ($jsonNew['live6']!=$jsonOri['live6']){$sql.=",`live6`=".$jsonNew['live6'];}
    if ($jsonNew['live7']!=$jsonOri['live7']){$sql.=",`live7`=".$jsonNew['live7'];}
    if ($jsonNew['live8']!=$jsonOri['live8']){$sql.=",`live8`=".$jsonNew['live8'];}
    if ($jsonNew['live9']!=$jsonOri['live9']){$sql.=",`live9`=".$jsonNew['live9'];}
    if ($jsonNew['livex']!=$jsonOri['livex']){$sql.=",`livex`=".$jsonNew['livex'];}
    if ($bClearLiveroom){
        $sql.=",`livewhere`=''";
    }else{
        if ($jsonNew['livewhere']!=$jsonOri['livewhere']){$sql.=",`livewhere`='".$jsonNew['livewhere']."'";} 
    }
    
    if ($jsonNew['liveroom']!=$jsonOri['liveroom']){$sql.=",`liveroom`='".$jsonNew['liveroom']."'";}
    if ($jsonNew['type']!=$jsonOri['type']){$sql.=",`type`='".$jsonNew['type']."'";}     
    if ($jsonNew['notify']!=$jsonOri['notify']){$sql.=",`notify`=".$jsonNew['notify'];}
    if ($jsonNew['specialcase']!=$jsonOri['specialcase']){$sql.=",`specialcase`='".$jsonNew['specialcase']."'";} 
    if ($jsonNew['request']!=$jsonOri['request']){$sql.=",`request`='".$jsonNew['request']."'";}
    if ($jsonNew['trafficgo']!=$jsonOri['trafficgo']){$sql.=",`trafficgo`='".$jsonNew['trafficgo']."'";} 
    if ($jsonNew['trafficback']!=$jsonOri['trafficback']){$sql.=",`trafficback`='".$jsonNew['trafficback']."'";}     
    if ($jsonNew['pay']!=$jsonOri['pay']){$sql.=",`pay`=".$jsonNew['pay'];}    
    if ($jsonNew['trafficself']!=$jsonOri['trafficself']){$sql.=",`trafficself`=".$jsonNew['trafficself'];}     
    if ($jsonNew['joinclean']!=$jsonOri['joinclean']){$sql.=",`joinclean`='".$jsonNew['joinclean']."'";}
    if ($jsonNew['trafficclean']!=$jsonOri['trafficclean']){$sql.=",`trafficclean`='".$jsonNew['trafficclean']."'";} 
    if ($jsonNew['memo']!=$jsonOri['memo']){$sql.=",`memo`='".$jsonNew['memo']."'";} 
    //if ($jsonNew['applydate']!=$jsonOri['applydate']){$sql.=",`applydate`='".$jsonNew['applydate']."'";}
    if ($jsonNew['applyby']!=$jsonOri['applyby']){$sql.=",`applyby`='".$jsonNew['applyby']."'";}
    if ($jsonNew['checkin']!=$jsonOri['checkin']){$sql.=",`checkin`=".$jsonNew['checkin']."";}
    if ($jsonNew['checkin1']!=$jsonOri['checkin1']){$sql.=",`checkin1`=".$jsonNew['checkin1'];}
    if ($jsonNew['checkin2']!=$jsonOri['checkin2']){$sql.=",`checkin2`=".$jsonNew['checkin2'];}
    if ($jsonNew['checkin3']!=$jsonOri['checkin3']){$sql.=",`checkin3`=".$jsonNew['checkin3'];}
    if ($jsonNew['checkin4']!=$jsonOri['checkin4']){$sql.=",`checkin4`=".$jsonNew['checkin4'];}
    if ($jsonNew['checkin5']!=$jsonOri['checkin5']){$sql.=",`checkin5`=".$jsonNew['checkin5'];}
    if ($jsonNew['checkin6']!=$jsonOri['checkin6']){$sql.=",`checkin6`=".$jsonNew['checkin6'];}
    if ($jsonNew['checkin7']!=$jsonOri['checkin7']){$sql.=",`checkin7`=".$jsonNew['checkin7'];}
    if ($jsonNew['checkin8']!=$jsonOri['checkin8']){$sql.=",`checkin8`=".$jsonNew['checkin8'];}
    if ($jsonNew['checkin9']!=$jsonOri['checkin9']){$sql.=",`checkin9`=".$jsonNew['checkin9'];}
    if ($jsonNew['checkinx']!=$jsonOri['checkinx']){$sql.=",`checkinx`=".$jsonNew['checkinx'];}

    if ($dupNew!=$jsonOri['duplication']){$sql.=",`duplication`=".$dupNew;}
    //if ($jsonNew['invalidate']!=$jsonOri['invalidate']){$sql.=",`invalidate`='".$jsonNew['invalidate']."'";}  
    $sql.=" where `id`=".$jsonNew['id'].";";
    
    $ret=mysql_query($sql);
   
     if (!$ret) {
        $code=-1;
        $desc="upadte failed!";
    } else {
        $code=1;
        $desc="success";        
    }

    $json_ret=array("code"=>$code,"desc"=>$desc,"result"=>$ret);
    echo json_encode($json_ret);//header("Content-Type: text/html; charset=utf-8");
?>

