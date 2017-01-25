<?php
    include "function.inc";

    $formUrl = htmlspecialchars($_POST["url"]);
    $formUrl = str_replace('http://', 'https://', $formUrl);
    $formUrl = str_replace('https://m.youtube', 'https://www.youtube', $formUrl);
    $formUrl = str_replace('#t', '&t', $formUrl);

//URLの存在チェック
    if((! @file_get_contents($formUrl) || preg_match("/^https:\/\/www.youtube.com\/watch/", $formUrl) === 0) && $formUrl != ""){
?>

    <script type="text/javascript" language="javascript">
        <!--
        window.alert("YouTubeの動画ページのURLを投稿してね");
        // -->
    </script>
    
<?php
    exit;
    }
    
    if(getPageTitle($formUrl) == "YouTube"){

?>

    <script type="text/javascript" language="javascript">
        <!--
        window.alert("その動画、消されてない？");
        // -->
    </script>
    
<?php
    exit;
    }
    
    if(strpos($formUrl, "&", strpos($formUrl, "v="))){
        $v = substr($formUrl, strpos($formUrl, "v=") + 2, strpos($formUrl, "&", strpos($formUrl, "v=") + 2) - strpos($formUrl, "v=") - 2);
    }else{
        $v = substr($formUrl, strpos($formUrl, "v=") + 2);
    }

//mysql
    $link = mysql_connect('mysql3.000webhost.com', 'a2988517_youtube', 'yamamototamura40');
    if (!$link) {
        die('接続失敗です。'.mysql_error());
    }

    $db_selected = mysql_select_db('a2988517_gaku', $link);
    if (!$db_selected){
        die('データベース選択失敗です。'.mysql_error());
    }

    $result = mysql_query("SELECT * FROM youtube where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }
    
    $row = mysql_fetch_assoc($result);
    if($row['time'] != ""){
?>

<script type="text/javascript">
<!--

	// 「OK」時の処理開始 ＋ 確認ダイアログの表示
	if(window.confirm('もう投稿されてます。\n動画を表示しますか？')){
        parent.video.location="video.php?v=<?php echo $v; ?>"
	}
// -->
</script>

<?php
    exit;
    }elseif($formUrl != ""){
        $title = getPageTitle($formUrl);
        $time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO youtube(v, title, time) VALUES ('$v', '$title', '$time')";
        $result_flag = mysql_query($sql);

        if (!$result_flag) {
            exit('INSERTクエリーが失敗しました。'.mysql_error());
        }
        
        if(isset($_REQUEST["chk"])){
            foreach($_REQUEST["chk"] as $value){
                $sql = "UPDATE youtube SET `$value` = '1', total = '1' WHERE v = '$v'";

                $result_flag = mysql_query($sql);

                if (!$result_flag) {
                    die('UPDATEクエリーが失敗しました。'.mysql_error());
                }
            }
        }
        session_start();
        unset($_SESSION["tab"]);
    }

    echo "<script type=\"text/javascript\">";
    echo "parent.php.location=\"tab_new.php\"";
    echo "</script>";
?>
