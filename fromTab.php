<?php

  session_start();

  if(isset($_GET["tab"])){
    $_SESSION["tab"] = $_GET["tab"];
  }else{
    unset($_SESSION["tab"]);
  }
  
  if($_GET["tab"] != "select"){
    if($_GET["tab"] != "favorite" || isset($_COOKIE["favorite"])){
//      unset($_SESSION["v"]);
    }
  }

  header('Location: '."./");
