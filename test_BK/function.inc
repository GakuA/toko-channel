<?php
    function getPageTitle($url){
    
        $html = "";
        
        mb_language("Japanese");
        
        $html = file_get_contents($url);
        
        if(mb_detect_encoding($html) != "UTF-8"){
            $html = mb_convert_encoding($html, "UTF-8", "auto");
        }
        
        if(preg_match("/<title>(.*?)<\/title>/i", $html, $matches)){
            return str_replace(" - YouTube", "", $matches[1]);
        } else {
            return false;
        }
    }
?>
