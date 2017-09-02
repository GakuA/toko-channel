<?php
    function getPageTitle($url){

        $html = "";

        //mb_language("Japanese");

        $html = @file_get_contents($url);
/*
        if(mb_detect_encoding($html) != "UTF-8"){
            $html = mb_convert_encoding($html, "UTF-8", "auto");
        }
*/
        if(preg_match("/<title>(.*?)<\/title>/i", $html, $matches)){
            return $matches[1];
        } else {
            return false;
        }
    }

    function getThumbnail($url){

        $html = "";

        mb_language("Japanese");

        $html = file_get_contents($url);

        if(mb_detect_encoding($html) != "UTF-8"){
            $html = mb_convert_encoding($html, "UTF-8", "auto");
        }

        if(preg_match("/<meta name=\"twitter:image\" content=\"(.*?)\">/i", $html, $matches)){
            return $matches[1];
        } else {
            return false;
        }
    }

    function getNicoTag($url){

        $html = "";

        mb_language("Japanese");

        $html = @file_get_contents($url);

        if(mb_detect_encoding($html) != "UTF-8"){
            $html = mb_convert_encoding($html, "UTF-8", "auto");
        }
var_dump($url);
        if(preg_match("/<meta name=\"keywords\" content=\"(.*?)\">/i", $html, $matches)){
            return $matches[1];
        } else {
            return false;
        }
    }

    function getCount($url, $site){

        $html = "";

        //mb_language("Japanese");

        $html = @file_get_contents($url);
/*
        if(mb_detect_encoding($html) != "UTF-8"){
            $html = mb_convert_encoding($html, "UTF-8", "auto");
        }
*/
        if($site == ""){
            if(preg_match("/<div class=\"watch-view-count\">視聴回数\s(.*?)\s回<\/div>/i", $html, $matches)){
                return $matches[1];
            }elseif(preg_match("/<div class=\"watch-view-count\">(.*?)<\/div>/i", $html, $matches)){
                return $matches[1];
            }else{
                return false;
            }
        }elseif($site == "n"){
            if(preg_match("/<li class=\"score-item\">再生数：<span>(.*?)<\/span><\/li>/i", $html, $matches)){
                return $matches[1];
            }else{
                return false;
            }
        }
    }
?>
