<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<?php
    date_default_timezone_set('Asia/Tokyo');
    $v = $_GET["v"];
    
    if(isset($_COOKIE["$v"])){
?>
        <script type="text/javascript">
            window.alert("同じ動画への評価は1日1回ね！");
            location.href = "./";
        </script>
<?php        
    }else{
        setcookie($v,"a",strtotime(date("d M Y", strtotime("+1 day"))));
    
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
    }
?>
    <script type="text/javascript">
        location.href = "./";
    </script>
