<?php
   
    function getPDFtitle($title)
    {
        //$invoice_title="<table border=\"0\"><tr><td style=\"width:510px;text-align:center;\"><h2>".$title."</h2></td>";
        //$invoice_title.="<td style=\"width:170px;text-align:center;\">";
        //$invoice_title.="<span style=\"font-size: 10pt;background-color:#E0E0E0;\">*請攜帶本通知單辦理報到*</span></td></tr></table>";
        //return $invoice_title;
        
        $invoice_title="<table border=\"0\">";
        $invoice_title.="<tr><td style=\"width:680px;text-align:center;\"><h2>".$title."</h2></td></td></tr>";
        //$invoice_title.="<tr><td style=\"width:680px;text-align:center;height:10px;\"></td></td></tr>";
        $invoice_title.="<tr><td style=\"width:680px;text-align:center;\"><span style=\"font-size: 12pt;background-color:#E0E0E0;\">*請攜帶並繳交本通知單以完成報到手續*</span></td></tr></table>";
        $invoice_title.="</table>";
        return $invoice_title;   
        
        
    }

    function getcleanPDFstudent($area,$clsarea,$class,$name,$where,$params)
    {
        //$student_info="<table border=\"0\"><tr>";    
        //$student_info.="<td style=\"width:60px;height:75px;text-align:left;\"><br><h3>班別：</h3></td>";
        //$student_info.="<td style=\"width:340px;text-align:left;text-decoration:underline;\"><br><h3>".$class."&nbsp;&nbsp;&nbsp;&nbsp;".$name."&nbsp;&nbsp;大德</h3></td>";
        //$student_info.="<td style=\"width:100px;text-align:right;\"><br><h3>報到序號：</h3></td>";
        //$student_info.="<td style=\"width:180px;text-align:center;\"> <tcpdf method=\"write1DBarcode\" params=\"".$params."\" /> </td>";
        //$student_info.="</tr></table>";
        
        $student_info="<table border=\"0\">";
        $student_info.="<tr>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>區域：</h3></td>";
        $student_info.="<td style=\"width:130px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;&nbsp;".$area."&nbsp;&nbsp;</h3></td>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>教室：</h3></td>";
        $student_info.="<td style=\"width:130px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;".$clsarea."&nbsp;</h3></td>";
        $student_info.="<td style=\"width:140px;text-align:right;\"><h3>報到序號：</h3></td>";
        $student_info.="<td style=\"width:180px;text-align:center;\" rowspan=\"2\"> <tcpdf method=\"write1DBarcode\" params=\"".$params."\" /> </td>";
        $student_info.="</tr>";
        
        $student_info.="<tr>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>班別：</h3></td>";
        $student_info.="<td style=\"width:130px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;".$class."&nbsp;</h3></td>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>姓名：</h3></td>";
        $student_info.="<td style=\"width:130px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;".$name."&nbsp;&nbsp;大德</h3></td>";
        //$student_info.="<td style=\"width:140px;text-align:left;\"><h3>通知單發:".$where."</h3></td>";        
        $student_info.="<td style=\"width:140px;text-align:left;\"><h3></h3></td>"; 
        $student_info.="</tr>";
        $student_info.="</table>";
        return $student_info;
    }
    
    function getPDFstudent($area,$clsarea,$class,$name,$where,$sex,$params)
    {
        //$student_info="<table border=\"0\"><tr>";    
        //$student_info.="<td style=\"width:60px;height:75px;text-align:left;\"><br><h3>班別：</h3></td>";
        //$student_info.="<td style=\"width:340px;text-align:left;text-decoration:underline;\"><br><h3>".$class."&nbsp;&nbsp;&nbsp;&nbsp;".$name."&nbsp;&nbsp;大德</h3></td>";
        //$student_info.="<td style=\"width:100px;text-align:right;\"><br><h3>報到序號：</h3></td>";
        //$student_info.="<td style=\"width:180px;text-align:center;\"> <tcpdf method=\"write1DBarcode\" params=\"".$params."\" /> </td>";
        //$student_info.="</tr></table>";
        
        $student_info="<table border=\"0\">";
        $student_info.="<tr>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>區域：</h3></td>";
        $student_info.="<td style=\"width:120px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;&nbsp;".$area."&nbsp;&nbsp;</h3></td>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>教室：</h3></td>";
        $student_info.="<td style=\"width:130px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;".$clsarea."&nbsp;</h3></td>";
        $student_info.="<td style=\"width:70px;text-align:right;\"></td>";
        $student_info.="<td style=\"width:80px;text-align:right;\"><h3>報到序號：</h3></td>";
        $student_info.="<td style=\"width:180px;text-align:center;\" rowspan=\"2\"> <tcpdf method=\"write1DBarcode\" params=\"".$params."\" /> </td>";
        $student_info.="</tr>";
        
        $student_info.="<tr>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>班別：</h3></td>";
        $student_info.="<td style=\"width:120px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;".$class."&nbsp;</h3></td>";
        $student_info.="<td style=\"width:50px;height:30px;text-align:left;\"><h3>姓名：</h3></td>";
        $student_info.="<td style=\"width:130px;height:30px;text-align:left;text-decoration:underline;\"><h3>&nbsp;".$name."&nbsp;&nbsp;大德</h3></td>";
        $student_info.="<td style=\"width:70px;text-align:left;\"><h3>性別：<span style=\"text-decoration:underline;\">".$sex."</span></h3></td>";
        $student_info.="<td style=\"width:80px;text-align:right;\"><span style=\"font-size: 8pt;text-align:right;\">(發至".$where.")&nbsp;&nbsp;</span></td>";
        //$student_info.="<td style=\"width:150px;text-align:left;\"><span style=\"font-size: 12pt;\">性別：</span><span style=\"font-size: 12pt;text-decoration:underline;\">".$sex."</span><span style=\"font-size: 8pt;text-align:right;\">&nbsp;&nbsp;&nbsp;&nbsp;(發至".$where.")</span></td>";        
        $student_info.="<td style=\"width:140px;text-align:left;\"><h3></h3></td>"; 
        $student_info.="</tr>";
        $student_info.="</table>";
        return $student_info;
    }
    
    function getcleanPDFinfo($year,$area)
    {
        //$info="<style>span{ color: black; font-size: 14pt; text-decoration:underline; background-color:#E0E0E0;}</style>";
        $info="<style>span{ color: black; font-size: 12pt;}</style>";
        $info.="<table border=\"0\">";        
        $info.="<tr>";
        $info.="<td style=\"width:680px;text-align:left;\">";
        $info.="<span>&nbsp;隨喜您發心報名".$year."年園區朝禮法會全體義工前行暨打掃，以下事項需要您的協助配合：</span>";
        $info.="</td></tr>";

        $info.="<tr style=\"height:3px;\"><td style=\"height:3px;text-align:left;\"></td><td></td></tr>";

        $info.="<tr><td style=\"width:30px;text-align:right;\">一、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>報到時間：2017年1月21 日(週六) 上午8:00~8:30。</span>";
        $info.="</td></tr>";
        
        $info.="<tr><td></td><td></td></tr>";
        
        $info.="<tr><td style=\"width:30px;text-align:right;\">二、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>報到地點：</span><span style=\"background-color:#E0E0E0;\">園區宗仰大樓一樓 西側鐵皮屋。</span>";
        $info.="</td></tr>";
        
        $info.="<tr><td></td><td></td></tr>";
  
        $info.="<tr><td style=\"width:30px;text-align:right;\">三、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>攜帶物品：名牌、身份證、健保卡、餐具；早晚溫差大，請帶禦寒外套(請勿攜帶貴重物品)。</span>";
        $info.="</td></tr>";
        
        $info.="<tr><td></td><td></td></tr>";

        $info.="<tr><td style=\"width:30px;text-align:right;\">四、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span style=\"text-decoration:underline;\">登記搭遊覽車者：因人數不足，故無法發遊覽車，將由各小組長安排共乘</span>";
        $info.="</td></tr>";
        $info.="<tr><td style=\"width:30px;text-align:right;\"></td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        if ($area=="B"){// 中區 
            $info.="<span>有任何問題請聯絡報到組：陳淑齡 0928-455-293，黃珮樺 0955-100-593。</span>";
        } else if ($area=="C"){
            $info.="<span>有任何問題請聯絡報到組：陳瑩朱 0932-018-345。</span>";
        } else {
            $info.="<span>有任何問題請聯絡報到組：蕭郁蓉 0928-751-712，楊臨賢 0929-313-972。</span>";
        }

        $info.="</td></tr>";
        $info.="<tr><td></td><td></td></tr>";

        $info.="<tr><td style=\"width:30px;text-align:right;\">五、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>自行開車前往者，請自行放置 \"姓名與聯絡電話\" 標示牌，於車前擋風玻璃內，以便交通組聯絡！</span>";
        $info.="</td></tr>";

        $info.="<tr><td></td><td></td></tr>";

        $info.="<tr><td style=\"width:30px;text-align:right;\">六、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>園區地址：雲林縣古坑鄉麻園村平和20號。</span>";
        $info.="</td></tr>";

        //$info.="<tr><td></td><td></td></tr>";
        //$info.="<tr><td></td><td></td></tr>";
        $info.="<tr><td></td><td></td></tr>";
        
        $info.="<tr>";
        $info.="<td style=\"width:180px;text-align:right;\">";
        $info.="<h3>祝福您 福智圓滿！</h3></td>";
        $info.="<td style=\"width:500px;text-align:right;\"><br><br>園區朝禮法會報名報到組  合十  ".$year.".01</td></tr>";
        $info.="</table>";
        return $info;
    }

    function getPDFinfo($year,$area,$notify,$group,$subgroup)
    {
        //$info="<style>span{ color: black; font-size: 14pt; text-decoration:underline; background-color:#E0E0E0;}</style>";
        $info="<style>span{ color: black; font-size: 12pt;} spanhint{ color: black; font-size: 12pt;text-decoration:underline; background-color:#E0E0E0;}</style>";
        $info.="<table border=\"0\">";        
        $info.="<tr>";
        $info.="<td style=\"width:680px;text-align:left;\">";
        $info.="<span>&nbsp;隨喜您已被錄取並分發到 </span>";
        $info.="<span style=\"text-decoration:underline; background-color:#E0E0E0;\"> ".str_replace("大組","",$group)."</span><span> 大組 </span>";
        $info.="<span style=\"text-decoration:underline; background-color:#E0E0E0;\"> ".str_replace("小組","",$subgroup)."</span><span> 小組，</span>";
        $info.="<span>以下事項需要您的協助配合：</span>";

        $info.="</td></tr>";

        $info.="<tr style=\"height:3px;\"><td style=\"height:3px;text-align:left;\"></td><td></td></tr>";

        $info.="<tr><td style=\"width:30px;text-align:right;\">一、</td>";
        $info.="<td style=\"width:650px;text-align:left;text-weight:bolder;\">";
        $info.="<span>全程報到時間：2017年1月30日(初三) ～ 2月1日(初五)   上午 07:30 ～ 08:20，</span>";
        $info.="<span><br>報到地點：宗仰大樓一樓 慈生藥局前&nbsp;(園區地址：雲林縣古坑鄉麻園村平和20號)</span>";

        if ($notify == 1 && $area=="C") {
            $info.="<span><br><br>交通組義工全程報到時間：2017年1月30日(初三)上午6:50~7:00，報到地點：國中教室</span>";
        }

        $info.="</td></tr>";

        $info.="<tr><td></td><td></td></tr>";

        $info.="<tr><td style=\"width:30px;text-align:right;\">二、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>非全程報到時間(含單日)：2017年1月31日或2月1日上午7:00~7:30，報到地點：聯合服務台。</span>";

        if ($notify == 1 && $area=="C") {
            $info.="<span><br><br>交通組義工報到時間：2017年1月31日或2月1日上午6:20~6:30，報到地點：國中教室</span>";
        }
        $info.="</td></tr>";
        
        $info.="<tr><td></td><td></td></tr>";

        $info.="<tr><td style=\"width:30px;text-align:right;\">三、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>攜帶：名牌、身份證、健保卡、餐具、禦寒外套、</span><span style=\"text-decoration:underline; background-color:#E0E0E0;\"> 睡袋</span>";
        $info.="<span style=\"font-size: 10pt;\"> (因園區資材不足，住宿者務必攜帶以免受寒)</span>。";
        $info.="</td></tr>";

        $info.="<tr><td></td><td></td></tr>";

        if ($notify != 1) { // 各組組長  (非研討母班)
            $info.="<tr><td style=\"width:30px;text-align:right;\">四、</td>";
            $info.="<td style=\"width:650px;text-align:left;\">";
            $info.="<span>搭遊覽車者：請至各區淨智處購票。</span>";
            $info.="</td></tr>";
            $info.="<tr><td></td><td></td></tr>";

            $info.="<tr><td style=\"width:30px;text-align:right;\">五、</td>";
            $info.="<td style=\"width:650px;text-align:left;\">";
            $info.="<span>自行開車前往者，請自行放置 \"姓名與聯絡電話\" 標示牌，於車前擋風玻璃內，以便交通組聯絡！</span>";
            $info.="</td></tr>";

            $info.="<tr><td></td><td></td></tr>";

            $info.="<tr><td style=\"width:30px;text-align:right;\">六、</td>";
            $info.="<td style=\"width:650px;text-align:left;\">";
            $info.="<span>任何問題請聯絡報名報到組：蕭郁蓉 0928-751712，楊臨賢 0929-313972。</span>";
            $info.="</td></tr>";
        } else { // 研討班=>要分區而有不同內容
            if ($area=="B") { // 中區
                $info.="<tr><td style=\"width:30px;text-align:right;\">四、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>搭遊覽車者：請於1/18(三)前至台中學苑淨智處購票。車資：260元。</span>";
                $info.="<br><span>任何問題請聯絡：陳淑齡 0928-455293。黃珮樺 0955-100593</span>";
                $info.="</td></tr>";
                //$info.="<tr><td></td><td></td></tr>";

                $info.="<tr><td style=\"width:30px;text-align:right;\">五、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>1/30(初三)搭車時間：【去程僅1/30發義工遊覽車，遊覽車回程時間約2/1下午五點】。</span>";
                $info.="<br><span>仁美公園 6:00  忠明國小側門 6:00  南屯教室 6:30  彰化向陽停車場 6:40 </span>";
                $info.="</td></tr>";
                
                $info.="<tr><td style=\"width:30px;text-align:right;\">六、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>自行開車前往者，請自行放置 \"姓名與聯絡電話\" 標示牌，於車前擋風玻璃內，以便交通組聯絡！</span>";
                $info.="</td></tr>";

            } else if ($area=="C") { //嘉區
            
                $info.="<tr><td style=\"width:30px;text-align:right;\">四、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>自行開車前往者，請自行放置 \"姓名與聯絡電話\" 標示牌，於車前擋風玻璃內，以便交通組聯絡！</span>";
                $info.="</td></tr>";

            } else if ($area=="E") {
                $info.="<tr><td style=\"width:30px;text-align:right;\">四、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>搭遊覽車者：請於1/23(一)前至高雄學苑淨智處購票。車資：單程290元或全程580元。</span>";
                $info.="<br><span>任何問題請聯絡：蕭郁蓉0928-751712。楊臨賢0929-313972</span>";
                $info.="</td></tr>";
                //$info.="<tr><td></td><td></td></tr>";

                $info.="<tr><td style=\"width:30px;text-align:right;\">五、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>1/30(初三)搭車時間：【去程僅1/30發義工遊覽車，遊覽車回程時間約2/1下午五點】。</span>";
                $info.="<br><span>小港空大5:20  鳳山行政中心5:30  大順建工5:40  文化中心5:40  楠梓交流道5:50</span>";
                $info.="</td></tr>";
                
                $info.="<tr><td style=\"width:30px;text-align:right;\">六、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>自行開車前往者，請自行放置 \"姓名與聯絡電話\" 標示牌，於車前擋風玻璃內，以便交通組聯絡！</span>";
                $info.="</td></tr>";
            
            } else { //套各組組長
                $info.="<tr><td style=\"width:30px;text-align:right;\">四、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>搭遊覽車者：請至各區淨智處購票。</span>";
                $info.="</td></tr>";
                $info.="<tr><td></td><td></td></tr>";

                $info.="<tr><td style=\"width:30px;text-align:right;\">五、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>自行開車前往者，請自行放置 \"姓名與聯絡電話\" 標示牌，於車前擋風玻璃內，以便交通組聯絡！</span>";
                $info.="</td></tr>";

                $info.="<tr><td></td><td></td></tr>";

                $info.="<tr><td style=\"width:30px;text-align:right;\">六、</td>";
                $info.="<td style=\"width:650px;text-align:left;\">";
                $info.="<span>任何問題請聯絡報名報到組：蕭郁蓉 0928-751712，楊臨賢 0929-313972。</span>";
                $info.="</td></tr>";
            }



            //$info.="<tr><td></td><td></td></tr>";
        }

        $info.="<tr><td></td><td></td></tr>";
        
        $info.="<tr>";
        $info.="<td style=\"width:180px;text-align:right;\">";
        $info.="<h3>祝福您 福智圓滿！</h3></td>";
        $info.="<td style=\"width:500px;text-align:right;\"><br><br>園區朝禮法會報名報到組  合十  ".$year.".01</td></tr>";
        $info.="</table>";
        return $info;
    }
    
    function getPDFinfo_old()
    {
        $info="<style>span{ color: black; font-size: 14pt; text-decoration:underline; background-color:#E0E0E0;}</style>";
        
        $info.="<table border=\"0\">";        
        $info.="<tr><td style=\"width:30px;text-align:right;\">一、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="時間：11月26日(六)，自行前往者<span>請於11月26日上午8:00前至現場服務台完成報到</span>。";
        $info.="</td></tr>";
     
        //$info.="<tr><td style=\"width:680px;height:4px;text-align:left;\">";
        //$info.="</td></tr>"; 
        
        $info.="<tr><td style=\"width:30px;text-align:right;\"></td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span>為敬重受戒故，請大家準時參加。</span>";
        $info.="</td></tr>";    
        
        $info.="<tr><td></td><td></td></tr>";

        
        $info.="<tr><td style=\"width:30px;text-align:right;\">二、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="報到地點：<span style=\"font-size: 12pt;\">園區 宗仰大樓 1樓慈生藥局與里仁中間，請務必領取貼紙並張貼左胸上面入場</span>，";
        $info.="</td></tr>";
        
        $info.="<tr><td style=\"width:30px;text-align:right;\"></td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="<span style=\"font-size: 12pt;\">以利引導義工辨識</span>。";
        $info.="</td></tr>";      

        $info.="<tr><td></td><td></td></tr>";
        
        $info.="<tr><td style=\"width:30px;text-align:right;\">三、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="請注意下列事項：【搭遊覽車者，採車上報到】";
        $info.="</td></tr>";
        
        $info.="<tr><td style=\"width:30px;text-align:right;\"></td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="1.請攜帶小本廣論、報到通知單、供養金、名牌、環保杯、身分證、健保卡。";
        $info.="</td></tr>";
        $info.="<tr><td style=\"width:30px;text-align:right;\"></td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="2.請勿攜帶任何食品、貴重手飾、物品，手機正行時請關機。";
        $info.="</td></tr>";
        //$info.="<tr><td style=\"width:30px;text-align:right;\"></td>";
        //$info.="<td style=\"width:650px;text-align:left;\">";
        //$info.="3.交通費用：(車資當天來回 290 元）";
        //$info.="</td></tr>";

        $info.="<tr><td></td><td></td></tr>";
            
        $info.="<tr><td style=\"width:30px;text-align:right;\">四、</td>";
        $info.="<td style=\"width:650px;text-align:left;\">";
        $info.="臨時有事不能參加，請儘速至各學支苑，教室或服務台辦理取消登記，俾利車輛確定。";
        $info.="</td></tr>";
     
        $info.="<tr><td></td><td></td></tr>";
        $info.="<tr><td></td><td></td></tr>";
        
        $info.="<tr>";
        $info.="<td style=\"width:650px;text-align:right;\">";
        $info.="淨智處 合十   2016.11";
        $info.="</td><td style=\"width:30px;text-align:right;\"></td></tr>";
     
        $info.="</table>";
        return $info;
    }

    function getPDFLn()
    {    
        $html_line="<table><tr><td></td><td></td></tr></table>";
        return $html_line;
    }

    function getPDFSPLn()
    {
        $spLine="<table>";
        $spLine.="<tr><td></td></tr>";
        $spLine.="<tr><td style=\"color:#D0D0D0;text-align:center;\">";
        $spLine.="--------------------------------------------------------";
        $spLine.="--------------------------------------------------------";
        $spLine.="--------------------------------------------------------";
        $spLine.="</td></tr>";
        $spLine.="</table>";

        return $spLine;
    }    
    
    
?>
