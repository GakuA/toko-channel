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

<div class="video" style="width:700px;margin: 0 auto;">
<?php
}
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
    
    $result = mysql_query("SELECT * FROM youtube where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }

    $row = mysql_fetch_assoc($result);
    
    echo "<div style=\"float:right\">\n";
    echo "<img style=\"text-align:left;position:relative;z-index:1\" src=\"img/graph.jpg\">\n";
    echo "<div style=\"text-align:left;margin-top:-279px;margin-left:3px;position:relative;z-index:2\">";

    foreach($arrEmotion as $key => $value){

    if($row["total"] == 0){
$width = 0;
}else{
    $width = $row[$key] / $row["total"] *138;}
        echo "<img style=\"margin-top:0px\" src=\"img/bar.jpg\" width=\"".$width."px\" height=\"19px\">";
        echo "<br>\n";
    }
    echo "</div>";

    echo "</div>\n";

    echo "<div style=\"float:right;text-align:left;margin-left:10px;margin-right:3px\">";
    echo "<form style=\"line-height:16px\" action=\"sql_hyoka.php?v=".$v."\" name=\"hyoka\" method=\"post\" target=\"php\">\n";
    echo "<input type=hidden name=\"v\" value=".$v.">\n";

    foreach($arrEmotion as $key => $value){
        echo "<label for=\"$key\">";
        echo "<input type=\"checkbox\" id=\"$key\" name=\"chk[]\" value=\"".$key."\">".$value;//."：".$row[$key];
        echo "</label>";
        echo "<br>\n";
    }
    
    echo "<input style=\"margin-top:5px\" type=\"submit\" value=\"評価する\" name=\"go\" onClick=\"return check()\"><br>\n";
    echo "総評価回数：".$row["total"]."\n";
    echo "</form>\n";
    echo "</div>\n";

    echo "<div style=margin-top:20px>\n<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/".$v."?rel=0\" frameborder=\"0\" allowfullscreen></iframe><br>\n";
?>

</div>
</div>

</body>
</html>
