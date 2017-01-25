<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>投稿ch</title>
  
  <link rel="stylesheet" href="/commentform.css" type="text/css">
  <link rel='stylesheet' href='popbox.css' type='text/css' media='screen' charset='utf-8'>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <meta http-equiv="Content-Language" content="ja" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <script src="jquery.js" type="text/javascript"></script>
  <script src="popbox.js" type="text/javascript"></script>
  <script type='text/javascript' charset='utf-8'>
    $(document).ready(function(){
      $('.popbox').popbox();
    });
	function midokoro(mTime){
		$("#video").attr({src:"//www.youtube.com/embed/<?php session_start();echo $_SESSION["v"]; ?>?autoplay=1&rel=0&start=" + mTime});
	}
  </script>
</head>

<body>
<?php
  date_default_timezone_set('Asia/Tokyo');
  include "function.inc";
  include "array.inc";

//mysql
    $link = mysql_connect('mysql3.000webhost.com', 'a2988517_youtube', 'yamamototamura40');
    if (!$link) {
        die('接続失敗です。'.mysql_error());
    }

    $db_selected = mysql_select_db('a2988517_gaku', $link);
    if (!$db_selected){
        die('データベース選択失敗です。'.mysql_error());
    }

?>
<div style="width:1142px;margin:0 auto;">

<!--top-->
<div>
  <a href="/" style="float:left;margin-top:-12px"><img src="img/logo.jpg"></a>
  <div class="top">
  <form action="./post.php" method="post">
      URL：<input class="post" type="text" name="url">
      <input type="submit" value="投稿"><br>
  </form>
  </div>
</div>
<!--top-->

<!--tab-->
<div style="margin-top:10px;overflow-x:auto;white-space:nowrap">
<?php
  include "tab.php";
  echo "\n";
?>
</div>
<!--tab-->

<!--thumbnail-->
<div id="thumbnail" style="border:solid 3px #aaaaaa;padding:3px 0 0 3px;font-size:12px;line-height:12px;max-height:184px;overflow-y:auto">

<?php
  if($_SESSION["tab"] == "select"){
    include "tag.php";
  }else{
    include "thumbnail.php";
  }
?>
</div>
<!--thumbnail-->

<!--video-->
<?php
  include "video.php";
?>
<!--video-->

<?php
    mysql_close($link);
?>

<div style="clear:both;padding:6px 4px;border-top:2px solid #ff0000;width:100%;">
<a class="black" href="how.html">使い方</a>
<span style="margin-left:10px">お問い合わせ</span>
</div>

</body>
</html>
