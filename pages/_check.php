<?php
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
    echo $sysname.'義工管理-報到';
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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><img src="../resource/img/ucamp_icon.png"></a>
            </div>
           <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-1" align="center"></div>
                    <div class="col-xs-10" align="center">
                        <h3 class="page-header">朝禮法會義工報名報到 報到登錄</h3>
                    </div>
                    <div class="col-xs-1" align="center"></div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-xs-1" align="center"></div>
                    <div class="col-xs-10" align="center">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="請輸入組別、錄取編號、姓名、電話或學校關鍵字查詢 ..." id="keyword">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="checkinsearch">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="col-xs-1" align="center"></div>
                </div>
                 <!-- /.row -->
                 <div class="row"><div class="col-xs-12" align="center"><br></div></div>

                 <div class="row">
                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="statusReport">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">大專營報到登錄</h4>
                          </div>
                          <div class="modal-body text-center">
                            成功!
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="statusCancel">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">大專營報到取消</h4>
                          </div>
                          <div class="modal-body text-center">
                            成功!
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="statusDataError">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">資料錯誤</h4>
                          </div>
                          <div class="modal-body text-center">
                            未設定去程交通!
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="col-xs-1" align="center"></div>-->
                    <div class="col-xs-12" align="center" id="searchdata"></div>
                    <!-- <div class="col-xs-1" align="center"></div>-->

                </div>
                 <!-- /.row show data-->
            </div>
            <!-- /.container-fluid -->


    </div>
    <!-- /#wrapper -->

    <script src="../resource/js/jquery-2.1.4.min.js"></script><!-- jQuery -->
    <script src="../resource/js/bootstrap.min.js"></script><!-- Bootstrap Core JavaScript -->
    <script src="../resource/js/metisMenu.min.js"></script><!-- Metis Menu Plugin JavaScript -->
    <script src="../resource/js/ucamp.js"></script><!-- Custom Theme JavaScript -->
    <script src="../resource/js/api.js?{CED65810-7F03-4706-A4AD-89213E541932}"></script>
    <script src="../resource/js/check.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>
</body>

</html>
