
String.prototype.trim = function()
{
	// 用正则表达式将前后空格
	// 用空字符串替代。
	return this.replace(/(^\s*)|(\s*$)/g, "");
}
/**
 * 统计字符串字节数
 *
 * return	integer
 */
String.prototype.ByteCount = function()
{
	txt = this.replace(/(<.*?>)/ig,'');
	txt = txt.replace(/([\u0391-\uFFE5])/ig, '11');
	var count = txt.length;
	return count;
}

var http_request = false;
function send_request(url) {//初始化、指定处理函数、发送请求的函数
	http_request = false;
	//开始初始化XMLHttpRequest对象
	if(window.XMLHttpRequest) { //Mozilla 浏览器
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {//设置MiME类别
			http_request.overrideMimeType("text/xml");
		}
	}
	else if (window.ActiveXObject) { // IE浏览器
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!http_request) { // 异常，创建对象实例失败
		window.alert("不能创建XMLHttpRequest对象实例.");
		return false;
	}
	var number = Math.random();
	var fullurl=url+'&n='+number;
	http_request.onreadystatechange = checkrepeat;
	// 确定发送请求的方式和URL以及是否同步执行下段代码
	http_request.open("GET", fullurl, true);
	http_request.send(null);
}

// 处理返回信息的函数
function processRequest() {
       if (http_request.readyState == 4) { // 判断对象状态
            if (http_request.status == 200) { // 信息已经成功返回，开始处理信息
				document.getElementById('checkloginidframe').innerHTML = http_request.responseText;
				//checkloginidframe.innerHTML = '';
                //alert(http_request.responseText);
            } else { //页面不正常
                alert("您所请求的页面有异常。");
            }
        }
    }

function checkrepeat() {
	if (http_request.readyState == 4) { // 判断对象状态
		if (http_request.status == 200) { // 信息已经成功返回，开始处理信息
			reval = http_request.responseText;
			if(reval) {
				var val = reval.split(':');
				document.getElementById(val[0]+'info').innerHTML = val[2];
				if(parseInt(val[1]) > 0) {
					document.getElementById(val[0]+'info').className="reg_bg_three";
					document.getElementById(val[0]+'repeat').value = val[1];
				} else {
					document.getElementById(val[0]+'info').className="reg_bg_four";
					document.getElementById(val[0]+'repeat').value = val[1];
				}
			}
		} else { //页面不正常
			alert("您所请求的页面有异常。");
		}
	}
}

//获得登录名焦点
function click_loginid()
{
	document.getElementById('loginidinfo').innerHTML="4-16个字符（包括4、16）或2-8个汉字";
}

//失去登录名焦点
function check_loginid(thisobj)
{
	var re = /^[\w|\u4E00-\u9FA5]+$/;
	var count = thisobj.value.trim().ByteCount();
	if( count == 0 )
	{
		document.getElementById('loginidinfo').className='reg_bg_three';
		document.getElementById('loginidinfo').innerHTML="请输入登录名！";
		return false;
	}
	else if ((( count > 16 || count < 4))|| !thisobj.value.match(re)) {
		document.getElementById('loginidinfo').className="reg_bg_three";
		document.getElementById('loginidinfo').innerHTML="你输入的登录名不符合规范，请重新输入！";
		return false;
	}
	else
	{
		document.getElementById('loginidinfo').innerHTML = '正在检查...';
		var ret=send_request('chkreginfo.php?loginid='+encodeURIComponent(thisobj.value));
		return true;
	}
}

