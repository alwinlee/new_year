<?php
  session_start();
  if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="newyear"){
      header("Location: ../index.php");
  }
  date_default_timezone_set('Asia/Taipei');
  $expire_date=$_SESSION["expireday"];
  $today_date=new DateTime();
  $today_date=date_format($today_date, 'Y-m-d');
  //    echo strtotime($today_date)." - today <br>";
  //    echo strtotime($expire_date)." - ".$_SESSION["expireday"]." - expire <br>";
  if (strtotime($today_date) > strtotime($expire_date)){
      header("Location: ../index.php");
      //echo strtotime($today_date)." - today <br>";
      //echo strtotime($expire_date)." - expire <br>";
  }
  require_once("../api/lib/params.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../resource/img/ucamp.ico">
    <link rel="shortcut icon" href="../resource/img/ucamp.ico">
    <title>
<?php
    echo $sysname.'義工管理';
?>
    </title>
    <link href="../resource/css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap Core CSS -->
    <link href="../resource/css/metisMenu.min.css" rel="stylesheet"><!-- MetisMenu CSS -->
    <link href="../resource/css/ucamp.css" rel="stylesheet"><!-- Custom CSS -->
    <link href="../resource/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- Custom Fonts -->
    <style type="text/css">
    html, body{height:100%; margin:0;padding:0;font-family:Meiryo,"微軟正黑體","Microsoft JhengHei";}
    .container-fluid{height:90%;display:table;width:100%;padding:0;}
    .row-fluid{height:100%; display:table-cell; vertical-align: middle;}
    .centering{float:none;margin:0 auto;}
    .righting{float:right;margin:0 auto;}
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php include("menu.php"); ?>

        <!-- Page Content -->

        <div id="page-wrapper" style="background-image: url('../resource/img/back.png');">
            <div class="container-fluid">
                <div class="row">
                    <!--<div class="col-lg-1"></div>-->
                    <div class="col-lg-12">
                    <h4 class="page-header"></h4>

                    <div class="panel panel-danger">
                        <div class="panel-heading"> <h1 class="panel-title">法會時間與報名</h1></div>
                        <div class="panel-body">
                        <p>1. 2017年1月30日(週一、年初三)上午7:30～2月1日(週三、年初五)下午5:00</p>
                        <p>2. 2017年1月29日僅提供壇場及廣供組等特例組別報名。</p>
                        <p>3. 報名截止日：2016/12/2(五)。</p>
                        <p>4. 聯絡人：蕭郁蓉師姐 0928-751-712，(07)3805895#396 </p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;聯絡人：楊臨賢師兄 0929-313-972，(07)281-9699#202</p>
                        </div>
                        <!--
                        &nbsp;
                        它叫不換行空格，全稱No-Break Space，它是最常見和我們使用最多的空格，大多數的人可能只接觸了&nbsp;，它是按下space鍵產生的空格。在HTML中，如果你用空格鍵產生此空格，空格是不會累加的（只算1個）。要使用html實體表示才可累加，該空格佔據寬度受字體影響明顯而強烈。
                        &ensp;
                        它叫“半角空格”，全稱是En Space，en是字體排印學的計量單位，為em寬度的一半。根據定義，它等同於字體度的一半（如16px字體中就是8px）。名義上是小寫字母n的寬度。此空格傳承空格家族一貫的特性：透明的，此空格有個相當穩健的特性，就是其占據的寬度正好是1/2個中文寬度，而且基本上不受字體影響。
                        &emsp;
                        它叫“全角空格”，全稱是Em Space，em是字體排印學的計量單位，相當於當前指定的點數。例如，1 em在16px的字體中就是16px。此空格也傳承空格家族一貫的特性：透明的，此空格也有個相當穩健的特性，就是其占據的寬度正好是1個中文寬度，而且基本上不受字體影響。
                        &thinsp;
                        它叫窄空格，全稱是Thin Space。我們不妨稱之為“瘦弱空格”，就是該空格長得比較瘦弱，身體單薄，佔據的寬度比較小。它是em之六分之一寬。
                        &zwnj;
                        它叫零寬不連字，全稱是Zero Width Non Joiner，簡稱“ZWNJ”，是一個不打印字符，放在電子文本的兩個字符之間，抑製本來會發生的連字，而是以這兩個字符原本的字形來繪製。 Unicode中的零寬不連字字符映射為“”（zero width non-joiner，U+200C），HTML字符值引用為： ‌
                        -->
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"> <h1 class="panel-title">報名填寫說明</h1></div>
                        <div class="panel-body">
                        <p>1. 一律網路報名，各欄均須填寫，請勿重複報名。</p>
                        <p>2. 邀請之親友，請填其姓名，若非廣論學員，「母班班別」欄填邀請人班級。</p>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading"> <h1 class="panel-title">其他注意事項</h1></div>
                        <div class="panel-body">
                        <p>1. 【南區】欲搭乘遊覽車的義工，請填搭車地點代號：
                           AC小港空大，AB大順/建工，AE文化中心，AF鳳山行政中心，BB楠梓交流道，來回580元。發車時間：以車票為主。</p>
                        </div>
                    </div>
                    </div>
                    <!--<div class="col-lg-1"></div>-->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <script src="../resource/js/jquery-2.1.4.min.js"></script><!-- jQuery -->
    <script src="../resource/js/bootstrap.min.js"></script><!-- Bootstrap Core JavaScript -->
    <script src="../resource/js/metisMenu.min.js"></script><!-- Metis Menu Plugin JavaScript -->
    <script src="../resource/js/ucamp.js"></script><!-- Custom Theme JavaScript -->
    <script src="../resource/js/api.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>
    <script src="../resource/js/main.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>
</body>

</html>
