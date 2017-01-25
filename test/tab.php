<?php if(isset($_SESSION["tab"])){echo '<a class="black" href="fromTab.php">';} ?><div style="margin-right:4px;display:inline-block;font-weight:bold;width:63px;height:20px;<?php if(!isset($_SESSION["tab"])){echo "cursor:default;background-color:#eeeeee";}else{echo "cursor:pointer;background-color:#aaaaaa";} ?>;border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset">新着動画</div><?php if(isset($_SESSION["tab"])){echo '</a>';} ?>
<?php if($_SESSION["tab"] != "favorite"){echo '<a class="black" href="fromTab.php?tab=favorite">';} ?><div style="margin-right:4px;display:inline-block;font-weight:bold;width:78px;height:20px;<?php if($_SESSION["tab"] == "favorite"){echo "cursor:default;background-color:#eeeeee";}else{echo "cursor:pointer;background-color:#aaaaaa";} ?>;border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset">お気に入り</div><?php if($_SESSION["tab"] != "favorite"){echo '</a>';} ?>
<?php if($_SESSION["tab"] != "select"){echo '<a class="black" href="fromTab.php?tab=select">';} ?><div style="margin-right:4px;display:inline-block;font-weight:bold;width:63px;height:20px;<?php if($_SESSION["tab"] == "select"){echo "cursor:default;background-color:#eeeeee";}else{echo "cursor:pointer;background-color:#aaaaaa";} ?>;border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset">感情検索</div><?php if($_SESSION["tab"] != "select"){echo '</a>';} ?>
<?php
if(isset($_SESSION["tabList"])){
  foreach($_SESSION["tabList"] as $key => $value){
    
//    echo '<div style="display:inline-block">';
    
    if($_SESSION["tab"] !== "$key"){
      echo '<a class="black" href="fromTab.php?tab='.$key.'">';
    }
    
    echo '<div style="margin-right:4px;display:inline-block;font-weight:bold;width:';
    
    $width = 0;
    foreach($_SESSION["tabList"][$key] as $value2){
      $width += $arrEmoWidth[$value2];
    }
    
    $width = $width + 10;
    echo $width."px;height:20px;";
    
    if($_SESSION["tab"] === "$key"){
      echo "cursor:default;background-color:#eeeeee";
    }else{
      echo "cursor:pointer;background-color:#aaaaaa";
    }
    
    echo ';border-radius:10px 10px 0 0;padding:5px 15px;box-shadow: -1px 0 5px rgba(0,0,0,0.4)inset">';

    $word = "";
    foreach($_SESSION["tabList"][$key] as $value2){
      $word = $word.$arrEmotion[$value2];
    }
    
    echo "$word</div>";
    
    if($_SESSION["tab"] !== "$key"){
      echo '</a>';
    }
    echo '<a href="close.php?tab='.$key.'"><img style="vertical-align:top;margin:8px 11px 0 -26px;" src="img/close.png" onmouseover="this.src=\'img/close_on.png\';" onmouseout="this.src=\'img/close.png\';"></a>';
  }
}
?>
