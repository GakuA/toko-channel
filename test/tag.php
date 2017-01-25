<script type="text/javascript" language="javascript">
    <!--
    function check_tag(){
        var flag = "f";
        var i = 0;
        
        while(i < 14){
            if(document.tag.elements[i].checked){
                flag = "t";
            }
            i = parseInt(i) + 1;
        }
        
        if(flag == "f"){
            window.alert("感情を選んでね！");
            return false;
        }
    }
    
    function emo(){
        var i = 0;
        var emotion = "";
        
        while(i < 14){
            if(document.tag.elements[i].checked){
                emotion += document.tag.elements[i].id;
            }
            i = parseInt(i) + 1;
        }
        
        document.getElementById("str").textContent = emotion;
    }

    // -->
</script>

<?php
    include_once "array.inc";
?>
<form action="./fromTag.php" name="tag" method="post" style="font-size:15px;margin:5px">
    チェックしてGO！　※複数選択できるよ！<br>

<?php
    foreach($arrEmotion as $key => $value){
        echo "<label for=\"$value\">";
        echo "<input type=\"checkbox\" id=\"$value\" name=\"rank[]\" value=\"".$key."\" value2=\"".$value."\" onClick=\"emo()\">".$value;
        echo "</label>";
        if($key == "c"){
            echo "<br>\n";
        }else{
            echo "\n";
        }
    }
    
?>

<br>
<div id="str" style="margin-top:10px;float:left;"></div>
<div style="margin-top:3px;">
<input type="submit" value="GO!" onClick="return check_tag()"><br>
</div>
<!--</div>-->

</form>