//获得第一个密码焦点
function click_pwd()
{
		document.getElementById('pwdinfo').innerHTML="密码须为6位或6以上的字母/数字/下划线";
}
//失去第一个密码焦点
function check_pwd(thisobj)
{
	var re = /^[\w]+$/;
	var count = thisobj.value.trim().ByteCount();

	if ( (thisobj.value.trim() == '') ) {
		document.getElementById('pwdinfo').className="reg_bg_three";
		document.getElementById('pwdinfo').innerHTML="请输入密码！";
		return false;
	}
	else if (!thisobj.value.match(re) || (count < 6 ) )
	{
		document.getElementById('pwdinfo').className = 'reg_bg_three';
		document.getElementById('pwdinfo').innerHTML = '你输入的密码不符合规范，请重新输入！';
		return false;
	}
	else
	{
		document.getElementById('pwdinfo').className = 'reg_bg_four';
		document.getElementById('pwdinfo').innerHTML = '√';
		return true;
	}
}
//获得第二个密码焦点
function click_repwd()
{
		var oPass = document.getElementById('password').value;
		if( oPass == '')
		{
			document.getElementById('password').focus();
			document.getElementById('pwdinfo').innerHTML="请输入密码！";
		}else{
			document.getElementById('repwdinfo').innerHTML="请输入确认密码";
		}
}
//失去第二个密码焦点
function check_repwd(thisobj)
{
	var oPass = document.getElementById('password').value;
	if( thisobj.value.length=='' )
	{
		document.getElementById('repwdinfo').className="reg_bg_three";
		document.getElementById('repwdinfo').innerHTML = '请输入确认密码！';
		return false;
	}
	else if(thisobj.value != oPass)
	{
		document.getElementById('repwdinfo').className='reg_bg_three';
		document.getElementById('repwdinfo').innerHTML = '两次输入的密码不一致，请重新输入。';
		return false;
	}
	else
	{
		document.getElementById('repwdinfo').className = 'reg_bg_four';
		document.getElementById('repwdinfo').innerHTML = '√';
		return true;
	}
}

//获得EMAIL焦点
function click_email()
{
		document.getElementById('emailinfo').innerHTML="忘记密码时，可凭安全邮箱索取密码";
}
//失去Email焦点
function check_email(thisobj)
{
	//var re = /^[0-9a-zA-Z\-\.\_]+@[0-9a-zA-Z\-]+\.[0-9a-zA-Z\-\.]+$/;
	var re = /^[_\.0-9a-zA-Z-]+[0-9a-zA-Z]@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,3}$/;

	if ( (thisobj.value.trim() == '') ) {
		document.getElementById('emailinfo').className="reg_bg_three";
		document.getElementById('emailinfo').innerHTML="请输入E-mail！";
		return false;
	}
	else if (!thisobj.value.match(re) || thisobj.value.split("@")[0].length > 20)
	{
		document.getElementById('emailinfo').className = 'reg_bg_three';
		document.getElementById('emailinfo').innerHTML = '你输入的E-mail不符合规范，请重新输入！';
		return false;
	}
	else
	{
		document.getElementById('emailinfo').innerHTML = '正在检查...';
		send_request('chkreginfo.php?email='+thisobj.value);
		return true;
	}
}

//失去City焦点
function check_city(value)
{

	if ( (value == 0) ) {
		document.getElementById('geoinfo').className = "reg_bg_three";
		document.getElementById('geoinfo').innerHTML = "请选择所在城市！";
		return false;
	}
	else
	{
		document.getElementById('geoinfo').className = "reg_bg_four";
		document.getElementById('geoinfo').innerHTML = "√";
		return true;
	}
}

//获得验证码焦点
function click_auth()
{
		document.getElementById('authinfo').innerHTML="请输入图中的四位数字验证码";
}
//失去验证码焦点
function check_auth(thisobj)
{
	var re = /([0-9]){4}/;
	var count = thisobj.value.trim().ByteCount();

	if ( (thisobj.value.trim() == '') ) {
		document.getElementById('authinfo').className="reg_bg_three";
		document.getElementById('authinfo').innerHTML="请输入验证码！";
		return false;
	}
	else if(!thisobj.value.match(re) || count != 4 )
	{
		document.getElementById('authinfo').className = 'reg_bg_three';
		document.getElementById('authinfo').innerHTML = '验证码不正确，请重新输入！';
		return false;
	}
	else
	{
		document.getElementById('authinfo').className="reg_bg_two";
		document.getElementById('authinfo').innerHTML="此步骤有助于防止恶意自动注册行为的发生。";
		return true;
	}
}
function check_auth_new(thisobj)
{
	var count = thisobj.value.trim().ByteCount();
	var dom_authinfo = document.getElementById('authinfo');
	if ( (thisobj.value.trim() == '') || (thisobj.value.trim() == '比如：12345')) {
		dom_authinfo.className="reg_bg_three";
		dom_authinfo.innerHTML="请输入验证码！";
		return false;
	}
	else
	{
		dom_authinfo.className="reg_bg_two";
		dom_authinfo.innerHTML="此步骤有助于防止恶意自动注册行为的发生。";
		return true;
	}
}

