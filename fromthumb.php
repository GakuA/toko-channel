<?php

  session_start();

    $_SESSION["v"] = $_GET["v"];
    
    header('Location: '."./");
