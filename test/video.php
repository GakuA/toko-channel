  <script>
    function check_hyoka(){
        var flag = "f";
        var i = 0;
        
        while(i < 15){
            if(document.hyoka.elements[i].checked){
                flag = "t";
            }
            i = parseInt(i) + 1;
        }
        
        if(flag == "f"){
            window.alert("感情を選んでね！");
            return false;
        }
    }
    
    function favorite(title, onOff){
        $.ajax({
            type: "POST",
            url: "fromFavorite.php",
            data: 'title=' + title + '&onOff=' + onOff,
            success: function(thumbnail) {
                if(onOff == "on"){
                    document.getElementById("favoNew").innerHTML ='<img src="img/favo_on.jpg"><span style="vertical-align:top;">お気に入り解除</span>';
                    $("#favoNew").attr({onClick:'favorite(' + "'" + title + "', 'off')"});
                }else{
                    document.getElementById("favoNew").innerHTML ='<img src="img/favo_off.jpg"><span style="vertical-align:top;">お気に入り登録</span>';
                    $("#favoNew").attr({onClick:'favorite(' + "'" + title + "', 'on')"});
                }
                
                if(<?php echo '"'.$_SESSION["tab"].'a"'; ?> == "favoritea"){
                    window.location.href = "/";
                }
            }
        });
    }
  </script>

<div class="video" style="width:1142px;margin:15px auto 0 ;position:relative;">

<div style="float:left;">
  <div>
    <iframe id="video" width="640px" height="480px" src="//www.youtube.com/embed/<?php echo $_SESSION["v"]; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
  </div>
  
  <div style="padding:4px;margin-bottom:10px">

  <?php 
    $v = $_SESSION["v"];
    
    $result = mysql_query("SELECT * FROM youtube where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。'.mysql_error());
    }

    $row = mysql_fetch_assoc($result);

    $_SESSION["total"] = $row["total"];
    
      if(isset($_COOKIE["favorite"]["$v"])){
          echo '<div id="favoNew" style="cursor:pointer;display:inline-block;" onclick="favorite('."'".str_replace("&#39;", "@`qp", $row["title"])."', 'off'".')"><img src="img/favo_on.jpg"><span style="vertical-align:top;">お気に入り解除</span></div>';
      }else{
          echo '<div id="favoNew" style="cursor:pointer;display:inline-block;" onclick="favorite('."'".str_replace("&#39;", "@`qp", $row["title"])."', 'on'".')"><img src="img/favo_off.jpg"><span style="vertical-align:top;">お気に入り登録</span></div>';
      }
  ?>
  </div>
