<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="robots" content="noarchive" />
<meta name="robots" content="noindex,nofollow" />
<link rel="stylesheet" type="text/css" href="css/index.css">
<title>投稿!Tube!</title>

<script type="text/javascript" language="javascript">
    <!--
    function check(){
        var flag = "f";
        var i = 0;
        
        while(i < 14){
            if(document.tag.elements[i].checked){
                flag = "t";
            }
            i = parseInt(i) + 1;
        }
        
        if(flag == "f"){
            window.alert("チェックしてね！");
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

</head>
<body>

<?php
    include_once "array.inc";
?>
チェックしてGO！　※複数選択できるよ！<br>
<form action="sql_rank.php" name="tag" method="post" target="php">
    
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
<!--<div style="text-align:right;margin-right:50px">-->
<div id="str" style="margin-top:6px;float:left;"></div>
<div style="margin-top:3px;">
<input type="submit" value="GO!" onClick="return check()"><br>
</div>
<!--</div>-->

</form>

</body>
</html>
