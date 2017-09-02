<?php
    session_start();

    if($_POST["titleAjax"] == "new"){
        unset($_SESSION["tab"]);
    }elseif(isset($_POST["titleAjax"]) && $_SESSION["fromTag"] != true){
        $_SESSION["tab"] = $_POST["titleAjax"];
    }
    unset($_SESSION["fromTag"]);

    if($_SESSION["tab"] == $_POST["tab"] && isset($_POST["tab"])){
        unset($_SESSION["tab"]);
    }

    //mysql
    $link = pg_connect('host=ec2-23-21-224-199.compute-1.amazonaws.com dbname=d8afnl5oh4vu8b user=mvurgftlbjcxfk password=42e63ae60ed1e92cc3a729d3d92e89c03f69e2b37c76ecb2253e0b8d02064d71');
    if (!$link) {
        die('接続失敗です。');
    }

    if($_SESSION["tab"] == "favorite"){
      if(isset($_COOKIE["favorite"])){
        $arrFavorite == array();
        $arrFavorite = array_reverse($_COOKIE["favorite"]);
        foreach($arrFavorite as $key => $value){
            if(!isset($_SESSION["v"]) || $_SESSION["fromTag"] == true){
                $_SESSION["v"] = $key;
                unset($_SESSION["fromTag"]);
            }

            if($_COOKIE[$key]['Thumb']){
                echo "<div style=\"margin-bottom:2px;vertical-align:top;cursor:pointer;width:120px;height:90px;display:inline-block;overflow:hidden\"><a class=\"black\" href=\"/?id=" . $key . "\"><div style=\"height:66px;display:inline-block;overflow:hidden\"><img style=\"margin-top:-12px\" src=\"".$_COOKIE[$key]."\" height=\"90\" width=\"120\"></div>\n";
            }else{
                echo "<div style=\"margin-bottom:2px;vertical-align:top;cursor:pointer;width:120px;height:90px;display:inline-block;overflow:hidden\"><a class=\"black\" href=\"/?id=" . $key . "\"><div style=\"height:66px;display:inline-block;overflow:hidden\"><img style=\"margin-top:-12px\" src=\"//i.ytimg.com/vi/".$key."/default.jpg\" height=\"90\" width=\"120\"></div>\n";
            }
            echo "<div style=\"display:inline-block\">".$value."</div></a></div>\n";

        }
      }else{
        echo '<div style="margin:20px">お気に入りの登録がありません</div>';
      }
    }else{
        if(isset($_SESSION["tab"])){
            $total = 1;
            foreach($_SESSION["tabList"][$_SESSION["tab"]] as $value){
                $total = $total." * ".$value;
            }

            $total = "pow($total, 1 / ".count($_SESSION["rank"]).")";
var_dump(pow(2,3));
            $result = pg_query("SELECT *, ($total / (total + 1)) AS rank FROM video where $total != 0 order by rank desc, time desc");

            if(!$result){
                exit('SELECTクエリーが失敗しました。');
            }

        }else{

            $result = pg_query("SELECT * FROM video order by time desc");
            if(!$result){
                exit('SELECTクエリーが失敗しました。');
            }
        }

        while($row = pg_fetch_assoc($result)){
            if(!isset($_SESSION["v"]) || $_SESSION["fromTag"] == true){
                $_SESSION["v"] = $row['v'];
                unset($_SESSION["fromTag"]);
            }

            $v = $row['v'];
            $title = $row['title'];
            $site = $row['site'];
            $thumbnail = $row['thumbnail'];

            if($site == "n"){
                echo "<div style=\"margin-bottom:2px;vertical-align:top;cursor:pointer;width:120px;height:90px;display:inline-block;overflow:hidden\"><a class=\"black\" href=\"/?id=" . $v . "\"><div style=\"height:66px;display:inline-block;overflow:hidden\"><img style=\"margin-top:-12px\" src=\"" . $thumbnail . "\" height=\"90\" width=\"120\"></div>\n";
            }else{
                echo "<div style=\"margin-bottom:2px;vertical-align:top;cursor:pointer;width:120px;height:90px;display:inline-block;overflow:hidden\"><a class=\"black\" href=\"/?id=" . $v . "\"><div style=\"height:66px;display:inline-block;overflow:hidden\"><img style=\"margin-top:-12px\" src=\"//i.ytimg.com/vi/".$v."/default.jpg\" height=\"90\" width=\"120\"></div>\n";
            }

            echo "<div style=\"display:inline-block\">".$title."</div></a></div>\n";
        }
    }
