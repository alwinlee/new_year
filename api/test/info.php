<?php 
    ini_set("error_reporting",0);
    ini_set("display_errors","Off"); // On : open, O
/*
    $draw=$_POST['draw'];
    $start=$_POST['start'];
    $len=$_POST['len'];  
   
    $total=300;
*/
    
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
   echo json_encode($json_data);    
?>

