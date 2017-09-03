<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<?php
    include("array.inc");
    session_start();
    date_default_timezone_set('Asia/Tokyo');
    $v = $_POST["v"];

        setcookie($v,"a",strtotime(date("d M Y", strtotime("+1 day"))));

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
        $arrPost = explode(",", $_POST['hyoka']);
        foreach($arrPost as $value){
            $arrSelectHyoka[] = $arrAone[$value];
        }

        foreach($arrSelectHyoka as $value){
            $point = $row[$value] + 1;
            $sql = "UPDATE video SET \"$value\" = $point WHERE v = '$v'";

            $result_flag = pg_query($sql);

            if (!$result_flag) {
                exit('UPDATEクエリーが失敗しました。');
            }
        }

        $time = date("Y-m-d H:i:s");
        $total = $row["total"] + 1;
        $sql = "UPDATE video SET time = '$time', total = $total WHERE v = '$v'";

        $result_flag = pg_query($sql);

        if (!$result_flag) {
            exit('UPDATEクエリーが失敗しました。');
        }

        $result = pg_query("SELECT * FROM video where v = '$v'");
        if(!$result){
            exit('SELECTクエリーが失敗しました。');
        }

        $row = pg_fetch_assoc($result);

    echo "<div style=\"width:110px;display:inline-block;margin-left:10px\">\n";
    echo "<form style=\"position:relative;\" name=\"hyoka\" method=\"post\">\n";

    $i = 0;
    foreach($arrEmotion as $key => $value){
        echo "<label style=\"position:absolute; top:" . 19 * $i . "px;\" for=\"$key\">";
        echo "<input type=\"checkbox\" id=\"$key\" name=\"chk[]\" value=\"".$key."\">".$value;
        echo "</label>";
        echo "<br>\n";
        $i++;
    }
    echo "<span style=\"position:absolute; top:274px\"><input type=\"button\" value=\"評価する\" name=\"go\" style=\"cursor:pointer\" onclick=\"check_hyoka('a')\"><img onmouseover=\"qaHyoka.style.display='block'\" onmouseout=\"qaHyoka.style.display='none'\" src=\"img/hatena.png\" style=\"width:15px;margin-left:5px\"></span><br>\n";
    echo "<div style=\"position:absolute; top:300px\">評価回数：".$row["total"]."</div>\n";
    echo "</form>\n";
    echo "</div>\n";

    echo "<div style=\"vertical-align:top;display:inline-block;\">\n";
    echo "<img style=\"position:relative;z-index:1\" src=\"img/graph.jpg\"></div>\n";
    echo "<div id=\"bar\" style=\"margin-top:1px;vertical-align:top;display:inline-block;text-align:left;margin-left:-143px;position:relative;z-index:2\">";

    $color = "#FF0000";

    foreach($arrEmotion as $key => $value){
        if($key == "d"){
            $color = "#0000FF";
        }
        if($row["total"] == 0){
            $width = 0;
        }else{
            $width = $row[$key] / $row["total"] *138;
        }
        echo "<div style=\"margin:2px 0 4px;width:" . $width . "px;height:15px;background-color:" . $color . "\"></div>\n";
    }

    echo "</div>\n";

        pg_close($link);