</div>

        <div class='popbox'>
          <a class='open black' href='#'>
            解説する
          </a>

          <div class='collapse'>
            <div id="box" class='box'>
              <div class='arrow'></div>
              <div class='arrow-border'></div>

                  <form style="padding:2px" action="javascript:void(0)" name="commentform"
                  	id="commentform">
                  	<table cellspacing="0" cellpadding="4">
                  		<tr><td colspan="2">
                  				<ol>
                  					<li><b style="color:#f00">※</b>印は必須です。<!--ハンドル名でも結構ですのでご記入ください。--></li>
                  					<li>パスワードを設定しておけばご自分の記事を編集、削除できます。</li>
                  					<li>当サイトにふさわしくないと判断した記事は管理者の独断で削除することがあります。</li>
                  			</td></tr>
                  		<tr><th>お名前 <b style="color:#f00">※</b></th>
                  			<td><input type="text" name="name" style="width:200px;" /></td></tr>
                  		<tr><th>パスワード</th>
                  			<td><input type="password" name="pw" style="width:200px;" /></td></tr>
                  		<tr><td><b>解説</b><b style="color:#f00">※</b></td></tr>
                  		<tr><td colspan="2"><textarea
                  				name="comment" style="resize:none;width:98%;height:120px;"></textarea></td></tr>
                  		<tr><td colspan="2">
                  			<table width="100%">
                  				<tr>
                  					<td><b>見どころTime</b></td>
                  				</tr>
                  				<tr>
                  					<td>
                  						① <input type="text" name="h1" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">：<input type="text" name="m1" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">：<input type="text" name="s1" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">　
                  						② <input type="text" name="h2" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">：<input type="text" name="m2" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">：<input type="text" name="s2" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">　
                  						③ <input type="text" name="h3" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">：<input type="text" name="m3" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">：<input type="text" name="s3" maxlength="2" onKeyup="this.value=this.value.replace(/[^0-9]+/,'')" style="width:15px">
                  					</td>
                  				</tr>
                  				<tr>
                  					<td align="right">
                  						<input type="checkbox" name="rulecheck" id="rulecheck" value="1" /><label
                  						for="rulecheck">上記「解説に関するお約束」に同意します。</label><br />
                  						<input type="reset" value="リセット" class="commandButton" />
                  						<input type="button" value="以上の内容で解説を送信する"
                  						class="commandButton"
                  						onclick="
                  							if (this.form.name.value=='') {
                  								alert('お名前が記入されていません。');
                  								return;
                  							}
                  							if (this.form.comment.value=='') {
                  								alert('コメント本文をご記入ください。');
                  								return;
                  							}
                  							if (this.form.rulecheck.checked==false) {
                  								alert('「解説に関するお約束」にご同意ください。');
                  								return;
                  							}
                  							if (isNaN(this.form.h1.value) || isNaN(this.form.h2.value) || isNaN(this.form.h3.value) || isNaN(this.form.m1.value) || isNaN(this.form.m2.value)|| isNaN(this.form.m3.value) || isNaN(this.form.s1.value) || isNaN(this.form.s2.value) || isNaN(this.form.s3.value)) {
                  								alert('見所Timeは半角数字');
                  								return;
                  							}
                  							
                  							if(confirm('以上の内容で送信しても宜しいですか？\n確認画面は表示されません。\n訂正変更/削除も行えません。このまま送信しても宜しいですか？')) {
                  								send();
                  							}" /></td></tr>
                  			</table></td></tr>
                  	</table>
                  </form>

            </div>
          </div>
        </div>
<div style="width:100%;">
    <div style="width:6px;display:inline-block;">
    </div>
    <div style="border:solid 1px #aaaaaa;overflow-y:auto;padding:4px;display:inline-block;width:480px;height:132px;">



        <div id="commentBox"></div>
        <script type="text/javascript" src="/commentform.js"></script>
    </div>
</div>

<!--cm-->
    <div style="float:right;width:225px;height:250px;text-align:right;background-color:#eeeeee">
        <!-- 投稿tube
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-9355165127032377"
             data-ad-slot="1096300042"
             data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script> -->
    </div>
<!--cm-->

<?php

    echo "<div style=\"display:inline-block;margin-left:10px\">";
    echo "<form style=\"line-height:15px\" action=\"hyoka.php?v=".$v."\" name=\"hyoka\" method=\"post\">\n";
    echo "<input type=hidden name=\"v\" value=".$v.">\n";

    foreach($arrEmotion as $key => $value){
        echo "<label for=\"$key\">";
        echo "<input type=\"checkbox\" id=\"$key\" name=\"chk[]\" value=\"".$key."\">".$value;//."：".$row[$key];
        echo "</label>";
        echo "<br>\n";
    }
    
    echo "<input style=\"margin-top:5px\" type=\"submit\" value=\"評価する\" name=\"go\" onClick=\"return check_hyoka()\"><br>\n";
    echo "<div style=\"margin-top:10px\">総評価回数：".$_SESSION["total"]."</div>\n";
    echo "</form>\n";
    echo "</div>\n";
    
    
    echo "<div style=\"vertical-align:bottom;display:inline-block;margin-bottom:44px\">\n";
    echo "<img style=\"position:relative;z-index:1\" src=\"img/graph.jpg\"></div>\n";
    echo "<div id=\"bar\" style=\"vertical-align:bottom;display:inline-block;text-align:left;margin-bottom:56px;margin-left:-142px;position:relative;z-index:2\">";

    foreach($arrEmotion as $key => $value){

    if($row["total"] == 0){
        $width = 0;
    }else{
        $width = $row[$key] / $row["total"] *138;}
        echo "<img style=\"margin:2px 0\" src=\"img/bar.jpg\" width=\"".$width."px\" height=\"15px\">";
        echo "<br>\n";
    }

    echo "</div>\n";


?>


</div>