function chkForm() {
	var r = /^[\w|\u4E00-\u9FA5]+$/;
	var rm = /^[_\.0-9a-zA-Z-]+[0-9a-zA-Z]@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,3}$/
	var re = /^[\w]+$/;
	var recode = /([0-9]){4}/;

	var email = document.getElementById('email').value.trim();
	var loginid = document.getElementById('login_id').value.trim();
	var password =document.getElementById('password').value.trim();
	var repwd = document.getElementById('repassword').value.trim();
	var city = document.getElementById('geo1').value.trim();
	var authcode = document.getElementById('number').value.trim();
	if( loginid.ByteCount()<4 || loginid.ByteCount()>16 || (!loginid.match(r)) )
	{
		document.getElementById('login_id').focus();
		document.getElementById('loginidinfo').className="reg_bg_three";
		document.getElementById('loginidinfo').innerHTML="你输入的登录名不符合规范，请重新输入！";
		return false;
	}
	if(document.getElementById('loginidrepeat').value == '1') {
		document.getElementById('login_id').focus();
		document.getElementById('loginidinfo').className="reg_bg_four";
		document.getElementById('loginidinfo').innerHTML="此登录名已被注册，请更换一个！";
		return false;
	}
	if( password.ByteCount() < 6 || (!password.match(re)) )
	{
		document.getElementById('pwdinfo').className = 'reg_bg_three';
		document.getElementById('pwdinfo').innerHTML = '你输入的密码不符合规范，请重新输入！';
		document.getElementById('password').focus();
		return false;
	}
	if( password != repwd)
	{
		document.getElementById('repassword').focus();
		document.getElementById('repwdinfo').className='reg_bg_three';
		document.getElementById('repwdinfo').innerHTML = '两次输入的密码不一致，请重新输入。';
		return false;
	}
	if(email=='' || (!email.match(rm)))
	{
		document.getElementById('email').focus();
		document.getElementById('emailinfo').className = 'reg_bg_three';
		document.getElementById('emailinfo').innerHTML = '你输入的E-mail不符合规范，请重新输入！';
		return false;
	}
	var emailrepeat = parseInt(document.getElementById('emailrepeat').value);
	if(emailrepeat > 0) {
		document.getElementById('email').focus();
		document.getElementById('emailinfo').className="reg_bg_three";
		if(emailrepeat == 1) {
			document.getElementById('emailinfo').innerHTML="此邮箱已被注册，请更换一个！";
		} else {
			document.getElementById('emailinfo').innerHTML="请填写正确的E-mail！";
		}
		return false;
	}
	if( city == 0 )
	{
		document.getElementById('geo1').focus();
		document.getElementById('geoinfo').className="reg_bg_three";
		document.getElementById('geoinfo').innerHTML="请选择城市！";
		return false;
	}
	if(authcode == '比如：12345'){
		document.getElementById('number').focus();
		document.getElementById('authinfo').innerHTML="请输入验证码！";
		return false;
	}
	/*
	if(!authcode.match(recode))
	{
		document.getElementById('number').focus();
		document.getElementById('authinfo').className="reg_bg_three";
		document.getElementById('authinfo').innerHTML="请输入正确的验证码！";
		return false;
	}
	*/
	return true;
}

