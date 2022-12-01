<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./resource/img/ucamp.ico">
    <link rel="shortcut icon" href="./resource/img/ucamp.ico">    
    <title>朝禮法會義工管理-登入</title>
    <link href="./resource/css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap Core CSS -->    
    <link href="./resource/css/metisMenu.min.css" rel="stylesheet"><!-- MetisMenu CSS -->    
    <link href="./resource/css/ucamp.css" rel="stylesheet"><!-- Custom CSS -->    
    <link href="./resource/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- Custom Fonts -->
    
    <style type="text/css">
    html, body{height:100%;background-image: url("./resource/img/back.png");margin:0;padding:0;font-family:Meiryo,"微軟正黑體","Microsoft JhengHei";}
    .container-fluid{height:90%;display:table;width:100%;padding:0;} 
    .row-fluid{height:100%; display:table-cell; vertical-align: middle;} 
    .centering{float:none;margin:0 auto;}
    .righting{float:right;margin:0 auto;}
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">請輸入帳號及密碼後登入</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="login.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="帳號" id="account" name="account" type="account" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="密碼" id="password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <!--<label>
                                        <input name="remember" type="checkbox" value="Remember Me">記住
                                    </label>-->
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <!--<a href="index.html" class="btn btn-lg btn-success btn-block" id="login">登入</a>-->
                                <input type="submit" class="btn btn-lg btn-success btn-block" id="login" value="登入"></input>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <script src="./resource/js/jquery-2.1.4.min.js"></script><!-- jQuery -->    
    <script src="./resource/js/bootstrap.min.js"></script><!-- Bootstrap Core JavaScript -->    
    <script src="./resource/js/metisMenu.min.js"></script><!-- Metis Menu Plugin JavaScript -->    
    <script src="./resource/js/ucamp.js"></script><!-- Custom Theme JavaScript -->    
    <script src="./resource/js/api.js?{CED65810-7F03-4706-A4AD-89213E541932}" type="text/javascript" charset="utf-8"></script>    
</body>

</html>
