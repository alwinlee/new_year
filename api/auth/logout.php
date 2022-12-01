<?php 
    ini_set("error_reporting",0);
    ini_set("display_errors","Off"); // On : open, O
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["account"]);
    unset($_SESSION["username"]);
    unset($_SESSION["userlevel"]);
    unset($_SESSION["auth"]);
    unset($_SESSION["key"]);
    unset($_SESSION["area"]);
    unset($_SESSION["expire"]);
	
    header("Location: ../../pages/index.html");
    /*
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    $data[]=Array("AAA","BBB","CCC","DDD","EEE","FFF");
    
    $json_data = array(
                "draw"            => $draw,
                "recordsTotal"    => 300,
                "recordsFiltered" => 300,
                "data"            => $data
            );
   header("Content-type: application/json");
   //header("Content-Type: text/html; charset=utf-8");
   echo json_encode($json_data);  */  
?>

