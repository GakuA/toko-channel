<?php
//コメントバックアップ
    $today = date("Ymd");
    $lastWeek = date("Ymd", strtotime("-7 day"));

    system("cp -r comment comment_BK/$today");
    @system("rm -r comment_BK/$lastWeek");

//dbバックアップ
    system('sh dbBK.sh');
