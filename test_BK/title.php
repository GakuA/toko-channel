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
    
    if(! isset($_SESSION["rank"])){
        $_SESSION["rank"] = array("a");
    }
        
    if($_SESSION["tab"] == "rank"){
        echo "<div style=\"position:relative;\">\n";
        echo "<img src=\"img/tab_rank.jpg\" usemap=\"#tab\">\n";
        echo "<map name=\"tab\">\n";
        echo "<area shape=\"poly\" coords=\"17,3,11,33,98,33,99,20,94,3\" href=\"tab_new.php\" target=\"php\" alt=\"新着動画\">\n";
//        echo "<area shape=\"poly\" coords=\"105,3,97,33,189,33,182,3\" href=\"tab_rank.php\" target=\"php\" alt=\"ランキング\">\n";
        echo "<area shape=\"poly\" coords=\"191,3,187,22,189,33,318,33,319,3\" href=\"sql_rank.php\" target=\"php\" alt=\"感情別\">\n";
        echo "</map>\n";
        
        include "array.inc";
        
        echo "<sapn style=\"position:absolute;left:205px;top:13px;font-size:14px;font-family:ＭＳ Ｐゴシック;font-weight: bold\">";
//        if(isset($_SESSION["rank"])){
        echo '<a href="sql_rank.php" target="php" style="text-decoration:none;color:#000000">';
            foreach($_SESSION["rank"] as $value){
                echo $arrEmotion[$value];
            }
//        }
        echo "</a>\n";
        echo "</span>\n";
        echo "</div>";

    }elseif($_SESSION["tab"] == "ranking"){
        echo "<div style=\"position:relative;\">\n";
        echo "<img src=\"img/tab_ranking.jpg\" usemap=\"#tab\">\n";
        echo "<map name=\"tab\">\n";
        echo "<area shape=\"poly\" coords=\"17,3,11,33,98,33,99,20,94,3\" href=\"tab_new.php\" target=\"php\" alt=\"新着動画\">\n";
        echo "<area shape=\"poly\" coords=\"105,3,97,33,189,33,182,3\" href=\"tab_rank.php\" target=\"php\" alt=\"ランキング\">\n";
        echo "</map>\n";
        
        include "array.inc";
        
        echo "<sapn style=\"position:absolute;left:205px;top:13px;font-size:14px;font-family:ＭＳ Ｐゴシック;font-weight: bold\">";
//        if(isset($_SESSION["rank"])){
            foreach($_SESSION["rank"] as $value){
                echo $arrEmotion[$value];
            }
//        }
        echo "</span>\n";
        echo "</div>";
        
    }else{
        echo "<div style=\"position:relative;\">\n";
        echo "<img src=\"img/tab_new.jpg\" usemap=\"#tab\">";
        echo "<map name=\"tab\">\n";
        echo "<area shape=\"poly\" coords=\"104,3,100,19,103,33,189,33,181,3\" href=\"tab_rank.php\" target=\"php\" alt=\"感情選択\">\n";
        echo "<area shape=\"poly\" coords=\"191,3,187,22,189,33,318,33,319,3\" href=\"sql_rank.php\" target=\"php\" alt=\"感情別\">\n";
        echo "</map>\n";

        include "array.inc";
        
        echo "<sapn style=\"position:absolute;left:205px;top:13px;font-size:14px;font-family:ＭＳ Ｐゴシック;font-weight: bold\">";
        echo '<a href="sql_rank.php" target="php" style="text-decoration:none;color:#000000">';
//        if(isset($_SESSION["rank"])){
            foreach($_SESSION["rank"] as $value){
                echo $arrEmotion[$value];
            }
//        }
        echo "</a>\n";
        echo "</span>\n";
        echo "</div>";
    }
    
?>

</body>
</html>
