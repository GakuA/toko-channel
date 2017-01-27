<!DOCTYPE html>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>投稿チャンネル</title>

	<link rel="shortcut icon" href="img/favicon.ico" />
	<link rel="stylesheet" href="/commentform.css" type="text/css">
	<link rel='stylesheet' href='popbox.css' type='text/css' media='screen' charset='utf-8'>
	<meta name="keywords" content="投稿チャンネル,投稿ch,投稿,動画,YouTube,ニコニコ動画,感情,評価,ランキング">
	<meta name="description" content="YouTubeとニコニコ動画のあなたのお気に入り動画を投稿したり、投稿されている動画を見たり評価し合うサイトです。">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta http-equiv="Content-Language" content="ja" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script src="jquery.js" type="text/javascript"></script>
	<script src="popbox.js" type="text/javascript"></script>
	<script src="js/ajax.js" type="text/javascript"></script>
	<script src="js/tag.js" type="text/javascript"></script>
	<script type='text/javascript' charset='utf-8'>
		$(document).ready(function() {
			$('.popbox').popbox();
		});

		function midokoro(mTime) {
			$("#video").attr({
				src: "//www.youtube.com/embed/<?php session_start();echo $_SESSION["v "]; ?>?autoplay=1&rel=0&start=" + mTime
			});
		}

	</script>
	<script>
		(function(i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r;
			i[r] = i[r] || function() {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
			a = s.createElement(o),
				m = s.getElementsByTagName(o)[0];
			a.async = 1;
			a.src = g;
			m.parentNode.insertBefore(a, m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-64826925-1', 'auto');
		ga('send', 'pageview');

	</script>

	<!-- head 内か、body 終了タグの直前に次のタグを貼り付けてください。 -->
	<script src="https://apis.google.com/js/platform.js" async defer>
		{
			lang: 'ja'
		}

	</script>

</head>

<body>
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.3&appId=783434548441929";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

	</script>
	<?php if(isset($_GET[ "id"])){ $_SESSION[ "v"]=$ _GET[ "id"]; } date_default_timezone_set( 'Asia/Tokyo'); include "function.inc"; include "array.inc"; ?>
	<div style="width:1272px;margin:0 auto;">
		<div style="float:left;width:1142px;">

			<!--top-->
			<div>
				<div style="float:right;margin-right:-30px;">
					<div style="display:inline-block;" class="fb-like" data-href="http://toko-channel.com/" data-width="69" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
					<a href="https://twitter.com/share" class="twitter-share-button" data-text="Check out this site !">Tweet</a>
					<script>
						! function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0],
								p = /^http:/.test(d.location) ? 'http' : 'https';
							if (!d.getElementById(id)) {
								js = d.createElement(s);
								js.id = id;
								js.src = p + '://platform.twitter.com/widgets.js';
								fjs.parentNode.insertBefore(js, fjs);
							}
						}(document, 'script', 'twitter-wjs');

					</script>
					<!-- +1 ボタン を表示したい位置に次のタグを貼り付けてください。 -->
					<div class="g-plusone" style="display:inline-block;width:65px" data-size="medium" data-href="http://toko-channel.com/"></div>
				</div>
				<a href="/" style="float:left;margin-top:-12px"><img src="img/logo.jpg" alt="投稿チャンネル">
				</a>
				<div class="top">
					<form action="./post.php" method="post">
						URL：
						<input class="post" type="text" name="url" placeholder="YouTube、またはニコニコ動画のURLを投稿してください">
						<input type="submit" value="投稿">
						<br>
					</form>
				</div>
			</div>
			<!--top-->

			<!--tab-->
			<div id="tab" style="width:100%;margin-top:10px;overflow-x:auto;white-space:nowrap">
				<?php include "tab.php"; echo "\n"; ?>
			</div>
			<!--tab-->

			<!--thumbnail-->
			<div id="thumbnail" style="border:solid 3px #aaaaaa;padding:3px 0 0 3px;font-size:12px;line-height:12px;height:184px;overflow-y:auto">

				<?php if($_SESSION[ "tab"]=="select" ){ include "tag.php"; }else{ include "thumbnail.php"; } ?>
			</div>
			<!--thumbnail-->

			<!--video-->
			<?php include "video.php"; ?>
			<!--video-->

			<?php mysql_close($link); ?>

			<div style="clear:both;padding:6px 4px;border-top:2px solid #ff0000;width:100%;">
				<!-- <a class="black" href="how.html">使い方</a> -->
				<span style="float:right;">Copyright © 2015 toko channel All Rights Reserved.</span>
				<!-- <span style="margin-left:10px"><a class="black" href="mailto:info@toko-channel.com">お問い合わせ</a></span> -->
				<span><a class="black" href="mailto:akazawagaku@gmail.com">お問い合わせ</a></span>
			</div>
		</div>
		<div style="margin-left:1152px;">
			<!-- Rakuten Widget FROM HERE -->
			<script type="text/javascript">
				rakuten_design = "slide";
				rakuten_affiliateId = "142a8617.af4bd4b0.142a8618.1730d9f1";
				rakuten_items = "ctsmatch";
				rakuten_genreId = 0;
				rakuten_size = "120x600";
				rakuten_target = "_blank";
				rakuten_theme = "gray";
				rakuten_border = "on";
				rakuten_auto_mode = "on";
				rakuten_genre_title = "off";
				rakuten_recommend = "on";

			</script>
			<script type="text/javascript" src="http://xml.affiliate.rakuten.co.jp/widget/js/rakuten_widget.js"></script>
			<!-- Rakuten Widget TO HERE -->
		</div>
	</div>
</body>

</html>
