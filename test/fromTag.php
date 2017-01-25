<?php

    session_start();
    
    if(isset($_REQUEST["rank"])){
        $_SESSION["rank"] = $_REQUEST["rank"];
    }
    $_SESSION["tabList"][] = $_REQUEST["rank"];
    $_SESSION["fromTag"] = true;
//    $_SESSION["tab"] = key(end($_SESSION["tabList"]));

    foreach($_SESSION["tabList"] as $key => $value){
      $_SESSION["tab"] = "$key";
    }
    
  header('Location: '."./");
