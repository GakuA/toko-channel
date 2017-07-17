<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<?php

  session_start();
  date_default_timezone_set('Asia/Tokyo');
  include "function.inc";

    //ニコ動トップのタイトル
    $niconico = getPageTitle('http://www.nicovideo.jp/video_top');

    $formUrl = htmlspecialchars($_POST["url"]);
    $formUrl = str_replace('https://m.youtube', 'https://www.youtube', $formUrl);
    $formUrl = str_replace('https://youtu.be/', 'https://www.youtube.com/watch?v=', $formUrl);
    $formUrl = str_replace('#t', '&t', $formUrl);
    $formUrl = str_replace('http://sp.nicovideo.jp/', 'http://www.nicovideo.jp/', $formUrl);

//URLの存在チェック
    if((! @file_get_contents($formUrl) || (preg_match("/^https:\/\/www.youtube.com\/watch/", $formUrl) === 0 && preg_match("/^http:\/\/www.nicovideo.jp\/watch/", $formUrl) === 0))){
?>

    <script type="text/javascript" language="javascript">
        <!--
        window.alert("YouTubeかニコニコ動画の動画ページURLを投稿してね");
        location.href = "./";
        // -->
    </script>

<?php
    exit;
    }

    if(getPageTitle($formUrl) == "YouTube" || getPageTitle($formUrl) == $niconico){

?>

    <script type="text/javascript" language="javascript">
        <!--
        window.alert("動画が存在しません");
        location.href = "./";
        // -->
    </script>

<?php
    exit;
    }

    $site = "";
    $thumbnail = "";
    //ニコ動
    if(preg_match("/^https:\/\/www.youtube.com\/watch/", $formUrl) === 0){
        //R-18の場合
        if(stristr(getNicoTag($formUrl), "R-18")){
?>
            <script type="text/javascript">
            <!--
                    alert('ごめん！R-18は無しで！');
                    location.href = "./";

            // -->
            </script>
<?php
        exit;
        }
        $site = "n";
        $thumbnail = getThumbnail($formUrl);

        if(strpos($formUrl, "/", strpos($formUrl, "watch") +6)){
            $v = substr($formUrl, strpos($formUrl, "watch") + 6, strpos($formUrl, "/", strpos($formUrl, "watch") + 6) - strpos($formUrl, "watch") - 6);
        }elseif(strpos($formUrl, '?', strpos($formUrl, "watch"))){
            $v = substr($formUrl, strpos($formUrl, "watch") + 6, strpos($formUrl, '?', strpos($formUrl, "watch") + 6) - strpos($formUrl, "watch") - 6);
        }else{
            $v = substr($formUrl, strpos($formUrl, "watch") + 6);
        }
    //YouTube
    }else{
        if(strpos($formUrl, "&", strpos($formUrl, "v="))){
            $v = substr($formUrl, strpos($formUrl, "v=") + 2, strpos($formUrl, "&", strpos($formUrl, "v=") + 2) - strpos($formUrl, "v=") - 2);
        }else{
            $v = substr($formUrl, strpos($formUrl, "v=") + 2);
        }
    }

//mysql
    $link = pg_connect('host=ec2-23-21-224-199.compute-1.amazonaws.com dbname=d8afnl5oh4vu8b user=mvurgftlbjcxfk password=42e63ae60ed1e92cc3a729d3d92e89c03f69e2b37c76ecb2253e0b8d02064d71');
    if (!$link) {
        die('接続失敗です。');
    }

    $result = pg_query("SELECT * FROM video where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。');
    }

    $row = pg_fetch_assoc($result);
    if($row['time'] != ""){
        $_SESSION["v"] = $v;
        $_SESSION["total"] = $row['total'];
?>

<script type="text/javascript">
<!--
        // 「OK」時の処理開始 ＋ 確認ダイアログの表示
        alert('投稿済みの動画です！');
            location.href = './?id=<?php echo $v; ?>';

// -->
</script>

<?php
    }elseif($formUrl != ""){
        //while(!copy("https://i.ytimg.com/vi/".$v."/default.jpg", "thumbnail/".$v.".jpg")){
        //}

        if($site == "n"){
            $target = "/ ‐ " . $niconico . "$/";
            $title = preg_replace($target, "", getPageTitle($formUrl));
        }else{
            $title = preg_replace("/ - YouTube$/", "", getPageTitle($formUrl));
        }
        $time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO video(v, title, time, site, thumbnail) VALUES ('$v', '$title', '$time', '$site', '$thumbnail')";
        $result_flag = pg_query($sql);

        if (!$result_flag) {
            exit('INSERTクエリーが失敗しました。');
        }

        if(isset($_REQUEST["chk"])){
            foreach($_REQUEST["chk"] as $value){
                $sql = "UPDATE video SET `$value` = '1', total = '1' WHERE v = '$v'";

                $result_flag = pg_query($sql);

                if (!$result_flag) {
                    die('UPDATEクエリーが失敗しました。');
                }
            }
        }
        $_SESSION["v"] = $v;
        unset($_SESSION["tab"]);
    }

?>

<script type="text/javascript">
    location.href = "./";
</script>
