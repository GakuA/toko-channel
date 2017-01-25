<?php

    $link = mysql_connect('mysql3.000webhost.com', 'a2988517_youtube', 'yamamototamura40');
    if (!$link) {
        die('接続失敗です。'.mysql_error());
    }

    $db_selected = mysql_select_db('a2988517_gaku', $link);
    if (!$db_selected){
        die('データベース選択失敗です。'.mysql_error());
    }
    
    $result = mysql_query("SELECT * FROM youtube");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }
