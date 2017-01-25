<?php

  session_start();

  $v = $_SESSION["v"];
  if($_POST["onOff"] == "on"){
    setcookie("favorite[$v]", str_replace("@`qp", "&#39;", $_POST["title"]), time() + (365*100) * 86400);
  }else{
    setcookie("favorite[$v]", str_replace("@`qp", "&#39;", $_POST["title"]), time() - 1800);
  }
  
//  if($_SESSION["tab"] == "favorite" && isset($_COOKIE["favorite"])){
//    unset($_SESSION["v"]);
//  }

    if($_SESSION["tab"] == "favorite"){
      if(isset($_COOKIE["favorite"])){
        $arrFavorite == array();
        $arrFavorite = array_reverse($_COOKIE["favorite"]);
        foreach($arrFavorite as $key => $value){
            if(!isset($_SESSION["v"]) || $_SESSION["fromTag"] == true){
//                $_SESSION["v"] = $key;
                unset($_SESSION["fromTag"]);
            }
        
            echo "<div style=\"margin-bottom:2px;vertical-align:top;cursor:pointer;width:120px;height:90px;display:inline-block;overflow:hidden\"><a class=\"black\" href=\"fromthumb.php?v=" . $key . "\"><div style=\"height:66px;display:inline-block;overflow:hidden\"><img style=\"margin-top:-12px\" src=\"thumbnail/".$key.".jpg\" height=\"90\" width=\"120\"></div>\n";
            echo "<div style=\"display:inline-block\">".$value."</div></a></div>\n";
            
        }
        
        if(count($_COOKIE["favorite"]) != 1){
            unset($_SESSION["v"]);
        }
      }else{
        echo '<div style="margin:20px">お気に入りの登録がありません</div>';
      }
    }
    
//  header('Location: '."./fromFavorite2.php");
