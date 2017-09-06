<?php
    session_start();
    include_once "array.inc";
?>
<form name="tag" style="font-size:15px;margin:30px;line-height:2em">
    チェックして検索！　※複数選択できるよ！<br>

<?php
    foreach($arrEmotion as $key => $value){
        echo "<label for=\"$value\">";
        echo "<input type=\"checkbox\" id=\"$value\" name=\"rank[]\" value=\"".$key."\" value2=\"".$value."\" onClick=\"emo()\">".$value;
        echo "</label>";
        if($key == "g"){
            echo "<br>\n";
        }else{
            echo "\n";
        }
    }
?>

<br>
<div style="margin-top:3px;float:left;">
<input type="button" value="検索" style="cursor:pointer" onClick="selectEmo()"><br>
</div>
<div id="str" style="margin-top:4px;margin-left:45px"></div>
<!--</div>-->

</form>
