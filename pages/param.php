<?php
    session_start();
    if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||isset($_SESSION["auth"])==false||$_SESSION["area"]!="newyear"){
        header("Location: ../index.php");
    }
    // check auth
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

    require_once("../api/lib/common.php");
    require_once("../api/lib/params.php");
    $auth=$_SESSION["auth"];
    $groupexpire=$_SESSION["groupexpire"];
    $groupok=$_SESSION["group"];
    $expire=$_SESSION["expire9"];

    $menu=checkAuth(8, $auth, $expire, $groupexpire);
    if($menu=="NO"){
        unset($_SESSION["area"]);
        unset($_SESSION["username"]);
        unset($_SESSION["account"]);
        unset($_SESSION["username"]);
        unset($_SESSION["userlevel"]);
        unset($_SESSION["auth"]);
        unset($_SESSION["key"]);
        header("Location: ../index.php");
        exit;
    }
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
    <title>朝禮法會義工管理</title>
    <link href="../resource/css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap Core CSS -->
    <link href="../resource/css/metisMenu.min.css" rel="stylesheet"><!-- MetisMenu CSS -->
    <link href="../resource/dataTables/css/jquery.dataTables.min.css" rel="stylesheet"><!-- MetisMenu CSS -->
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
                    <div class="col-lg-12" align="center">
                        <h3 class="page-header">參數調整</h3>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-2" align="center"></div>
                    <div class="col-lg-8" align="center">
                        <div class="input-group custom-search-form">
<table class="table table-bordered">
  <thead>
    <tr>
      <th>大組</th>
      <th>小組</th>
      <th>+應到</th>
      <th>+實到</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>善法實踐</td>
      <td>大組</td>
      <td><input type="text" class="form-control" id="group11S" aria-label="..." value=0></td>
      <td><input type="text" class="form-control" id="group11R" aria-label="..." value=0></td>
    </tr>
    <tr>
      <td>善法實踐</td>
      <td>平安麵</td>
      <td><input type="text" class="form-control" id="group12S" aria-label="..." value=0></td>
      <td><input type="text" class="form-control" id="group12R" aria-label="..." value=0></td>
    </tr>
    <tr>
      <td>善法實踐</td>
      <td>企業善法</td>
      <td><input type="text" class="form-control" id="group13S" aria-label="..." value=0></td>
      <td><input type="text" class="form-control" id="group13R" aria-label="..." value=0></td>
    </tr>
    <tr>
      <td>善法實踐</td>
      <td>美食展</td>
      <td><input type="text" class="form-control" id="group14S" aria-label="..." value=0></td>
      <td><input type="text" class="form-control" id="group14R" aria-label="..." value=0></td>
    </tr>
    <tr>
      <td>善法實踐</td>
      <td>傳心小組</td>
      <td><input type="text" class="form-control" id="group15S" aria-label="..." value=0></td>
      <td><input type="text" class="form-control" id="group15R" aria-label="..." value=0></td>
    </tr>
  </tbody>
</table>
                        </div>
                    </div>
                    <div class="col-lg-2" align="center"></div>
                 </div>
                 <!-- /.row -->
                 <div class="row"><div class="col-lg-12" align="center"><br></div></div>

                <div class="row">
                     <div class="col-lg-5" align="center"></div>
                     <div class="col-lg-2" align="center">
                         <button type="button" class="btn btn-primary btn-lg btn-block" id="param-submit">儲  存</button>
                     </div>
                     <div class="col-lg-5" align="center"></div>
                 </div>
                 <!-- /.value -->

                 <?php
                     include("data.php");
                     echo "<input type='hidden' id='groupkey' class='groupkey' name='groupkey' value='".$groupkey."' />";
                 ?>
                 <?php include("dialog.php"); ?>
                 <!-- /.row show data-->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script src="../resource/js/jquery-2.1.4.min.js"></script><!-- jQuery -->
    <script src="../resource/js/bootstrap.min.js"></script><!-- Bootstrap Core JavaScript -->
    <script src="../resource/js/metisMenu.min.js"></script><!-- Metis Menu Plugin JavaScript -->
    <script src="../resource/dataTables/js/jquery.dataTables.min.js"></script><!-- Metis Menu Plugin JavaScript -->
    <script src="../resource/js/ucamp.js"></script><!-- Custom Theme JavaScript -->
    <script src="../resource/js/api.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>
    <script src="../resource/js/param.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>
</body>

</html>
