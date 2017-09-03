<?php
    session_start();
    include("array.inc");

    if($_POST["titleAjax"] == "new"){
        unset($_SESSION["tab"]);
    }elseif(isset($_POST["titleAjax"]) && $_SESSION["fromTag"] != true){
        $_SESSION["tab"] = $_POST["titleAjax"];
    }
    unset($_SESSION["fromTag"]);

//新着動画
    if(!isset($_SESSION["tab"])){
        echo '<div style="cursor:default;background-color:#eeeeee';
    }else{
        echo "<div onclick=\"tabClick('new')\" style=\"cursor:pointer;background-color:#aaaaaa";
    }
    echo ';border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset;margin-right:4px;display:inline-block;font-weight:bold;width:63px;height:20px;">トレンド</div>';

//お気に入り
    if($_SESSION["tab"] == "favorite"){
        echo '<div style="cursor:default;background-color:#eeeeee';
    }else{
        echo "<div onclick=\"tabClick('favorite')\" style=\"cursor:pointer;background-color:#aaaaaa";
    }
    echo ';border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset;margin-right:4px;display:inline-block;font-weight:bold;width:79px;height:20px;">お気に入り</div>';

//感情検索
    if($_SESSION["tab"] == "select"){
        echo '<div style="cursor:default;background-color:#eeeeee';
    }else{
        echo "<div onclick=\"tabClick('select')\" style=\"cursor:pointer;background-color:#aaaaaa";
    }
    echo ';border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset;margin-right:4px;display:inline-block;font-weight:bold;width:72px;height:20px;">評価検索<img onmouseover="qaKanjoTab.style.display=\'block\'" onmouseout="qaKanjoTab.style.display=\'none\'" src="img/hatena.png" style="width:15px;margin-left:5px"></div>';

//感情タブ
    if(isset($_SESSION["tabList"])){

      foreach($_SESSION["tabList"] as $key => $value){
        $width = 0;

        foreach($_SESSION["tabList"][$key] as $value2){
          $width += $arrEmoWidth[$value2];
        }

        $width = $width + 10;

        if($_SESSION["tab"] === "$key"){
            echo '<div style="cursor:default;background-color:#eeeeee';
        }else{
            echo "<div onclick=\"tabClick('$key')\" style=\"cursor:pointer;background-color:#aaaaaa";
        }

        echo ";width:".$width."px;height:20px".';border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset;margin-right:4px;display:inline-block;font-weight:bold;height:20px;">';

        $word = "";
        foreach($_SESSION["tabList"][$key] as $value2){
          $word = $word.$arrEmotion[$value2];
        }

        echo "$word</div>";

        echo '<img onclick="closeTab(\'' . $key . '\', \'' . $_SESSION["tab"] . '\')" style="vertical-align:top;margin:8px 11px 0 -26px;" src="img/close.png" onmouseover="this.src=\'img/close_on.png\';" onmouseout="this.src=\'img/close.png\';">';
      }
    }
?>
    <div id="qaKanjoTab" style="display: none; position: absolute; top: 32px; left: 315px; padding: 10px; width: 7em; border: 1px solid rgb(187, 187, 187); border-radius: 8px; box-shadow: rgba(0, 0, 0, 0.298039) 0px 0px 14px 1px; z-index: 3; background-color: rgb(255, 255, 255);">みんなの評価で<br>検索できるよ！</div>
