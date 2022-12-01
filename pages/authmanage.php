<?php
session_start();
if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="newyear"){
    header("Location: login.html");
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
    <link href="../resource/dataTables/css/jquery.dataTables.min.css" rel="stylesheet"><!-- MetisMenu CSS -->
    <link href="../resource/css/ucamp.css" rel="stylesheet"><!-- Custom CSS -->
    <link href="../resource/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- Custom Fonts -->
    <style type="text/css">
    html, body{height:100%; margin:0;padding:0;font-family:Meiryo,"微軟正黑體","Microsoft JhengHei";}
    .container-fluid{height:90%;display:table;width:100%;padding:0;}
    .row-fluid{height:100%; display:table-cell; vertical-align: middle;}
    .centering{float:none;margin:0 auto;}
    .righting{float:right;margin:0 auto;}
    .sx-checkbox {width: 24px; height: 24px;}
    .mx-checkbox {width: 30px; height: 30px;}
    .sx-radio {width: 18px; height: 18px;}
    .mx-radio {width: 24px; height: 24px;}
    .lx-radio {width: 30px; height: 30px;}
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
                        <h3 class="page-header">權限管理</h3>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-2" align="center"></div>
                    <div class="col-lg-8" align="center">
                        <div class="input-group custom-search-form">
                            <!--<input type="text" class="form-control" placeholder="請輸入組別、錄取編號、姓名、電話或學校關鍵字查詢 ..." id="keyword">-->
                            <select class="form-control" id="exporttype">
                              <option value=0>新增</option>
                              <option value=1>修改</option>
                              <option value=2>刪除</option>
                            </select>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="list">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2" align="center"></div>
                </div>
                 <!-- /.row -->
                 <div class="row"><div class="col-lg-12" align="center"><br></div></div>

                <div class="row">
                    <div class="col-lg-12" align="center" id="searchdata">
                    <table id="datagrid" class="table table-striped table-bordered" cellspacing="0" width="100%" style="display:none;" disabled>
                        <thead>
                            <th>報到</th>
                            <th>錄取編號</th>
                            <th>姓名</th>
                            <th>學校</th>
                            <th>科系</th>
                        </thead>
                    </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12" align="center" id="searchdata">
                    </div>
                </div>

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
    <script src="../resource/js/auth.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>
</body>

</html>
