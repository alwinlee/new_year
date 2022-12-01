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
 
    $dateCurr=date('Y');
    $table_title=$dateCurr."朝禮法會 義工正行報到統計";

    //------------------------------------------------------------------------------------------------------------------------------			
    // Create new PHPExcel object
    $nSheet=0;
    $objPHPExcel=new PHPExcel();
    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                 ->setLastModifiedBy("Maarten Balliauw")
                                 ->setTitle("Office 2007 XLSX Test Document")
                                 ->setSubject("Office 2007 XLSX Test Document")
                                 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                 ->setKeywords("office 2007 openxml php")
                                 ->setCategory("Test result file");                             
    $objWorkSheet=$objPHPExcel->setActiveSheetIndex($nSheet);
    
    $col=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
              "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
              "BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ",
              "CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ");    

    $xlstitle=array("大組","小組","報名應到人數","小計","實到人數","小計","第1天實到","小計","第2天實到","小計","第3天實到","小計");
    $xlstitleW=array(20,22,14,14,14,14,14,14,14,14,14,14);

    $mainitem=-1;//21;
    $roundcnt=1; // 2: 考慮去/回
    $top=3;
    // each sub title
    for($w=0;$w<count($xlstitle);$w++)
    {
        $mainitem++;$item=$col[$mainitem].$top.":".$col[$mainitem].($top+$roundcnt);
        if ($xlstitle[$mainitem]!=""){
            $objWorkSheet->mergeCells($item);$item=$col[$mainitem].$top;  
            $objWorkSheet->setCellValue($item,$xlstitle[$mainitem]);            
        }	
        $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $item=$col[$mainitem].($top-1);        
        $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
     } 
    // end ---
     
    $item="A1:".$col[$mainitem]."1";	
    // main title	
    $objWorkSheet->mergeCells($item);	
    $objWorkSheet->setCellValue("A1",$table_title); //合併後的儲存格
    $objWorkSheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objWorkSheet->getStyle("A1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objWorkSheet->getStyle("A1")->getFont()->setSize(16);
    $objWorkSheet->getStyle("A1")->getFont()->setBold(true);
    $objWorkSheet->getRowDimension("1")->setRowHeight(30);
    $objWorkSheet->getRowDimension("3")->setRowHeight(20);    	 
    if($roundcnt>=2){$objWorkSheet->getRowDimension("4")->setRowHeight(20);$objWorkSheet->getRowDimension("5")->setRowHeight(20);}
    else{$objWorkSheet->getRowDimension("4")->setRowHeight(40);}    
    
    // 取調整參數
    $sql="select * from `param` order by `id` ";
    $record=mysql_query($sql);
    $numrows=mysql_num_rows($record);
    if($numrows>0){
        while($row=mysql_fetch_array($record, MYSQL_ASSOC)) {
            $param[]=$row;
        }
    }


    $idx=0;	
    $iRow=$top+$roundcnt;

    // 填寫資料
    $sql="SELECT `group`, `subgroup`, COUNT(*) as count, SUM(`checkin`) as `sumx`, SUM(`checkin1`) as `sum1`, SUM(`checkin2`) as `sum2`, SUM(`checkin3`) as `sum3` FROM `".$tbname."` where (`invalidate`<=0) group by `group`,`subgroup` order by `group` ASC ,`subgroup` ASC";
    $record=mysql_query($sql);	
    $numrows=mysql_num_rows($record);
    $prevgroup="";
    $iPreRow=0;
    $merge=false;
    $addS=0;$addsumS=0;
    $addR=0;$addsumR=0;
    while($row=mysql_fetch_array($record, MYSQL_ASSOC))
    {
        $addS=0;
        $addR=0;
        if (isset($param)) {
            for($xx=0;$xx<count($param);$xx++){
                if($param[$xx]['main']==$row["group"]&&$param[$xx]['sub']==$row["subgroup"]){
                    $addS=$param[$xx]['valS'];
                    $addR=$param[$xx]['valR'];
                    break;
                }
            }
        }

        $addsumS+=$addS;
        $addsumR+=$addR;

        $idx++;$iRow++;$c=0;
        if($prevgroup==""){
            $prevgroup=$row["group"];
            $iPreRow = $iRow;
        }
        $merge=false;
        if($prevgroup!=$row["group"] || $idx==$numrows){            
            // merge
            if ( $idx==$numrows){
                $mergeitem=$col[0].$iPreRow.":".$col[0].($iRow);
            } else {
                $mergeitem=$col[0].$iPreRow.":".$col[0].($iRow-1);
            }
            
            $objWorkSheet->mergeCells($mergeitem);
            
            $item=$col[0].$iPreRow;
            $objWorkSheet->setCellValue($item,$prevgroup);
            $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            // merge
            if ( $idx==$numrows){
                $mergeitem=$col[3].$iPreRow.":".$col[3].($iRow);
                $sumvalue="=SUM(".$col[2].$iPreRow.":".$col[2].($iRow).")";
            } else {
                $mergeitem=$col[3].$iPreRow.":".$col[3].($iRow-1);
                $sumvalue="=SUM(".$col[2].$iPreRow.":".$col[2].($iRow-1).")";
            }
            $objWorkSheet->mergeCells($mergeitem);
            $item=$col[3].$iPreRow;
            
            $objWorkSheet->setCellValue($item, $sumvalue);
            $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 
            // merge
            if ( $idx==$numrows){
                $mergeitem=$col[5].$iPreRow.":".$col[5].($iRow);
                $sumvalue="=SUM(".$col[4].$iPreRow.":".$col[4].($iRow).")";
            } else {
                $mergeitem=$col[5].$iPreRow.":".$col[5].($iRow-1);
                $sumvalue="=SUM(".$col[4].$iPreRow.":".$col[4].($iRow-1).")";
            }
            $objWorkSheet->mergeCells($mergeitem);
            $item=$col[5].$iPreRow;
            
            $objWorkSheet->setCellValue($item, $sumvalue);
            $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            // merge day 1
            if ( $idx==$numrows){
                $mergeitem=$col[7].$iPreRow.":".$col[7].($iRow);
                $sumvalue="=SUM(".$col[6].$iPreRow.":".$col[6].($iRow).")";
            } else {
                $mergeitem=$col[7].$iPreRow.":".$col[7].($iRow-1);
                $sumvalue="=SUM(".$col[6].$iPreRow.":".$col[6].($iRow-1).")";
            }
            $objWorkSheet->mergeCells($mergeitem);
            $item=$col[7].$iPreRow;

            $objWorkSheet->setCellValue($item, $sumvalue);
            $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            // merge day2
            if ( $idx==$numrows){
                $mergeitem=$col[9].$iPreRow.":".$col[9].($iRow);
                $sumvalue="=SUM(".$col[8].$iPreRow.":".$col[8].($iRow).")";
            } else {
                $mergeitem=$col[9].$iPreRow.":".$col[9].($iRow-1);
                $sumvalue="=SUM(".$col[8].$iPreRow.":".$col[8].($iRow-1).")";
            }
            $objWorkSheet->mergeCells($mergeitem);
            $item=$col[9].$iPreRow;

            $objWorkSheet->setCellValue($item, $sumvalue);
            $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            // merge day3
            if ( $idx==$numrows){
                $mergeitem=$col[11].$iPreRow.":".$col[11].($iRow);
                $sumvalue="=SUM(".$col[10].$iPreRow.":".$col[10].($iRow).")";
            } else {
                $mergeitem=$col[11].$iPreRow.":".$col[11].($iRow-1);
                $sumvalue="=SUM(".$col[10].$iPreRow.":".$col[10].($iRow-1).")";
            }
            $objWorkSheet->mergeCells($mergeitem);
            $item=$col[11].$iPreRow;

            $objWorkSheet->setCellValue($item, $sumvalue);
            $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $merge=true;            
        }
        if ($merge){
          $objWorkSheet->setCellValue($col[++$c].$iRow,$row["subgroup"])
                       ->setCellValue($col[++$c].$iRow,$row["count"]+$addS)
                       ->setCellValue($col[$c+2].$iRow,$row["sumx"]+$addR)
                       ->setCellValue($col[$c+4].$iRow,$row["sum1"])
                       ->setCellValue($col[$c+6].$iRow,$row["sum2"])
                       ->setCellValue($col[$c+8].$iRow,$row["sum3"]);

                       $prevgroup=$row["group"];
                       $iPreRow=$iRow;
        }else{
          $objWorkSheet->setCellValue($col[++$c].$iRow,$row["subgroup"])
                       ->setCellValue($col[++$c].$iRow,$row["count"]+$addS)
                       ->setCellValue($col[$c+2].$iRow,$row["sumx"]+$addR)
                       ->setCellValue($col[$c+4].$iRow,$row["sum1"])
                       ->setCellValue($col[$c+6].$iRow,$row["sum2"])
                       ->setCellValue($col[$c+8].$iRow,$row["sum3"]);
                       //->setCellValueExplicit($col[$c+2].$iRow,$row["sumx"],PHPExcel_Cell_DataType::TYPE_STRING);
        }
    }
   
    $iRow+=1;
    // SUM OF VALUE
    $mergeitem=$col[0].$iRow.":".$col[1].$iRow;
    $objWorkSheet->mergeCells($mergeitem);
    $item=$col[0].$iRow;
    $objWorkSheet->setCellValue($item, "總計");
    $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
    $sumitem=array($col[2],$col[3],$col[4],$col[5],$col[6],$col[7],$col[8],$col[9],$col[10],$col[11]);
    for($w=0;$w<count($sumitem);$w++)
    {
        $item="=SUM(".$sumitem[$w].($top+$roundcnt).":".$sumitem[$w].($iRow-1).")";
        $objWorkSheet->setCellValue($sumitem[$w].$iRow,$item);
        $objWorkSheet->setCellValue($sumitem[$w].($top-1),$item);
    }
    //$range="C3:K".$iRow;
    //$objPHPExcel->getActiveSheet()->getStyle($range)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_TEXT));
    //$item="D".($top+$roundcnt+1);
    //$objWorkSheet->freezePane($item);    
    // 設定欄位寛度
    for($w=0;$w<count($xlstitle);$w++){$objWorkSheet->getColumnDimension($col[$w])->setWidth($xlstitleW[$w]);}//$xlstitleW[$w]
 
     // set border
    $range="A".$top.":".$col[$mainitem].$iRow;
    $objWorkSheet->getStyle($range)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    if ($roundcnt==2){$range="A3:".$col[$mainitem]."5";}else{$range="A3:".$col[$mainitem]."4";}
    $objWorkSheet->getStyle($range)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objWorkSheet->getStyle($range)->getFill()->getStartColor()->setRGB('DDFFDD');//$objWorkSheet->getStyle("A2")->getFill()->getStartColor()->setRGB('B7B7B7');     
  
    $range="B5:B".$iRow;
    $objWorkSheet->getStyle($range)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    // 參與天數統計
    
    // 填寫資料
    $i=0;
    $statistic[$i]["item"]="參加天數";//.count($param).$param[1]['main'].$param[1]['sub'].$param[1]['valS'].$param[1]['valR'];
    $statistic[$i]["valueS"]="應到人數";
    $statistic[$i++]["valueR"]="實到人數";
    
    $sql="SELECT COUNT(*) as count1,SUM(`checkin`) as `sum1` FROM `".$tbname."` WHERE (join2+join3+join4)=3 AND `invalidate`<=0";
    $record=mysql_query($sql);
    $row=mysql_fetch_array($record, MYSQL_ASSOC);
    $statistic[$i]["item"]="全程";
    $statistic[$i]["valueS"]=$row["count1"]+$addsumS;
    $statistic[$i++]["valueR"]=$row["sum1"]+$addsumR;
    
    $sql="SELECT COUNT(*) as count2,SUM(`checkin`) as `sum2` FROM `".$tbname."` WHERE (join2+join3+join4)=2 AND `invalidate`<=0";
    $record=mysql_query($sql);
    $row=mysql_fetch_array($record, MYSQL_ASSOC);
    $statistic[$i]["item"]="2天";
    $statistic[$i]["valueS"]=$row["count2"];
    $statistic[$i++]["valueR"]=$row["sum2"];
 
    $sql="SELECT COUNT(*) as count3,SUM(`checkin`) as `sum3` FROM `".$tbname."` WHERE (join2+join3+join4)=1 AND `invalidate`<=0";
    $record=mysql_query($sql);
    $row=mysql_fetch_array($record, MYSQL_ASSOC);
    $statistic[$i]["item"]="1天";
    $statistic[$i]["valueS"]=$row["count3"];
    $statistic[$i++]["valueR"]=$row["sum3"];
    
    $sql="SELECT COUNT(*) as count4,SUM(`checkin`) as `sum4` FROM `".$tbname."` WHERE (join2+join3+join4)=0 AND `invalidate`<=0";
    $record=mysql_query($sql);
    $row=mysql_fetch_array($record, MYSQL_ASSOC);
    $statistic[$i]["item"]="0天";
    $statistic[$i]["valueS"]=$row["count4"];
    $statistic[$i++]["valueR"]=$row["sum4"];
    
    $sql="SELECT COUNT(*) as count5,SUM(`checkinx`) as `sum5` FROM `".$tbname."` WHERE `joinclean`='0000000001' AND `invalidate`<=0";
    $record=mysql_query($sql);
    $row=mysql_fetch_array($record, MYSQL_ASSOC);
    $statistic[$i]["item"]="打掃";
    $statistic[$i]["valueS"]=$row["count5"];
    $statistic[$i++]["valueR"]=$row["sum5"];
    $iRow+=2;
    $iStartRow=($iRow+1);
    for($i=0;$i<count($statistic);$i++){
        $iRow++;
        $mergeitem=$col[0].$iRow.":".$col[1].$iRow;
        $objWorkSheet->mergeCells($mergeitem);
        $item=$col[0].$iRow;
        $objWorkSheet->setCellValue($item, $statistic[$i]["item"]);
        $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $item=$col[2].$iRow;
        $objWorkSheet->setCellValue($item, $statistic[$i]["valueS"]);
        $item=$col[3].$iRow;
        $objWorkSheet->setCellValue($item, $statistic[$i]["valueR"]);
    }
 
    $range="A".$iStartRow.":".$col[3].$iRow;
    $objWorkSheet->getStyle($range)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $range="A".$iStartRow.":".$col[1].$iRow;
    $objWorkSheet->getStyle($range)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objWorkSheet->getStyle($range)->getFill()->getStartColor()->setRGB('DDFFDD');
    
    // PERCENTAGE FORMAT
    //$range="E".$top.":E".$iRow;
    //$objPHPExcel->getActiveSheet()->getStyle($range)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));
    $objWorkSheet->setTitle($table_title);// Rename worksheet
    //--------------------------------------------------------------------------------------------------------------------------------------------------	
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);    
    header('Content-Type: application/vnd.ms-excel');// Redirect output to a client’s web browser (Excel5)
    $fileheader="Content-Disposition: attachment;filename=\"".$table_title.".xls\"";//header('Content-Disposition: attachment;filename="simple.xls"');
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