<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="robots" content="noarchive" />
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" href="css/index.css">
<title>投稿!Tube!</title>
</head>
<body>

<?php
    session_start();
    
    if($_SESSION["tab"] == "rank"){
        echo "<script type=\"text/javascript\">";
        echo "parent.php.location=\"tab_rank.php\"";
        echo "</script>";
    }
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

    if($_SESSION["tab"] == "ranking"){
        $total = 1;
        foreach($_SESSION["rank"] as $value){
            //if($value == 0){
                //$total = $total." * (".$value." + 0.01)";
            //}else{
                $total = $total." * ".$value;
            //}
        }
        
        $total = "pow($total, 1/".count($_SESSION["rank"]).")";
//        echo $total;
        
        $result = mysql_query("SELECT *, $total/total as rank FROM youtube where $total != 0 order by rank desc,time desc limit 100");
        if(!$result){
            exit('SELECTクエリーが失敗しました。'.mysql_error());
        }
        
    }else{
        
        $result = mysql_query("SELECT * FROM youtube order by time desc limit 100");
        if(!$result){
            exit('SELECTクエリーが失敗しました。'.mysql_error());
        }
    }

    $i = 1;
    while($row = mysql_fetch_assoc($result)){
        if($i == 1){
            $v = $row['v'];
        }
        $url = "video.php?v=".$row['v'];
        $title = $row['title'];

        
        echo"◆<a href=\"".$url."\" target=\"video\">".$title."</a>\n";
        $i = $i + 1;
    }
    
    mysql_close($link);
?>

<script type="text/javascript">
    parent.video.location="video.php?v=<?php echo $v; ?>"
</script>

</body>
</html>
