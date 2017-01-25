<?php

     include "function.inc";

//mysql
    $link = mysql_connect('mysql3.000webhost.com', 'a2988517_youtube', 'yamamototamura40');
    if (!$link) {
        die('接続失敗です。'.mysql_error());
    }

    $db_selected = mysql_select_db('a2988517_gaku', $link);
    if (!$db_selected){
        die('データベース選択失敗です。'.mysql_error());
    }
    
    $result = mysql_query("SELECT v FROM youtube");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }

    $i = 1;
    while($row = mysql_fetch_assoc($result)){
        $vvv = $row['v'];
        if(getPageTitle('https://www.youtube.com/watch?v=' . $vvv) == "YouTube"){
            $result_flag = mysql_query("DELETE FROM youtube WHERE v = '$vvv'");

            if (!$result_flag) {
                die('DELETEクエリーが失敗しました。'.mysql_error());
            }
        }
        $i = $i + 1;
    }
    
    mysql_close($link);   

    
?>
