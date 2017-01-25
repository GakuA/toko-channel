<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="robots" content="noarchive" />
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" href="css/index.css">
<title>投稿!Tube!</title>

<script type="text/javascript" language="javascript">
    <!--
    function check(){
        var flag = "f";
        var i = 0;
        
        while(i < 15){
            if(document.hyoka.elements[i].checked){
                flag = "t";
            }
            i = parseInt(i) + 1;
        }
        
        if(flag == "f"){
            window.alert("チェックしてね！");
            return false;
        }
    }
    // -->
</script>

</head>
<body>

<div class="video">
<?php

    include "array.inc";
    
//mysql
    $link = mysql_connect('mysql3.000webhost.com', 'a2988517_youtube', 'yamamototamura40');
    if (!$link) {
        exit('接続失敗です。'.mysql_error());
    }

    $db_selected = mysql_select_db('a2988517_gaku', $link);
    if (!$db_selected){
        exit('データベース選択失敗です。'.mysql_error());
    }
    
    $v = $_GET["v"];
    
    echo "<div style=margin:20px>\n<iframe style=\"float:left\" width=\"560\" height=\"315\" src=\"//www.youtube.com/embed/".$v."\" frameborder=\"0\" allowfullscreen></iframe><br>\n";
    echo "<div style=\"float:left\">\n";

    echo "<form style=\"text-align:left;margin-left:10px\" action=\"sql_hyoka.php?v=".$v."\" name=\"hyoka\" method=\"post\" target=\"php\">\n";
    echo "<input type=hidden name=\"v\" value=".$v.">\n";

    $result = mysql_query("SELECT * FROM youtube where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }
    
    $row = mysql_fetch_assoc($result);
    
    foreach($arrEmotion as $key => $value){
        echo "<label for=\"$key\">";
        echo "<input type=\"checkbox\" id=\"$key\" name=\"chk[]\" value=\"".$key."\">".$value."：".$row[$key];
        echo "</label>";
        echo "<br>";
    }
    
?>
    <input type="submit" value="評価する" name="go" onClick="return check()"><br>

</form>
</div>
<img style="margin-top:-15px" src="img/graph.jpg">
</div>
<!--
    echo "<form action=\"sql_hyoka.php?v=".$v."\" name=\"hyoka\" method=\"post\" target=\"php\">\n";
    echo "<input type=hidden name=\"v\" value=".$v.">\n";

    $result = mysql_query("SELECT * FROM youtube where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }
    
    $row = mysql_fetch_assoc($result);
    
    foreach($arrEmotion as $key => $value){
        echo "<label for=\"$key\">";
        echo "<input type=\"checkbox\" id=\"$key\" name=\"chk[]\" value=\"".$key."\">".$value."：".$row[$key];
        echo "</label>";
        if($key == "g"){
            echo "<br>\n";
        }else{
            echo "\n";
        }
    }
    
?>
    <input type="submit" value="評価する" name="go" onClick="return check()"><br>

</form>
-->
</div>

</body>
</html>
