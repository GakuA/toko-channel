  <script>
    function check_hyoka(cookie){
        var flag = "f";
        var i = 0;
        var arrHyoka = [];

        while(i < 14){
            if(document.hyoka.elements[i].checked){
                flag = "t";
                arrHyoka.push(i);
            }
            i = parseInt(i) + 1;
        }

        if(flag == "f"){
            window.alert("感情を選んでね！");
        }else
        if(cookie != ""){
            alert("同じ動画への評価は1日1回ね！");
        }else{
            $.ajax({
                type: "POST",
                url: "hyoka.php",
                data: "hyoka=" + arrHyoka + "&v=" + "<?php echo $_SESSION["v"]; ?>",
                success: function(hyokaAjax) {
                    $("#hyoka").html(hyokaAjax);
                }
            });
        }
    }

    function favorite(title, onOff, nicoThumb){
        $.ajax({
            type: "POST",
            url: "fromFavorite.php",
            data: 'title=' + title + '&onOff=' + onOff + '&thumb=' + nicoThumb,
            success: function() {
                if(onOff == "on"){
                    $("#favoNew").html('<img src="img/favo_on.jpg"><span style="vertical-align:top;">お気に入り解除</span>');
                    $("#favoNew").attr({onClick:'favorite(' + "'" + title + "', 'off' , '" + nicoThumb + "')"});
                }else{
                    $("#favoNew").html('<img src="img/favo_off.jpg"><span style="vertical-align:top;">お気に入り登録</span>');
                    $("#favoNew").attr({onClick:'favorite(' + "'" + title + "', 'on' , '" + nicoThumb + "')"});
                }
            }
        });
        $.ajax({
            url: "nowTab.php",
            success: function(nowTab) {
                if(nowTab == 'favorite'){
                    tabClick('favorite');
                }
            }
        });
    }
  </script>

<div class="video" style="width:1142px;margin:15px auto 0 ;position:relative;">

<div style="float:left;">
  <?php
    $v = $_SESSION["v"];

    $result = pg_query("SELECT * FROM video where v = '$v'");
    if(!$result){
        exit('SELECTクエリーが失敗しました。');
    }

    $row = pg_fetch_assoc($result);

    echo '<div>';
    if($row["site"] == "n"){
        echo '<script type="application/javascript" src="http://embed.nicovideo.jp/watch/' . $_SESSION["v"] . '/script?w=640&h=480"></script><noscript><a href="http://www.nicovideo.jp/watch/' . $_SESSION["v"] . '">' . $row["title"] . '</a></noscript>';
    }else{
        echo '<iframe id="video" width="640px" height="480px" src="//www.youtube.com/embed/' . $_SESSION["v"] . '?rel=0" frameborder="0" allowfullscreen></iframe>';
    }
    echo '</div>';

    echo '<div style="/*float:right;*/padding:4px;margin-right:10px;/*margin-bottom:10px*/">';

    $_SESSION["total"] = $row["total"];
    $nicoThumb = $row["thumbnail"];

      if(isset($_COOKIE["favorite"]["$v"])){
          echo '<div id="favoNew" style="cursor:pointer;display:inline-block;" onclick="favorite('."'".str_replace("&#39;", "@`qp", $row["title"])."', 'off', '$nicoThumb'".')"><img src="img/favo_on.jpg"><span style="vertical-align:top;">お気に入り解除</span></div>';
      }else{
          echo '<div id="favoNew" style="cursor:pointer;display:inline-block;" onclick="favorite('."'".str_replace("&#39;", "@`qp", $row["title"])."', 'on', '$nicoThumb'".')"><img src="img/favo_off.jpg"><span style="vertical-align:top;">お気に入り登録</span></div>';
      }
  ?>
  </div>
  <div style="padding:4px">
      <?php
          if($row["site"] == ""){
              $url = 'https://www.youtube.com/watch?v=' . $_SESSION["v"];
          }elseif($row["site"] == "n"){
              $url = 'http://www.nicovideo.jp/watch/' . $_SESSION["v"];
          }

          //echo "再生回数：" . getCount($url, $row["site"]);
      ?>
  </div>
</div>

<!--
        <div class='popbox'>
          <a class='open black' href='#'>
            <input type="button" value="コメントする" style="cursor:pointer;">
          </a>

          <div class='collapse'>
            <div id="box" class='box'>
              <div class='arrow'></div>
              <div class='arrow-border'></div>

                  <form style="padding:2px" action="javascript:void(0)" name="commentform"
                  	id="commentform">
                  	<table cellspacing="0" cellpadding="4">
                  		<tr style="display:none"><td><input type="button" value="このコメントを削除する" onclick="getAjaxText('/commentform.php?cmd=delete&file='+GetFileName(location.pathname)+'&id='+this.form.id.value+'&pw='+this.form.pw.value, 'commentBox')";></td></tr>
                  		<tr><td colspan="2">
                  			<ol>
