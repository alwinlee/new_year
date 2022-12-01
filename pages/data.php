<?php
    date_default_timezone_set('Asia/Taipei');
    $currDate = date('Y-m-d');
    $apply = $_SESSION["account"];

    echo "<input type='hidden' id='subgroup1' class='subgroup' name='subgroup1' value='大組;報名報到;會計;公關;' />";
    echo "<input type='hidden' id='subgroup2' class='subgroup' name='subgroup2' value='大組;理念;慈心展;文教展;園區展;文宣採訪;多媒體;' />";
    echo "<input type='hidden' id='subgroup3' class='subgroup' name='subgroup3' value='大組;服務引導;交通;壇城;視聽;機動;醫療小組;' />";
    echo "<input type='hidden' id='subgroup4' class='subgroup' name='subgroup4' value='大組;場地;監修;資材;餐食;茶水;環保;廣供;' />";
    echo "<input type='hidden' id='subgroup5' class='subgroup' name='subgroup5' value='大組;平安麵;企業善法;美食展;傳心小組;' />";
    echo "<input type='hidden' id='subgroup6' class='subgroup' name='subgroup6' value='大會;' />";
    echo "<input type='hidden' id='basic-date' class='basic-date' name='basic-date' value='".$currDate."' />";
    echo "<input type='hidden' id='basic-apply' class='basic-apply' name='basic-apply' value='".$apply."' />";
    echo "<input type='hidden' id='basic-id' class='basic-id' name='basic-id' value=0 />";
    echo "<input type='hidden' id='basic-serial' class='basic-serial' name='basic-serial' value=0 />";
    echo "<input type='hidden' id='basic-deleteid' class='basic-deleteid' name='basic-deleteid' value=0 />";
    echo "<input type='hidden' id='basic-deleteserial' class='basic-deleteserial' name='basic-deleteserial' value=0 />";
    echo "<input type='hidden' id='typeitem' class='typeitem' name='typeitem' value='總護持;副總護持;大會助理;顧問;大組長;副大組長;大組助理;小組長;副小組長;義工;見習幹部;見習助理;' />";
    echo "<input type='hidden' id='clsother' class='clsother' name='clsother' value='廠商;廠商義工;' />";