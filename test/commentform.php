<?php
  session_start();
  date_default_timezone_set('Asia/Tokyo');
/*--------------------------------------------
	管理者パスワード
	このパスワードで全てのコメントを削除可能
	漏洩防止のため必ず変更してください。
*/
$root = 'yamamototamura';
/*--------------------------------------------
	コメントを保存するディレクトリ
	全てのコメントはこのディレクトリに保存される
	漏洩防止のため必ず変更してください。
*/
$commentdir = "comment/yamamototamura_".$_SESSION["v"];
/*--------------------------------------------*/
$Comment = array();
if (!is_dir($commentdir)) mkdir($commentdir);
if (is_file("$commentdir/comment.dat")) {
	$a=1;
	$Comment = file("$commentdir/comment.dat");
}
if ($_REQUEST[cmd] == 'commentRegist') {
	REQUEST_Purse();
	$value = join("\t", array(
		"id=". createid(),
		"date=". time(),
		"name=$_REQUEST[name]",
		"pw=$_REQUEST[pw]",
		"title=$_REQUEST[title]",
		"comment=$_REQUEST[comment]",
		"h1=$_REQUEST[h1]",
		"h2=$_REQUEST[h2]",
		"h3=$_REQUEST[h3]",
		"m1=$_REQUEST[m1]",
		"m2=$_REQUEST[m2]",
		"m3=$_REQUEST[m3]",
		"s1=$_REQUEST[s1]",
		"s2=$_REQUEST[s2]",
		"s3=$_REQUEST[s3]",
		"\n"
	));
	$value = mb_convert_encoding($value, "UTF-8", "auto");
	array_unshift ($Comment, $value);
	data_save("$commentdir/comment.dat", $Comment);
} elseif ($_REQUEST[cmd] == 'delete') {
	$i = 0;
	foreach ($Comment as $line) {
		if (preg_match("/^id=$_REQUEST[id]\t/", $line)) {
			$comment = dbfields($line);
			if ($comment[pw] == $_REQUEST[pw]
				|| $root == $_REQUEST[pw]) {
				array_splice($Comment, $i, 1);
				$match = true;
				break;
			}
		}
		$i++;
	}
	if ($match) data_save("$commentdir/comment.dat", $Comment);
}

header("Content-type:text/html; charset=UTF-8");
if($Comment != array()){
	foreach ($Comment as $line) {
		$comment = dbfields($line);
		$commet[comment] = wordwrap(str_replace("\r", "<br />", $commet[comment]));
		$comment[date] = jst_time($comment[date], 7);
		

echo <<<_
			<div class="commentlist">
		<!--		<div class="id">[$comment[id]]</div> -->
		<!--		<div class="title">$comment[title]</div> -->
				<div class="name">[$comment[name]]</div>
				<a href="javascript:void(0)" class="deleteButton"
					onclick="open_passworddialog('$comment[id]')">削除</a>
				<div class="date">$comment[date]</div>
				<br style="clear:both;" />
				<div class="comment">$comment[comment]</div>
_;
		for($i = 1; $i <= 3; $i++){
			$ti = "time".$i;
			$tHi = "timeH".$i;
			$tMi = "timeM".$i;
			$tSi = "timeS".$i;
			$tAi = "timeA".$i;
			$$ti = 0;
			$$tHi = "";
			$$tSi = "";
			$$tAi = "";
			$si = "s".$i;
			$mi = "m".$i;
			$hi = "h".$i;
			if($comment[$si] != ""){
				$$ti = $comment[$hi] * 60 * 60 + $comment[$mi] * 60 + $comment[$si];
				if($comment[$hi]){
					if($comment[$hi] != "0" | $comment[$hi] != "00"){
					    $$tHi = $comment[$hi]."：";
					}
					if(!$comment[$mi] | $comment[$mi] = "0"){
					    $$tMi = '00：';
					}
				}else{
					if($comment[$mi] && $comment[$mi] != "00"){
					    $$tHi = $comment[$mi]."：";
					}else{
						$$tMi = '0：';
					}
				}
				if(strlen($comment[$si]) == 1){
					$comment[$si] = "0".$comment[$si];
				}
				$$tAi = $$tHi.$$tMi.$comment[$si];
			}
			if($$ti != 0){
			    echo "<input style=\"margin-right:4px\" type=\"button\" value=".$$tAi." onClick=\"midokoro(".$$ti.")\">";
			}
		}
		echo "</div>";
	}
}else{
	echo "解説はありません";
}
echo <<<_

