<?php
    header("Content-Type: text/html; charset=utf-8");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-download");
    header("Content-Type: application/download");

    session_start();
    if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="precepts"){
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
    //if ($currM>=10){$currY+=1;}
    $tbname="precepts_".$currY;
    check_precepts_db($tbname);
    
    $type=$_POST["type"];
    $file_title=$currY."受戒法會 學員名冊(分區)";
    $table_title=$currY."受戒法會 學員名冊";
   //------------------------------------------------------------------------------------------------------------------------------			
    // Create new PHPExcel object
    $nSheet=0;
    $objPHPExcel=new PHPExcel();
    $col=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
              "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
              "BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ",
              "CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ");    
     
    // set column title
    $xlstitle=array("序號","姓名","性別","學員代號","區域","班級","報到");
    $xlstitleW=array(18,18,8,20,12,20,12);   
    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                 ->setLastModifiedBy("Maarten Balliauw")
                                 ->setTitle("Office 2007 XLSX Test Document")
                                 ->setSubject("Office 2007 XLSX Test Document")
                                 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                 ->setKeywords("office 2007 openxml php")
                                 ->setCategory("Test result file");

    $area=array("全區","北區","中區","嘉區","園區","南區");
    for($nSheet=0;$nSheet<count($area);$nSheet++){
        if ($nSheet>0){
            $objWorkSheet=$objPHPExcel->createSheet($nSheet);
        }

        $objWorkSheet=$objPHPExcel->setActiveSheetIndex($nSheet);
        $sheetName="";        
        $startR=1;$currR=$startR;
        $startC=0;$currC=$startC;
        
        for($num=0;$num<count($xlstitle);$num++) {
            $item=$col[$currC++].$currR;
            middleAlignment($objWorkSheet,$item,$xlstitle[$num]);
        }

        $idx=0;	
        // 填寫資料
        if ($nSheet==0){
            $sql="select * from `".$tbname."` where (`checkin`=1) order by `id` ASC";
        }else{
            $sql="select * from `".$tbname."` where (`area`='".$area[$nSheet]."' AND `checkin`=1) order by `id` ASC";
        }

        //$item="A1";
       //middleAlignment($objWorkSheet,$item,$sql);
        
        //$sql="select * from `".$tbname."` where `invalidate`<=0 order by `id` ";
        $result=mysql_query($sql);
        $currR=$startR;

        while($row=mysql_fetch_array($result,MYSQL_ASSOC))//MYSQL_NUM))//MYSQL_ASSOC))
        {
            //$xlstitle=array("序號","條碼","姓名","性別","電話","區別","母班班級","教室","義工大組","義工小組");
            $idx++;$currR++;$c=0;        
            $objWorkSheet->setCellValue($col[$c].$currR,$row["serial"])				 
                         ->setCellValue($col[++$c].$currR,$row["name"])//$row["ARE_ID"])
                         ->setCellValue($col[++$c].$currR,$row["sex"])
                         ->setCellValue($col[++$c].$currR,$row["studentid"])
                         ->setCellValue($col[++$c].$currR,$row["area"])
                         ->setCellValue($col[++$c].$currR,$row["classroom"])
                         ->setCellValue($col[++$c].$currR,$row["checkin"]==1?"1":"");
        }
        $currR+=1;    

        //$item="D".($top+$roundcnt+1);
        //$objWorkSheet->freezePane($item);
        
        // 設定欄位寛度
        for($w=0;$w<count($xlstitleW);$w++){$objWorkSheet->getColumnDimension($col[$w])->setWidth($xlstitleW[$w]);}//$xlstitleW[$w]
     
         // set border
        $range="A".$startR.":".$col[count($xlstitleW)-1].$currR;
        $objWorkSheet->getStyle($range)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // title color
        $range="A".$startR.":".$col[count($xlstitleW)-1].($startR);    
        $objWorkSheet->getStyle($range)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objWorkSheet->getStyle($range)->getFill()->getStartColor()->setRGB('DDFFDD');//$objWorkSheet->getStyle("A2")->getFill()->getStartColor()->setRGB('B7B7B7');     
        
        // set alignmemnt of col
        $range="D2:D".$currR;
        $objWorkSheet->getStyle($range)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // PERCENTAGE FORMAT
        $range="E".$startR.":E".$currR;
        $objPHPExcel->getActiveSheet()->getStyle($range)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));
        $objWorkSheet->setTitle($area[$nSheet]);// Rename worksheet
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