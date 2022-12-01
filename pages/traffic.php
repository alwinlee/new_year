<?php
session_start();
if(isset($_SESSION["account"])==false||$_SESSION["account"]==""||$_SESSION["area"]!="newyear"){
    header("Location: login.html");
}
?>
<!DOCTYPE html>
<html lang="en"><META content="IE=11.0000" http-equiv="X-UA-Compatible">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../resource/img/ucamp.ico">
    <link rel="shortcut icon" href="../resource/img/ucamp.ico">
    <title>朝禮法會義工報名報到-交通</title>   
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
    
    .vcenter {
        vertical-align: middle;        
    }
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
			<ul class="nav navbar-top-links navbar-left">                
                <li><a class="navbar-brand" href="index.html" > 朝禮法會義工報名報到</a></li>
            </ul>
            <!-- -->
            <ul class="nav navbar-top-links navbar-right">                
                <li><a class="glyphicon glyphicon-log-out" href=".\logout.php">     </a></li>
            </ul>
            <!-- -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav nav-first-level" id="side-menu">
                    
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="查詢 ..."  id="keyowrd">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"  id="search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li><a href="addin.php"><i class="glyphicon glyphicon-plus"></i> 義工報名</a></li>
                        <li><a href="editin.php"><i class="glyphicon glyphicon-edit"></i> 義工更新</a></li>
                    
                        <li><a href="search.php"><i class="glyphicon glyphicon-search"></i> 資料查詢</a></li>
                        <li><a href="checkin.php"><i class="glyphicon glyphicon-saved"></i> 報到登錄</a></li>
                        <li><a href="traffic.php"><i class="glyphicon glyphicon-transfer"></i> 交通登錄</a></li>
                        <?php
                            if(isset($_SESSION["auth"])){
                                $auth=$_SESSION["auth"];                            
                                if($auth[0]=="1"){
                                    echo "<li><a href=\"statistic.php\"><i class=\"glyphicon glyphicon-saved\"></i> 統計查詢</a></li>";
                                }
                            } 
                        ?>                        
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">                                
                                <span class="input-group-btn">                                    
                                </span>
                            </div>                            
                        </li> 
                        <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> 登出</a></li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper" style="background-image: url('../resource/img/back.png');">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12" align="center">
                        <h3 class="page-header">朝禮法會義工報名報到 交通登錄</h3>                   
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-2" align="center"></div>
                    <div class="col-lg-8" align="center">                  
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="請輸入組別、錄取編號、姓名、電話或學校關鍵字查詢 ..." id="keyword">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="trafficsearch">
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

                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="statusReport">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">交通</h4>
                          </div>
                          <div class="modal-body">
                            儲存成功!
                          </div>
                        </div>
                      </div>
                    </div>

             
                
                    <div class="col-lg-12 vcenter" align="center" id="searchdata">                    
                    </div>     
                </div>
                 <!-- /.row show data-->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    
    <!--
    <input type="hidden" id="traffitem" class="traffitem" name="traffitem" value="台北專車;桃園專車;新竹專車;台中專車;台南專車;高雄專車;苗栗火車站接駁;自行前往;;" />
    <input type="hidden" id="trafffee" class="trafffee" name="trafffee" value="500;500;450;400;300;200;150;0;0;" />
    -->
    <input type="hidden" id="traffitem" class="traffitem" name="traffitem" value=";" />
    <input type="hidden" id="trafffee" class="trafffee" name="trafffee" value="" />
    <!-- /#wrapper -->
    
    <script src="../resource/js/jquery-2.1.4.min.js"></script><!-- jQuery -->    
    <script src="../resource/js/bootstrap.min.js"></script><!-- Bootstrap Core JavaScript -->    
    <script src="../resource/js/metisMenu.min.js"></script><!-- Metis Menu Plugin JavaScript -->    
    <script src="../resource/js/ucamp.js"></script><!-- Custom Theme JavaScript -->    
    <script src="../resource/js/api.js?{CED65810-7F03-4706-A4AD-89213E541932}"></script>    
    <script src="../resource/js/fn.js?{CED65810-7F03-4706-A4AD-89213E541932}"></script>
    <script src="../resource/js/traffic.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>
</body>

</html>
