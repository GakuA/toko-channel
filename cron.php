<?php

     include "function.inc";

//mysql
    $link = mysql_connect('mysql1.minibird.netowl.jp', 'tokoch_shuron', 'yamamototamura40');
    if (!$link) {
        die('接続失敗です。'.mysql_error());
    }

    $db_selected = mysql_select_db('tokoch_video', $link);
    if (!$db_selected){
        die('データベース選択失敗です。'.mysql_error());
    }
    
    $result = mysql_query("SELECT v FROM video");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }

    while($row = mysql_fetch_assoc($result)){
        $vvv = $row['v'];
        if(getPageTitle('https://www.youtube.com/watch?v=' . $vvv) == "YouTube"){
            $result_flag = mysql_query("DELETE FROM video WHERE v = '$vvv'");

            if (!$result_flag) {
                die('DELETEクエリーが失敗しました。'.mysql_error());
            }
            
            while(@unlink("comment/yamamototamura_".$vvv."/comment.dat")){
            }
            while(@rmdir("comment/yamamototamura_".$vvv)){
            }
        }
    }
    
    mysql_close($link);
