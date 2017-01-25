<?php

  session_start();
  
  if($_SESSION["tab"] == "favorite" && isset($_COOKIE["favorite"])){
    unset($_SESSION["v"]);
  }
//  header('Location: '."./");