<div id="passworddialog">
	<div class="titlebar">■パスワード</div>
	<div class="passwordbox">
		<form action="javascript:void(0)" name="passwordform">
			<input type="hidden" name="id" value="" />
			投稿時のパスワード：<br />
			<input type="password" name="pw" style="width:100px;">
			<input type="button" value="変更する"
			onclick="
				if (this.form.pw.value=='') {
					close_passworddialog();
					return;
				} else {
					getAjaxText('/commentform.php?cmd=delete&file='+GetFileName(location.pathname)+'&id='+this.form.id.value+'&pw='+this.form.pw.value, 'commentBox');
<!--					getAjaxText('/commentform.php?cmd=delete&file='+GetFileName(location.pathname)+'&id='+this.form.id.value+'&pw='+this.form.pw.value, 'commentBox');-->
				}" />
			<input type="button" value="キャンセル"
			onclick="close_passworddialog()" />
		</form>
	</div>
</div>
_;
function dbfields($buffer) {
	$Array = preg_split("/\t/", $buffer);
	foreach ($Array as $val) {
		list($key, $value) = split("=", $val);
		$key = tag_decode($key);
		$value = tag_decode($value);
		$Field[$key] = $value;
	}
	return($Field);
}
function tag_decode($buffer, $tag = 0) {
	$buffer = str_replace("&#61;", "=", $buffer);
	$buffer = str_replace("&#13;", "\r", $buffer);
	$buffer = str_replace("&#9;", "\t", $buffer);
	$buffer = str_replace("&quot;", "\"", $buffer);
	if ($tag) {
		$buffer = str_replace("&lt;", "<", $buffer);
		$buffer = str_replace("&gt;", ">", $buffer);
	}
	return($buffer);
}
function tag_encode($buffer) {
	$buffer = str_replace("=", "&#61;", $buffer);
	$buffer = str_replace("<", "&lt;", $buffer);
	$buffer = str_replace(">", "&gt;", $buffer);
	$buffer = str_replace("\"", "&quot;", $buffer);
	$buffer = preg_replace("/\t/", "&#9;", $buffer);
	$buffer = preg_replace("/\r/", "&#13;", $buffer);
	$buffer = preg_replace("/\n/", "", $buffer);
	$buffer = trim($buffer);
	return($buffer);
}
function REQUEST_Purse() {
	$Keys = array_keys($_REQUEST);
	foreach ($Keys as $key) {
		if (!array_key_exists($key, $_FILES)
			&& !array_key_exists($key, $_COOKIE)) {
			if (!is_array($_REQUEST[$key])) {
				$_REQUEST[$key] = tag_encode($_REQUEST[$key]);
				$_REQUEST[$key] = trim($_REQUEST[$key]);
			}
		}
	}
}
function createid() {
	return(unique_id(0, 36));
}
function unique_id($op = 0, $asc = 62) {
	/*
	 重複しないユニークなIDの生成(8桁まで英数字)
	 H62()及びAscii()関数必須
	 1から99までの引数を与えることも可能で、同一プロセス内でも99個までは作成可能
	【例】
	 $id = unique_id();
	 $ID[$no] = unique_id($no);

	 $Serialtime = substr(H62($id, 0), 0, 10); で作成時のシリアルタイムを取得可能。
	*/
	//$process = "0000". posix_getsid();
	$process = "0000". getmypid();
	if ($op) {
		$process = reverse(substr(reverse($process), 0, 2)) . sprintf("%02d", $op);
	} else {
		$process = reverse(substr(reverse($process), 0, 4));
	}
	// 0.01秒スリープ
	usleep(100000);
	return(H62(time().$process, 1, $asc));
}
function int($var) {
	return(floor($var));
}
function H62($ID, $flg, $asc = 62) {
	/*
	 最大14桁までの正の整数を[0-9A-Za-z]のアスキー文字に変換
	 $flg = 1 の場合に62文字による62進数に、
	 $flg = 0 の場合は元の整数に複合化する。
	*/
	$i = 0;
	if ($flg) {
		while ($ID > 0) {
			$amari = fmod($ID, $asc);
			$ID = int($ID / $asc);
			$value .= Ascii($amari, 1);
			$i++;
			if ($i > 1000) break;
		}
		$value = strrev($value);
	} else {
		$len = strlen($ID);
		$col = 1;
		for($i=0;$i<$len;$i++) {
			$a = substr($ID, $i, 1);
			$v = Ascii($a, 0);
			if ($col == 1) {
				$value = $v * $asc;
			} else {
				$value += $v;
				if ($col >= $len) { break; }
				$value = $value * $asc;
			}
			$col++;
		}
	}
	return($value);
}
function Ascii($cd, $flg, $asc = 0) {
	/*
	 H62(62進法)関数で必須
	*/
	if ($asc) {
		$Ascii = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	} else {
		$Ascii = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	}
	if ($flg) {
		$i = substr($Ascii, $cd, 1);
	} else {
		$i = strpos($Ascii, $cd);
	}
	return($i);
}
function reverse($str) {
	return(strrev($str));
}
function data_save($filename, $Buffer = array()) {
	if ($filename) {
		$fp = fopen($filename, "w+");
		if (flock($fp, LOCK_EX)) {
			foreach ($Buffer as $val) {
				if (!preg_match("/\n$/", $val)) $val .= "\n";
				fwrite($fp, $val);
			}
			flock($fp, LOCK_UN);
		}
		fclose($fp);
	}
}
function jst_time($serialtime, $flag = 0) {
	if (!$serialtime) return('');
	$Date = localtime($serialtime, true);
	$Date[tm_year] += 1900;
	$Date[tm_mon]++;
	if ($flag < 3) {
		$Wdays = array("日","月","火","水","木","金","土");
	} else {
		$Wdays = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
	}
	$Date[tm_wday] = $Wdays[$Date[tm_wday]];
	$datestr = "";
	switch ($flag) {
		case 0:
			$datestr = "$Date[tm_year]年$Date[tm_mon]月$Date[tm_mday]日($Date[tm_wday]) $Date[tm_hour]:$Date[tm_min]:$Date[tm_sec]";
			break;
		case 1:
			$datestr = "$Date[tm_year]年$Date[tm_mon]月$Date[tm_mday]日($Date[tm_wday])";
			break;
		case 2:
			$datestr = "$Date[tm_year]年$Date[tm_mon]月$Date[tm_mday]日 ";
			break;
		case 3:
			$datestr = "$Date[tm_year]/$Date[tm_mon]/$Date[tm_mday]($Date[tm_wday]) $Date[tm_hour]:$Date[tm_min]:$Date[tm_sec]";
			break;
		case 4:
			$datestr = "$Date[tm_year]/$Date[tm_mon]/$Date[tm_mday]($Date[tm_wday])";
			break;
		case 5:
			$datestr = sprintf("%04d/%02d/%02d", $Date[tm_year],$Date[tm_mon],$Date[tm_mday]);
			break;
		case 6:
			$datestr = "$Date[tm_year]/$Date[tm_mon]/$Date[tm_mday] $Date[tm_hour]:$Date[tm_min]";
			break;
		case 7:
			$datestr = sprintf("%04d/%02d/%02d %02d:%02d:%02d",$Date[tm_year],$Date[tm_mon],$Date[tm_mday],$Date[tm_hour],$Date[tm_min],$Date[tm_sec]);
			break;
		case 8:
			$datestr = sprintf("%02d/%02d/%02d", $Date[tm_year]-2000, $Date[tm_mon], $Date[tm_mday]);
			break;
		case 9:
			$datestr = sprintf("%04d-%02d-%02dT%02d:%02d:%02d\+09:00",$Date[tm_year],$Date[tm_mon],$Date[tm_mday],$Date[tm_hour],$Date[tm_min],$Date[tm_sec]);
		default:
			$datestr = sprintf("%02d/%02d %02d:%02d",$Date[tm_mon],$Date[tm_mday],$Date[tm_hour],$Date[tm_min]);
			break;
	}
	return($datestr);
}
?>
