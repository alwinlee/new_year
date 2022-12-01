<?php
    // 資料庫連線設定
    $cloud  =  FALSE;
    if ($cloud == FALSE) {
      $db_host = "localhost";
      $db_table = "bwfocebmbd";
      $db_username = "root";
      $db_password = "rinpoche";
    } else {
      $db_host = "";
      $db_table = "";
      $db_username = "";
      $db_password = "";
    }

    if (!@mysql_connect($db_host, $db_username, $db_password)) {
        die("資料連結失敗！");
    }

    if (!@mysql_select_db($db_table)) {//連接資料庫
        die("資料庫選擇失敗！");
    }
    mysql_query("SET NAMES 'utf8'");//設定字元集與連線校對
?>
