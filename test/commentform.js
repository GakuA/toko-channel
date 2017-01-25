var AjaxObject = false;

if (window.XMLHttpRequest) {
	AjaxObject = new XMLHttpRequest();
} else if (window.ActiveXObject) {
	try {
		AjaxObject = new ActiveXObject("Msxml2.XMLHTTP");
	} catch(e) {
		AjaxObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
}
function getAjaxText(url, obj, func) {
	if (!AjaxObject) return;
	var myDate = new Date;
	if (!url.match(/\?/)) {
		url = url + '?';
	}
	url += '&t='+myDate.getTime();
	AjaxObject.open('GET', url, true);
	AjaxObject.send(null);
	AjaxObject.onreadystatechange=function() {
		if (AjaxObject.readyState==4
			&& AjaxObject.status==200) {
			document.getElementById(obj).innerHTML =
			AjaxObject.responseText;
			if (func) {
				func();
			}
		}
	}
}
function GetFileName(file_url){
	//file_url = file_url.substring(file_url.lastIndexOf("/")+1,file_url.length);
	file_url = file_url.substring(0,file_url.indexOf("."));
	file_url = file_url.replace(/\//g, '_');
    return file_url;
}
function commentformsubmit() {
	var url = '/commentform.php?cmd=commentRegist&file='+GetFileName(location.pathname);
		with (document.commentform) {
		url = url + '&name=' + name.value;
		url = url + '&title=' + title.value;
		url = url + '&pw=' + pw.value;
		url = url + '&comment=' + comment.value;
		url = url + '&h1=' + h1.value;
		url = url + '&h2=' + h2.value;
		url = url + '&h3=' + h3.value;
		url = url + '&m1=' + m1.value;
		url = url + '&m2=' + m2.value;
		url = url + '&m3=' + m3.value;
		url = url + '&s1=' + s1.value;
		url = url + '&s2=' + s2.value;
		url = url + '&s3=' + s3.value;
		reset();
		getAjaxText(url, 'commentBox');
	}
}
function open_passworddialog(id) {
	document.passwordform.id.value=id;
	document.getElementById('passworddialog').style.display='block';
}
function close_passworddialog() {
	document.getElementById('passworddialog').style.display='none';
}
getAjaxText('/commentform.php?file='+GetFileName(location.pathname), 'commentBox');
