<?php
    if($_SESSION["tab"] == "favorite"){
      if(isset($_COOKIE["favorite"])){
        $arrFavorite == array();
        $arrFavorite = array_reverse($_COOKIE["favorite"]);
        foreach($arrFavorite as $key => $value){
            if(!isset($_SESSION["v"]) || $_SESSION["fromTag"] == true){
                $_SESSION["v"] = $key;
                unset($_SESSION["fromTag"]);
            }
        
            echo "<div style=\"margin-bottom:2px;vertical-align:top;cursor:pointer;width:120px;height:90px;display:inline-block;overflow:hidden\"><a class=\"black\" href=\"fromthumb.php?v=" . $key . "\"><div style=\"height:66px;display:inline-block;overflow:hidden\"><img style=\"margin-top:-12px\" src=\"//i.ytimg.com/vi/".$key."/default.jpg\" height=\"90\" width=\"120\"></div>\n";
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
            
            $total = "pow($total, 1/".count($_SESSION["rank"]).")";
            
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

        while($row = mysql_fetch_assoc($result)){
            if(!isset($_SESSION["v"]) || $_SESSION["fromTag"] == true){
                $_SESSION["v"] = $row['v'];
                unset($_SESSION["fromTag"]);
            }
            
            $v = $row['v'];
            $title = $row['title'];

            echo "<div style=\"margin-bottom:2px;vertical-align:top;cursor:pointer;width:120px;height:90px;display:inline-block;overflow:hidden\"><a class=\"black\" href=\"fromthumb.php?v=" . $v . "\"><div style=\"height:66px;display:inline-block;overflow:hidden\"><img style=\"margin-top:-12px\" src=\"//i.ytimg.com/vi/".$v."/default.jpg\" height=\"90\" width=\"120\"></div>\n";
            echo "<div style=\"display:inline-block\">".$title."</div></a></div>\n";
        }
    }
