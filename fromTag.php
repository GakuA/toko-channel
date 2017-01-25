<?php
    session_start();
    include("array.inc");
    $arrSelectEmo = array();
    $arrPost = explode(",", $_POST['emo']);

    foreach($arrPost as $value){
        $arrSelectEmo[] = $arrAone[$value];
    }

    if(isset($arrSelectEmo)){
        $_SESSION["rank"] = $arrSelectEmo;
    }
    $_SESSION["tabList"][] = $arrSelectEmo;
    $_SESSION["fromTag"] = true;
//    $_SESSION["tab"] = key(end($_SESSION["tabList"]));

    foreach($_SESSION["tabList"] as $key => $value){
      $_SESSION["tab"] = "$key";
    }

    echo($key);
