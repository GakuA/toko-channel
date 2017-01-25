<?php

  session_start();

    unset($_SESSION["tabList"][$_GET["tab"]]);

    if($_SESSION["tab"] == $_GET["tab"]){
      unset($_SESSION["tab"]);
      unset($_SESSION["v"]);
    }

  header('Location: '."./");
