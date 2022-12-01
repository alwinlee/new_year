<?php
    function check_newyear_db($tbname) {
        if ($tbname==""){return false;}
        $sql="SHOW TABLES LIKE '".$tbname."'";
        $sql_result=mysql_query($sql);
        $numrows = mysql_num_rows($sql_result);
        if ($numrows>=1){return true;}
        $sql ="CREATE TABLE IF NOT EXISTS `".$tbname."`(";
        $sql.="`id`            int(8) NOT NULL auto_increment,";
        $sql.="`barcode`       varchar(20) collate utf8_unicode_ci COMMENT '報到條碼',";
        $sql.="`name`	        varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '姓名',";
        $sql.="`tel`	        varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '電話',";
        $sql.="`sex`	        varchar(4)  collate utf8_unicode_ci COMMENT '性別',";
        $sql.="`age`	        int(8) default 0 COMMENT '年齡',";
        $sql.="`area`	        varchar(4) collate utf8_unicode_ci COMMENT '區域',";
        $sql.="`classarea`	  varchar(20) collate utf8_unicode_ci COMMENT '教室',";
        $sql.="`classroom`	  varchar(12) collate utf8_unicode_ci COMMENT '母班班別',";
        $sql.="`classroomid`	  varchar(12) collate utf8_unicode_ci COMMENT '母班班別代碼',";
        $sql.="`classother`	  varchar(20) collate utf8_unicode_ci COMMENT '其他身份',";
        $sql.="`group`	        varchar(10) collate utf8_unicode_ci COMMENT '義工大組別',";
        $sql.="`subgroup`	  varchar(20) collate utf8_unicode_ci COMMENT '義工小組別',";
        $sql.="`join`	        varchar(10) collate utf8_unicode_ci COMMENT '參與日',";
        $sql.="`join1`	        int(4) default 0 COMMENT '參與日1',";
        $sql.="`join2`	        int(4) default 0 COMMENT '參與日2',";
        $sql.="`join3`	        int(4) default 0 COMMENT '參與日3',";
        $sql.="`join4`	        int(4) default 0 COMMENT '參與日4',";
        $sql.="`join5`	        int(4) default 0 COMMENT '參與日5',";
        $sql.="`join6`	        int(4) default 0 COMMENT '參與日6',";
        $sql.="`join7`	        int(4) default 0 COMMENT '參與日7',";
        $sql.="`join8`	        int(4) default 0 COMMENT '參與日8',";
        $sql.="`join9`	        int(4) default 0 COMMENT '參與日9',";
        $sql.="`joinx`	        int(4) default 0 COMMENT '參與日x',";
        $sql.="`live`	        varchar(10) collate utf8_unicode_ci COMMENT '住宿日',";
        $sql.="`live1`	        int(4) default 0 COMMENT '住宿日1',";
        $sql.="`live2`	        int(4) default 0 COMMENT '住宿日2',";
        $sql.="`live3`	        int(4) default 0 COMMENT '住宿日3',";
        $sql.="`live4`	        int(4) default 0 COMMENT '住宿日4',";
        $sql.="`live5`	        int(4) default 0 COMMENT '住宿日5',";
        $sql.="`live6`	        int(4) default 0 COMMENT '住宿日6',";
        $sql.="`live7`	        int(4) default 0 COMMENT '住宿日7',";
        $sql.="`live8`	        int(4) default 0 COMMENT '住宿日8',";
        $sql.="`live9`	        int(4) default 0 COMMENT '住宿日9',";
        $sql.="`livex`	        int(4) default 0 COMMENT '住宿日x',";
        $sql.="`livewhere`	  varchar(20) collate utf8_unicode_ci COMMENT '住宿區',";
        $sql.="`liveroom`	  varchar(20) collate utf8_unicode_ci COMMENT '住宿房',";
        $sql.="`type`	        varchar(20) collate utf8_unicode_ci COMMENT '義工類別',";
        $sql.="`notify`	        int(4) default 0 COMMENT '通知單發放',";
        $sql.="`specialcase`	  varchar(20) collate utf8_unicode_ci COMMENT '身體特殊狀況',";
        $sql.="`request`	  varchar(20) collate utf8_unicode_ci COMMENT '住宿特殊希求',";
        $sql.="`trafficgo`	  varchar(20) collate utf8_unicode_ci COMMENT '搭車去',";
        $sql.="`trafficback`	  varchar(20) collate utf8_unicode_ci COMMENT '搭車回',";
        $sql.="`pay`	        int(4) default 0 COMMENT '已交車資',";
        $sql.="`trafficself`	  int(4) default 0 COMMENT '自行往返',";
        $sql.="`joinclean`	  varchar(10) collate utf8_unicode_ci COMMENT '參與打掃日',";
        $sql.="`trafficclean`  varchar(20) collate utf8_unicode_ci COMMENT '打掃搭車',";
        $sql.="`memo`          varchar(128) collate utf8_unicode_ci COMMENT '備註',";
        $sql.="`applydate`     date default '1970-01-01' COMMENT '報名日期',";
        $sql.="`applyby`       varchar(20) collate utf8_unicode_ci COMMENT '報名者',";
        $sql.="`checkin`       varchar(10) collate utf8_unicode_ci COMMENT '報到',";

        $sql.="`checkin1`	  int(4) default 0 COMMENT '日1報到',";
        $sql.="`checkin2`	  int(4) default 0 COMMENT '日2報到',";
        $sql.="`checkin3`	  int(4) default 0 COMMENT '日3報到',";
        $sql.="`checkin4`	  int(4) default 0 COMMENT '日4報到',";
        $sql.="`checkin5`	  int(4) default 0 COMMENT '日5報到',";
        $sql.="`checkin6`	  int(4) default 0 COMMENT '日6報到',";
        $sql.="`checkin7`	  int(4) default 0 COMMENT '日7報到',";
        $sql.="`checkin8`	  int(4) default 0 COMMENT '日8報到',";
        $sql.="`checkin9`	  int(4) default 0 COMMENT '日9報到',";
        $sql.="`checkinx`	  int(4) default 0 COMMENT '日x報到',";

        $sql.="`duplication`   int(4) default 0 COMMENT '重覆報名註記',";
        $sql.="`invalidate`	  int(4) default 0 COMMENT '無效資料註記',";
        $sql.="PRIMARY KEY (`id`)";
        $sql.=")ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

        $sql_result=mysql_query($sql);
        return true;
    }

    function middleAlignment($objWorkSheet,$item,$text)
    {
        if ($text!=""){$objWorkSheet->setCellValue($item,$text);}
        $objWorkSheet->getStyle($item)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle($item)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->getStyle($item)->getAlignment()->setWrapText(true);
    }

    function checkAuth($idx, $auth, $expiredate, $groupexpire)
    {
        if ($auth[$idx]!="1"){
            return "NO"; // no auth
        }
        date_default_timezone_set('Asia/Taipei');
        $nowDate=date('Y-m-d');
        if ($nowDate<=$expiredate){
            return "YES"; //OK
        }
        if ($groupexpire[$idx]=="-"||$groupexpire[$idx]=="*"){
            return "NO";
        }
        return $groupexpire[$idx];
    }
?>