function showpersonal(check) {
	if(check == true) {
		document.getElementById('companyname').style.display="none";
		document.getElementById('companyurl').style.display="none";
		document.getElementById('companyperson').style.display="none";
		document.getElementById('officetel1').style.display="none";
		document.getElementById('officetel2').style.display="none";
		document.getElementById('personalname').style.display="";
		document.getElementById('hometel').style.display="";
		document.getElementById('worktel').style.display="";
		document.userForm.name.focus();
	}
}
function showcompany(check) {
	if(check == true) {
		document.getElementById('personalname').style.display="none";
		document.getElementById('hometel').style.display="none";
		document.getElementById('worktel').style.display="none";
		document.getElementById('companyname').style.display="";
		document.getElementById('companyurl').style.display="";
		document.getElementById('companyperson').style.display="";
		document.getElementById('officetel1').style.display="";
		document.getElementById('officetel2').style.display="";
		document.getElementById('companyname').focus();
	}
}

function isphone_NUM(str,n){             //数字字符串判定
	var flag=1;
	for(var i=0;i<n;i++){
		var not_NUM=(str.charAt(i)>"9" || str.charAt(i)<"0");
		if((not_NUM && str.charAt(i)!="-" ) && (not_NUM && str.charAt(i)!="(" ) && (not_NUM && str.charAt(i)!=")" ) ){
			flag=0;
	 		return flag;
		}
	}
	return flag;
}

function get_geo(type, id, de) {
	if (typeof(geoArray[id]) != "undefined") {
		var geo = geoArray[id];
		if(geo.length > 1) {
			if(document.getElementById(type) == null) {
				var select1 = document.createElement("select");
				select1.id = type;
				select1.name = type;
				document.getElementById("sel_geo").appendChild(select1);
			} else {
				document.getElementById(type).length = 0;
			}
			for (i=0; i<geo.length; i++) {
				var geo_info = geo[i].split('::');
				document.getElementById(type).options[i] = new Option(geo_info[1], geo_info[0]); //建立option
				if( de == geo_info[0] ) document.getElementById(type).options[i].selected = true;
			}
			document.getElementById(type).style.display = '';
		} else if(document.getElementById(type)) {
			document.getElementById(type).length = 0;
			document.getElementById(type).style.display = 'none';
		}
	} else if(document.getElementById(type)) {
		document.getElementById(type).length = 0;
		if(type == 'geo2') document.getElementById(type).style.display = "none";
	}
	if(de>1 && type=='geo1') {
		get_geo('geo2', de, 0);
	}
}


function get_geo_post(type, id, de) {
	var subtype = type.substr(-4,4);
	if (typeof(geoArray[id]) != "undefined") {
		var geo = geoArray[id];
		if(geo.length > 1) {
			if(document.getElementById(type) == null) {
				var select1 = document.createElement("select");
				select1.id = type;
				select1.name = type;
				document.getElementById("sel_geo1").appendChild(select1);
			} else {
				document.getElementById(type).length = 0;
			}
			for (i=0; i<geo.length; i++) {
				var geo_info = geo[i].split('::');
				document.getElementById(type).options[i] = new Option(geo_info[1], geo_info[0]); //建立option
				if( de == geo_info[0] ) document.getElementById(type).options[i].selected = true;
			}
			document.getElementById(type).style.display = '';
		} else if(document.getElementById(type)) {
			document.getElementById(type).length = 0;
			document.getElementById(type).style.display = 'none';
		}
	} else if(document.getElementById(type)) {
		document.getElementById(type).length = 0;
		if(subtype == 'geo2') document.getElementById(type).style.display = "none";
	}
	if(de>1 && subtype=='geo1') {
		var geo2type = type.replace('geo1','geo2');
		get_geo(geo2type, de, 0);
	}
}
function checkver(form,n,txt) {
	if(typeof(txt)=='undefined'){
		txt = '比如：12345';
	}
	var kw = form;
	if(n==0){
		if(kw.value == ''){
			kw.value = txt;
		}
	}
	if(n==1){
		if(kw.value == txt){
			kw.value='';
		}
	}
}

