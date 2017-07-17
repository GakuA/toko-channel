<?php

    include "function.inc";

//mysql
    $link = pg_connect('host=ec2-23-21-224-199.compute-1.amazonaws.com dbname=d8afnl5oh4vu8b user=mvurgftlbjcxfk password=42e63ae60ed1e92cc3a729d3d92e89c03f69e2b37c76ecb2253e0b8d02064d71');
    if (!$link) {
        die('接続失敗です。');
    }

    $result = pg_query("SELECT v FROM video limit 50 offset 100");
    if(!$result){
        exit('SELECTクエリーが失敗しました。');
    }

    while($row = pg_fetch_assoc($result)){
        $vvv = $row['v'];
        if(getPageTitle('https://www.youtube.com/watch?v=' . $vvv) == "YouTube"){
            $result_flag = pg_query("DELETE FROM video WHERE v = '$vvv'");

            if (!$result_flag) {
                die('DELETEクエリーが失敗しました。');
            }

            while(@unlink("comment/yamamototamura_".$vvv."/comment.dat")){
            }
            while(@rmdir("comment/yamamototamura_".$vvv)){
            }
        }
    }

    pg_close($link);
