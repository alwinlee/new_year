<?php
    header("Content-Type: text/html; charset=utf-8");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-download");
    header("Content-Type: application/download");

    session_start();
    if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="newyear"){
        $code=-2;
        $desc="auth failed";
        $json_ret=array("code"=>$code,"desc"=>$desc);echo json_encode($json_ret);exit;
    }    
    
    set_time_limit(1200); // page execution time = 1200 seconds

    ini_set("error_reporting", 0); //error_reporting(E_ALL & ~E_NOTICE);
    ini_set("display_errors","Off"); // On : open, Off : close
    ini_set('memory_limit', -1 );			

    date_default_timezone_set('Asia/Taipei');//	date_default_timezone_set('Europe/London');
    if (PHP_SAPI=='cli'){die('This example should only be run from a Web Browser');}

    require_once("../lib/connmysql.php");
    require_once("../lib/common.php");
    require_once("../../resource/Classes/PHPExcel.php"); // PHPExcel // require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
    require_once("../../resource/Classes/PHPExcel/IOFactory.php"); // PHPExcel_IOFactory

    // check db exist
    $currY=date('Y');
    $currM=date('m');
    if ($currM>=10){$currY+=1;}
    $tbname="newyear_".$currY;
    check_newyear_db($tbname);
    
    $type=$_POST["type"];
    $file_title=$currY."朝禮法會 義工打掃報到名冊";
    $table_title=$currY."朝禮法會 義工打掃報到名冊";
   //------------------------------------------------------------------------------------------------------------------------------			
    // Create new PHPExcel object
    $nSheet=0;
    $objPHPExcel=new PHPExcel();
    $col=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
              "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
              "BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ",
              "CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ");    
     
    // set column title
    $xlstitle=array("序號","1/14(六)前行打掃","搭遊覽車","自行往返","義工類別","組別","大組","小組",
                    "區別","教室別","母班班別","姓名","手機或易聯絡電話","性別","男","女",
                    "年齡","身體特殊狀況","住宿特殊希求","參與日期","01／29初二",
                    "初二住宿","01／30初三","初三住宿","01／31初四","初四住宿",
                    "02／01初五","交通需求","搭車","去程","回程",
                    "已交車資","自行往返","通知單發放給","研討母班","各組組長","備註","重覆報名","報名日期","打掃報到");

    $xlstitleW=array(6,5,5,16,15,
                     15,8,12,16,16,
                     16,4,4,8,12,
                     12,4,4,4,4,
                     4,4,4,6,6,
                     6,6,6,6,18,12,13,13);    
    
    $typeAry=array("0"=>"-", "1"=>"總護持", "2"=>"副總護持", "3"=>"大會助理","4"=>"顧問","5"=>"大組長",
                   "6"=>"副大組長", "7"=>"大組助理","8"=>"小組長", "9"=>"副小組長","10"=>"義工",
                   "11"=>"見習幹部","12"=>"見習助理");

    $areaAry=array("A"=>"北區", "B"=>"中區", "C"=>"雲嘉", "D"=>"園區", "E"=>"南區", "F"=>"海外" );
    $sheetNameAry=array("總名冊","大會","秘書大組","教育大組","庶務大組","總務大組","善法實踐");
    $groupFilterAry=array("總名冊","大會","秘書大組","教育大組","庶務大組","總務大組","善法實踐");
    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                 ->setLastModifiedBy("Maarten Balliauw")
                                 ->setTitle("Office 2007 XLSX Test Document")
                                 ->setSubject("Office 2007 XLSX Test Document")
                                 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                 ->setKeywords("office 2007 openxml php")
                                 ->setCategory("Test result file");
                                 
    for($nSheet=0;$nSheet<count($groupFilterAry);$nSheet++){
        if ($nSheet>0){
            $objWorkSheet=$objPHPExcel->createSheet($nSheet);
        }

        $objWorkSheet=$objPHPExcel->setActiveSheetIndex($nSheet);
        $sheetName="";        
        $startR=4;$currR=$startR;
        $startC=0;$currC=$startC;
        $item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[0]);
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC+1].($currR+1);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[1]);

        $item=$col[$currC].($currR+2);
        middleAlignment($objWorkSheet,$item,$xlstitle[2]);
        
        $item=$col[$currC+1].($currR+2);
        middleAlignment($objWorkSheet,$item,$xlstitle[3]);

        $currC+=2;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);
        $objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[4]);
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC+1].($currR+1);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[5]);
        $item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[6]);
        $item=$col[$currC+1].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[7]);
        
        $currC+=2;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[8]);

        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[9]);
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[10]);
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[11]);
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[12]);
     
        //性別
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC+1].($currR+1);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[13]);
        $item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[14]);
        $currC++;$item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[15]); 
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[16]);
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[17]);
        
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[18]);

        // 參與日期
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC+6].($currR);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[19]);    
        $itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        $item=$col[$currC].($currR+1);middleAlignment($objWorkSheet,$item,$xlstitle[20]);    
        $currC++;$itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        $item=$col[$currC].($currR+1);middleAlignment($objWorkSheet,$item,$xlstitle[21]);
        $currC++;$itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        $item=$col[$currC].($currR+1);middleAlignment($objWorkSheet,$item,$xlstitle[22]);
        $currC++;$itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        $item=$col[$currC].($currR+1);middleAlignment($objWorkSheet,$item,$xlstitle[23]);
        $currC++;$itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        $item=$col[$currC].($currR+1);middleAlignment($objWorkSheet,$item,$xlstitle[24]);
        $currC++;$itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        $item=$col[$currC].($currR+1);middleAlignment($objWorkSheet,$item,$xlstitle[25]);
        $currC++;$itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        $item=$col[$currC].($currR+1);middleAlignment($objWorkSheet,$item,$xlstitle[26]);    
        
        // 交通需求
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC+3].($currR);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[27]);
        
        $item=$col[$currC].($currR+1);
        $itemM=$col[$currC].($currR+1).":".$col[$currC+2].($currR+1);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[28]);
        
        $item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[29]);
        $currC++;$item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[30]);
        $currC++;$item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[31]);

        $currC++;$item=$col[$currC].($currR+1);
        $itemM=$col[$currC].($currR+1).":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[32]); 
        
        //通知單發放給
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC+1].($currR+1);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[33]);
        $item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[34]);
        $currC++;$item=$col[$currC].($currR+2);middleAlignment($objWorkSheet,$item,$xlstitle[35]); 
        
        //備註
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[36]);
        
        //重覆報名
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[37]);
        
        //報名日期
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[38]);
        
        //報到
        $currC++;$item=$col[$currC].$currR;
        $itemM=$col[$currC].$currR.":".$col[$currC].($currR+2);$objWorkSheet->mergeCells($itemM);
        middleAlignment($objWorkSheet,$item,$xlstitle[39]); 
        // end title
        
        $currC=20;
        $item="A1:".$col[$currC+1]."1";	
        // main title	
        $objWorkSheet->mergeCells($item);
        $titlename=$table_title."(".$sheetNameAry[$nSheet].")";
        $objWorkSheet->setCellValue("A1",$titlename); //合併後的儲存格
        $objWorkSheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle("A1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->getStyle("A1")->getFont()->setSize(16);
        $objWorkSheet->getStyle("A1")->getFont()->setBold(true);
        $objWorkSheet->getRowDimension("1")->setRowHeight(30);
        $objWorkSheet->getRowDimension("3")->setRowHeight(20);
        
        //設行高
        $objWorkSheet->getRowDimension("4")->setRowHeight(28);
        $objWorkSheet->getRowDimension("5")->setRowHeight(28);
        $objWorkSheet->getRowDimension("6")->setRowHeight(64);
        
        $idx=0;	
        // 填寫資料 
        if ($nSheet<=0){
            $sql="select * from `".$tbname."` where (`joinclean`='0000000001' AND `invalidate`<=0 ) order by `group`,`subgroup`,`type`";
        } else {
            $sql="select * from `".$tbname."` where (`joinclean`='0000000001' AND `group`='".$groupFilterAry[$nSheet]."' and `invalidate`<=0 ) order by `group`,`subgroup`,`type`";
        }
        
        //$sql="select * from `".$tbname."` where `invalidate`<=0 order by `id` ";
        $result=mysql_query($sql);
        $currR=$startR+2;

        while($row=mysql_fetch_array($result,MYSQL_ASSOC))//MYSQL_NUM))//MYSQL_ASSOC))
        {
            //$xlstitle=array("序號","條碼","姓名","性別","電話","區別","母班班級","教室","義工大組","義工小組");
            $idx++;$currR++;$c=0;
            $classrm=$row["classroom"];
            if ($classrm==""||$row["classroomid"]=="0000"){
                $classrm=$row["classother"];
            }            
            $objWorkSheet->setCellValue($col[$c].$currR,$idx)				 
                         ->setCellValue($col[++$c].$currR,$row["trafficclean"])//$row["ARE_ID"])
                         ->setCellValue($col[++$c].$currR,$row["joinclean"])
                         ->setCellValue($col[++$c].$currR,$typeAry[$row["type"]])
                         ->setCellValue($col[++$c].$currR,$row["group"])
                         ->setCellValue($col[++$c].$currR,$row["subgroup"])
                         ->setCellValue($col[++$c].$currR,$areaAry[$row["area"]])
                         ->setCellValue($col[++$c].$currR,$row["classarea"])
                         ->setCellValue($col[++$c].$currR,$classrm)
                         ->setCellValue($col[++$c].$currR,$row["name"])
                         ->setCellValue($col[++$c].$currR," ".$row["tel"])
                         ->setCellValue($col[++$c].$currR,$row["sex"]=="M" ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["sex"]=="F" ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["age"]>0 ? $row["age"]:"")
                         ->setCellValue($col[++$c].$currR,$row["specialcase"])
                         ->setCellValue($col[++$c].$currR,$row["request"])
                         ->setCellValue($col[++$c].$currR,$row["join1"]>0 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["live1"]>0 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["join2"]>0 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["live2"]>0 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["join3"]>0 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["live3"]>0 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["join4"]>0 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["trafficgo"])
                         ->setCellValue($col[++$c].$currR,$row["trafficback"])
                         ->setCellValue($col[++$c].$currR,$row["pay"]>0 ? "v":"")
                         ->setCellValue($col[++$c].$currR,$row["trafficself"]>0 ? "v":"")
                         ->setCellValue($col[++$c].$currR,$row["notify"]==1 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["notify"]==2 ? "1":"")
                         ->setCellValue($col[++$c].$currR,$row["memo"])
                         ->setCellValue($col[++$c].$currR,$row["duplication"])
                         ->setCellValue($col[++$c].$currR,$row["applydate"])
                         ->setCellValue($col[++$c].$currR,$row["checkinx"]==1?"1":"");
        }
        $currR+=1;    

        //$item="D".($top+$roundcnt+1);
        //$objWorkSheet->freezePane($item);
        $top=4;
        $sumitem=array("AG","AH","AI","AJ");
        for($w=0;$w<count($sumitem);$w++)
        {
            $item="=SUM(".$sumitem[$w]."4:".$sumitem[$w].($currR-1).")";
            $objWorkSheet->setCellValue($sumitem[$w]."3",$item);
        }
    
        // 設定欄位寛度
        for($w=0;$w<count($xlstitleW);$w++){$objWorkSheet->getColumnDimension($col[$w])->setWidth($xlstitleW[$w]);}//$xlstitleW[$w]
     
         // set border
        $range="A".$startR.":".$col[count($xlstitleW)-1].$currR;
        $objWorkSheet->getStyle($range)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // title color
        $range="A".$startR.":".$col[count($xlstitleW)-1].($startR+2);    
        $objWorkSheet->getStyle($range)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objWorkSheet->getStyle($range)->getFill()->getStartColor()->setRGB('DDFFDD');//$objWorkSheet->getStyle("A2")->getFill()->getStartColor()->setRGB('B7B7B7');     
      
        // PERCENTAGE FORMAT
        $range="E".$startR.":E".$currR;
        $objPHPExcel->getActiveSheet()->getStyle($range)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));
        $objWorkSheet->setTitle($sheetNameAry[$nSheet]);// Rename worksheet
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------	
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);    
    header('Content-Type: application/vnd.ms-excel');// Redirect output to a client’s web browser (Excel5)
    $fileheader="Content-Disposition: attachment;filename=\"".$file_title.".xls\"";//header('Content-Disposition: attachment;filename="simple.xls"');
    header($fileheader);
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');// If you're serving to IE 9, then the following may be needed

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>