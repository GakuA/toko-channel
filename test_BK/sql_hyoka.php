<?php

    $v = $_GET["v"];
    
    //mysql
    $link = mysql_connect('mysql3.000webhost.com', 'a2988517_youtube', 'yamamototamura40');
    if (!$link) {
        exit('接続失敗です。'.mysql_error());
    }

    $db_selected = mysql_select_db('a2988517_gaku', $link);
    if (!$db_selected){
        exit('データベース選択失敗です。'.mysql_error());
    }
    
    $result = mysql_query("SELECT * FROM youtube where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }
    
    $row = mysql_fetch_assoc($result);
    
    foreach($_REQUEST["chk"] as $value){
        $point = $row[$value] + 1;
        $sql = "UPDATE youtube SET `$value` = '$point' WHERE v = '$v'";

        $result_flag = mysql_query($sql);

        if (!$result_flag) {
            exit('UPDATEクエリーが失敗しました。'.mysql_error());
        }
    }
    
    $time = date("Y-m-d H:i:s");
    $total = $row["total"] + 1;
    $sql = "UPDATE youtube SET time = '$time', total = $total WHERE v = '$v'";

    $result_flag = mysql_query($sql);

    if (!$result_flag) {
        exit('UPDATEクエリーが失敗しました。'.mysql_error());
    }
    
    mysql_close($link);
    
    session_start();
    if($_SESSION["tab"] == "rank"){
?>

<script>
    parent.video.location="video.php?v=<?php echo $v ?>";
</script>

<?php
    }else{
?>

<script>
    parent.rank.location="rank.php";
</script>

<?php
    }
?>