-->
                  				<!--<li><b style="color:#f00">※</b>印は必須です。ハンドル名でも結構ですのでご記入ください。</li>-->
<!--
                  				<li>パスワードを設定しておけばご自分の記事を削除できます。</li>
                  				<li>当サイトにふさわしくないと判断した記事は管理者の独断で削除することがあります。</li>
                  			</ol>
                  		</td></tr>
                  		<tr><th>お名前</th>
                  			<td><input type="text" name="name" style="width:200px;" /></td></tr>
                  		<tr><th>パスワード</th>
                  			<td><input type="password" name="pw" style="width:200px;" /></td></tr>
                  		<tr><td><b>コメント </b><b style="color:#f00">※必須</b></td></tr>
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
                  						for="rulecheck">上記「コメントに関するお約束」に同意します。</label><br />
                  						<input type="reset" value="リセット" class="commandButton" />
                  						<input type="button" value="以上の内容でコメントを送信する"
                  						class="commandButton"
                  						onclick="
                  							if (this.form.comment.value=='') {
                  								alert('コメント本文をご記入ください。');
                  								return;
                  							}
                  							if (this.form.rulecheck.checked==false) {
                  								alert('「コメントに関するお約束」にご同意ください。');
                  								return;
                  							}
                  							if (this.form.name.value=='') {
                  								this.form.name.value = '名無しさん';
                  							}
//                  							if (isNaN(this.form.h1.value) || isNaN(this.form.h2.value) || isNaN(this.form.h3.value) || isNaN(this.form.m1.value) || isNaN(this.form.m2.value)|| isNaN(this.form.m3.value) || isNaN(this.form.s1.value) || isNaN(this.form.s2.value) || isNaN(this.form.s3.value)) {
//                  								alert('見所Timeは半角数字');
//                  								return;
//                  							}

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
    <div style="border:solid 1px #aaaaaa;overflow-y:auto;padding:4px;display:inline-block;width:480px;height:136px;">



        <div id="commentBox"></div>
        <script type="text/javascript" src="/commentform.js"></script>
    </div>
</div>
-->
<div style="height:6px">
</div>
<?php

    echo "<div id=\"hyoka\"><div style=\"width:110px;display:inline-block;margin-left:20px;\">\n";
    echo "<form style=\"position:relative;\" name=\"hyoka\" method=\"post\">\n";
    $i = 0;
    foreach($arrEmotion as $key => $value){
        echo "<label style=\"position:absolute; top:" . 31 * $i . "px;\" for=\"$key\">";
        echo "<input type=\"checkbox\" id=\"$key\" name=\"chk[]\" value=\"".$key."\">".$value;//."：".$row[$key];
        echo "</label>";
        echo "<br>\n";
        $i++;
    }

    $v = $_SESSION["v"];
    $cv = $_COOKIE["$v"];
    echo "<span style=\"position:absolute; top:420px\"><input style=\"width:90px\" type=\"button\" value=\"評価する\" name=\"go\" style=\"cursor:pointer\" onclick=\"check_hyoka('$cv')\"><img onmouseover=\"qaHyoka.style.display='block'\" onmouseout=\"qaHyoka.style.display='none'\" src=\"img/hatena.png\" style=\"width:15px;margin-left:5px\"></span><br>\n";
    echo "<div style=\"position:absolute; top:450px\">評価回数：".$_SESSION["total"]."</div>\n";
    echo "</form>\n";
    echo "</div>\n";

    echo "<div style=\"vertical-align:top;display:inline-block;\">\n";
    echo "<img style=\"position:relative;z-index:1\" src=\"img/graph.jpg\"></div>\n";
    echo "<div id=\"bar\" style=\"margin-top:-1px;vertical-align:top;display:inline-block;text-align:left;margin-left:-143px;position:relative;z-index:2\">";

    $color = "#FF0000";

    foreach($arrEmotion as $key => $value){
        if($key == "d"){
            $color = "#0000FF";
        }
        if($row["total"] == 0){
            $width = 0;
        }else{
            $width = $row[$key] / $row["total"] *138;
        }
//        echo "<img style=\"margin:2px 0\" src=\"img/bar.jpg\" width=\"".$width."px\" height=\"15px\">";
        echo "<div style=\"margin:2px 0 4px;width:" . $width . "px;height:26px;background-color:" . $color . "\"></div>\n";
    }

    echo "</div></div>\n";


?>
    <div id="qaHyoka" style="display:none;background-color:#ffffff;position:absolute;top:432px;left:774px;padding:10px;width:212px;border:1px solid #BBBBBB;border-radius:8px;box-shadow:0 0 14px 1px rgba(0,0,0,0.3);z-index:3">動画を見て感じた事に<br>いくつでもチェックを入れて<br>｢評価する｣ボタンを押してね。<br>グラフに反映されるよ！</div>


</div>
