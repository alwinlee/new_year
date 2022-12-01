<?php
    session_start();
    date_default_timezone_set('Asia/Taipei');
    require_once("../api/lib/common.php");

    echo "<nav class=\"navbar navbar-default navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">";
    echo "<div class=\"navbar-header\">";
    echo "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">";
    echo "<span class=\"sr-only\">Toggle navigation</span>";
    echo "<span class=\"icon-bar\"></span>";
    echo "<span class=\"icon-bar\"></span>";
    echo "<span class=\"icon-bar\"></span>";
    echo "</button>";
    echo "<a class=\"navbar-brand\" href=\"index.html\"><img src=\"../resource/img/ucamp_icon.png\"></a>";
    echo "</div>";
    echo "<ul class=\"nav navbar-top-links navbar-left\"> ";

    $currY=date('Y');
    $currM=date('m');
    if ($currM>=10){$currY+=1;}

    echo "<li><a class=\"navbar-brand\" href=\"main.php\" >".$currY."年 ".$sysname."義工管理</a></li>";
    echo "</ul>";

    echo "<ul class=\"nav navbar-top-links navbar-right\">";
    echo "<li><a class=\"glyphicon glyphicon-log-out\" href=\".\logout.php\">     </a></li>";
    echo "</ul>";

    echo "<div class=\"navbar-default sidebar\" role=\"navigation\">";
    echo "<div class=\"sidebar-nav navbar-collapse\">";
    echo "<ul class=\"nav nav-first-level\" id=\"side-menu\">";

    //echo "<li class=\"sidebar-search\">";
    //echo "<div class=\"input-group custom-search-form\">";
    //echo "<input type=\"text\" class=\"form-control\" placeholder=\"查詢 ...\"  id=\"keyowrd\">";
    //echo "<span class=\"input-group-btn\">";
    //echo "<button class=\"btn btn-default\" type=\"button\"  id=\"search\">";
    //echo "<i class=\"fa fa-search\"></i>";
    //echo "</button>";
    //echo "</span>";
    //echo "</div>";
    //echo "</li>";

    if(isset($_SESSION["auth"])){
        $auth=$_SESSION["auth"];
        $groupexpire=$_SESSION["groupexpire"];

        echo "<li><a href=\"main.php\"><i class=\"glyphicon glyphicon-paperclip\"></i> 報名填寫說明</a></li>";
        $expire=$_SESSION["expire1"];
        $menu=checkAuth(0, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[0]=="1"){
            echo "<li><a href=\"addin.php\"><i class=\"glyphicon glyphicon-plus\"></i> 義工報名</a></li>";
        }

        $expire=$_SESSION["expire2"];
        $menu=checkAuth(1, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[1]=="1"){
            echo "<li><a href=\"editin.php\"><i class=\"glyphicon glyphicon-edit\"></i> 義工更新</a></li>";
        }

        //echo "<li><a href=\"search.php\"><i class=\"glyphicon glyphicon-search\"></i> 資料查詢</a></li>";
        //echo "<li><a href=\"checkin.php\"><i class=\"glyphicon glyphicon-saved\"></i> 報到登錄</a></li>";
        //echo "<li><a href=\"traffic.php\"><i class=\"glyphicon glyphicon-transfer\"></i> 交通登錄</a></li>";

        $expire=$_SESSION["expire3"];
        $menu=checkAuth(2, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[5]=="1"){
            echo "<li><a href=\"searchin.php\"><i class=\"glyphicon glyphicon-zoom-in\"></i> 義工查詢</a></li>";
        }

        $expire=$_SESSION["expire5"];
        $menu=checkAuth(4, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[5]=="1"){
            echo "<li><a href=\"checkin.php\"><i class=\"glyphicon glyphicon-check\"></i> 義工報到</a></li>";
        }

        //$expire=$_SESSION["expire6"];
        //$menu=checkAuth(5, $auth, $expire, $groupexpire);
        //if($menu!="NO"&&$menu!=""){//if($auth[5]=="1"){
        //    echo "<li><a href=\"prevcheckin.php\"><i class=\"glyphicon glyphicon-ok-sign\"></i> 打掃報到</a></li>";
        //}

        $expire=$_SESSION["expire7"];
        $menu=checkAuth(6, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[5]=="1"){
            echo "<li><a href=\"invoice.php\"><i class=\"glyphicon glyphicon-print\"></i> 印報到單</a></li>";
        }

        $expire=$_SESSION["expire8"];
        $menu=checkAuth(7, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[5]=="1"){
            echo "<li><a href=\"livein.php\"><i class=\"glyphicon glyphicon-bed\"></i> 住宿調整</a></li>";
        }

        $expire=$_SESSION["expire9"];
        $menu=checkAuth(8, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[5]=="1"){
            echo "<li><a href=\"param.php\"><i class=\"glyphicon glyphicon-sunglasses\"></i> 參數調整</a></li>";
        }

        $expire=$_SESSION["expire4"];
        $menu=checkAuth(3, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[5]=="1"){
            echo "<li><a href=\"statistic.php\"><i class=\"glyphicon glyphicon-saved\"></i> 下載報表</a></li>";
        }

        $expire=$_SESSION["expire20"];
        $menu=checkAuth(20, $auth, $expire, $groupexpire);
        if($menu!="NO"&&$menu!=""){//if($auth[9]=="1"){
            echo "<li><a href=\"authmanage.php\"><i class=\"glyphicon glyphicon-saved\"></i> 權限管理</a></li>";
        }
    }

    echo "<li class=\"sidebar-search\">";
    echo "<div class=\"input-group custom-search-form\">";
    echo "<span class=\"input-group-btn\">";
    echo "</span>";
    echo "</div>";
    echo "</li>";
    echo "<li><a href=\"logout.php\"><i class=\"glyphicon glyphicon-log-out\"></i> 登出</a></li>";
    echo "</ul>";
    echo "</div>";
    echo "</div>";
    echo "</nav>";
