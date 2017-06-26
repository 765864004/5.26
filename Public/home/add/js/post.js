function $(id){return document.getElementById(id);}
String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*$)/g,"");}
String.prototype.ByteCount=function()
{txt=this.replace(/(<.*?>)/ig,'');txt=txt.replace(/([\u0391-\uFFE5])/ig,'11');var count=txt.length;return count;}
function post_cat_geo(urlext){var cat_id;var cat_msg="请选择分类，信息不能直接发布到顶级分类!\n";if(cmd=='update'&&$('cat_id')&&$('cat_id').value){cat_id=$('cat_id').value;}else{if($('cat[4]')&&$('cat[4]').length){cat_id = $('cat[4]').value;cat_msg = "请选择分类，信息只能发布到最后一级分类!\n";}else if($('cat[3]')&&$('cat[3]').length){cat_id=$('cat[3]').value;cat_msg="请选择分类，信息只能发布到最后一级分类!\n";}else{cat_id=$('cat[2]').value;}}
var province=$('geo[1]').value;var city=$('geo[2]').value;var validate=true;var alert_msg="";if($('black_ip')&&$('black_ip').value)
{validate=false;alert_msg+="您的IP地址已经被锁定，请使用首页底部的 反馈/投诉 联系我们的客服!\n";}
if(!cat_id){validate=false;alert_msg+=cat_msg;}
var cities=',2,6,12,14,38,39,49,54,94,117,120,';if(((user_type==2&&!province)||(user_type!=2&&cities.indexOf(','+province+',')<0&&!city))&&CatnoRelatedGeo.indexOf(','+cat_id+',')<0){validate=false;alert_msg+="请选择地区，信息不能直接发布到省级地区!\n";}
if(validate){$('choice_cat_geo').action='post_msg.php?'+urlext;$('submit').click();}else alert(alert_msg);}
function post_msg(){var cat_id=$('cat_id').value;var geo_id=$('geo_id').value;var validate=true;var alert_msg="";if(!cat_id){validate=false;alert_msg+="请选择分类\n";}
if(!geo_id){validate=false;alert_msg+="请选择地区\n";}
if(validate){$('choice_cat_geo').action='post_action.php?cmd='+cmd;$('submit').click();}else alert(alert_msg);}
function setmState(obj){if(obj.checked==true){obj.form.marketing_code.disabled=false;obj.form.addviewcode.disabled=false;obj.form.rank.disabled=false;}
else{obj.form.marketing_code.disabled=true;obj.form.addviewcode.disabled=true;obj.form.rank.disabled=true;}
setvState(document.eDeng.addviewcode);}
function setvState(obj){if(obj.checked==true&&obj.disabled==false){obj.form.view_code.disabled=false;}
else{obj.form.view_code.disabled=true;}}
function change_cat_geo(type,cmd,cat_trace_id,geo_trace_id){var formObj=document.eDeng;formObj.action='/code/bin/post/choice_cat_geo.php?cmd='+escape(cmd)+'&type='+escape(type)+'&geotrace='+escape(geo_trace_id)+'&cattrace='+escape(cat_trace_id);formObj.target='';var formObj=document.eDeng;formObj.submit();}
function get_geo(type,id,de){if(type==2&&id==1){$('geo[2]').length=0;$('geo[3]').length=0;$('geo[4]').length=0;$('geo[2]').style.backgroundColor="#F8F8F8";$('geo[3]').style.backgroundColor="#F8F8F8";$('geo[4]').style.backgroundColor="#F8F8F8";return;}
var j=type+1;for(var x=j;x<5;x++){$('geo['+x+']').length=0;$('geo['+x+']').style.backgroundColor="#F8F8F8";}
if(typeof(geoArray[id])!="undefined"){var geo=[];if(typeof(user_type)!="undefined"&&user_type==2&&type==1){geo.push("1::中国");}
if(typeof(slinkArray)!="undefined"&&typeof(slinkArray[id])!="undefined"){for(i=0;i<slinkArray[1].length;i++){geo.push(slinkArray[1][i]);}}
for(i=0;i<geoArray[id].length;i++){geo.push(geoArray[id][i]);}
if(geo.length>0){if($('geo['+type+']')==null){var select1=document.createElement("select");select1.id='geo['+type+']';select1.name='geo['+type+']';select1.size='13';select1.style.width='150px';select1.style.height='186px';select1.onchange=function(){get_geo('geo['+j+']',this.value,0);}
if($("select_geo"))$("select_geo").appendChild(select1);}else if(type!=1){$('geo['+type+']').length=0;$('geo['+type+']').style.backgroundColor="";}
if($('geo['+type+']'))y=$('geo['+type+']').length;else y=0;if($('geo['+type+']')){for(i=0;i<geo.length;i++){var geo_info=geo[i].split('::');$('geo['+type+']').options[i]=new Option(geo_info[1],geo_info[0]);if(de==geo_info[0])$('geo['+type+']').options[i].selected=true;}
$('geo['+type+']').style.display='';}}else if($('geo['+type+']')){$('geo['+type+']').length=0;$('geo['+type+']').style.display='none';}}else if($('geo['+type+']')){$('geo['+type+']').length=0;if(type==5)$('geo[5]').style.display='none';}}
function get_cat(type,id,de){var j=type+1;for(var x=j;x<5;x++){$('cat['+x+']').length=0;$('cat['+x+']').style.backgroundColor="#F8F8F8";}
if(typeof(catArray[id])!="undefined"){var cat=catArray[id];if(cat.length>0){if($('cat['+type+']')==null){var select1=document.createElement("select");select1.id='cat['+type+']';select1.name='cat['+type+']';select1.size='13';select1.style.width='150px';select1.style.height='186px';select1.onchange=function(){get_cat('cat['+j+']',this.value,0);}
$("select_cat").appendChild(select1);}else if(type!=1){$('cat['+type+']').length=0;$('cat['+type+']').style.backgroundColor="";}
y=$('cat['+type+']').length;for(i=0;i<cat.length;i++){var cat_info=cat[i].split('::');$('cat['+type+']').options[i]=new Option(cat_info[1],cat_info[0]);if(de==cat_info[0])$('cat['+type+']').options[i].selected=true;}
$('cat['+type+']').style.display='';}else if($('cat['+type+']')){$('cat['+type+']').length=0;$('cat['+type+']').style.display='none';}}else if($('cat['+type+']')){$('cat['+type+']').length=0;if(type==5)$('cat[5]').style.display='none';}}
var bluecol='rgb(33, 74, 225)';var greencol='rgb(83, 153, 13)';var redcol='rgb(248, 7, 7)';var graycol='rgb(204, 204, 204)';var focusId='';function showTS(id,classname,content,col,sub,relid){var relid=relid?relid:'';var subid=id;var subidlen=id.length;if(sub)subid=id.substring(0,14)+id.substring(subidlen-3,subidlen);if($(subid+'span')&&$(subid+'span').className=='wrong'&&(classname=='tishi'||classname==''))return;if(relid){setBorderColor($(relid),col);}else{setBorderColor($(id),col);}
if(classname){if($(subid+'text'))$(subid+'text').innerHTML=content;if($(subid+'span'))$(subid+'span').className=classname;if($(subid+'ts'))$(subid+'ts').style.display='';if(id=='imagefile')$('imgts').style.display='none';}else{if($(subid+'ts'))$(subid+'ts').style.display='none';if(id=='imagefile')$('imgts').style.display='';}}
function hidden(id){if($(id))$(id).style.display='none';}
function setBorderColor(obj,col){if(obj&&col)obj.style.borderColor=col;}
function enable_expired(id,rid){if(document.getElementById(id).checked==true){document.getElementById(rid).disabled=false;}else{document.getElementById(rid).disabled=true;}}
function checkstr(str)
{num=str.length
var arr=str.match(/[^\\\\\\\\\\\\\\\\x00-\\\\\\\\\\\\\\\\x80]/ig)
if(arr!=null)num+=arr.length
return num;}
function checktitle() {
	var str = $('title').value.trim();
	if (checkstr(str) < 12) {
		showTS('title', 'wrong', '您发表的信息标题最少应该为6个字！', redcol);
		if(focusId == '') focusId = 'title';
		return 0;
	}else if(checkstr(str) > 50){
		showTS('title', 'wrong', '您发表的信息标题最多应该为25个字！', redcol);
		if(focusId == '') focusId = 'title';
		return 0;
	} else if (!checkspstr(str)) {
		showTS('title', 'wrong', '请不要在标题内添加怪异字符，例如：⊙☆◆等！', redcol);
		if(focusId == '') focusId = 'title';
		return 0;
	} else {
		var msg_title = str.replace(/(\s*)/g, '');
		if(/@/.test(msg_title) || /[0-9０１２３４５６７８９零一二三四五六七八九壹贰叁肆伍陆柒捌玖]{6,}/.test(msg_title)){
			showTS('title', 'wrong', '标题内请不要填写电话号码，即时通讯工具和电子邮件等联系方式！', redcol);
			if(focusId == '') focusId = 'title';
			return 0;
		}
	}
	showTS('title', 'ok', '', greencol);
	return 1;
}
function checkstrlen(obj,msg,id,m){var str=obj.value.trim();var n=m*2;if(checkstr(str)>n){showTS(id,'wrong',msg+'最多应该为'+m+'个汉字！',redcol,0);if(focusId=='')focusId=id;setBorderColor(obj,redcol);return 0;}
if(str){showTS(id,'ok','',greencol,0);setBorderColor(obj,greencol);}else{showTS(id,'','',graycol,0);setBorderColor(obj,graycol);}
return 1;}
function checkcp(obj,msg,id,isempty){var str=obj.value.trim();var isempty=isempty?isempty:0;if(str==''){showTS(id,'wrong',msg+'必须填写',redcol,0);if(focusId=='')focusId=id;setBorderColor(obj,redcol);return 0;}else if(isempty && !isNaN(str)){showTS(id,'wrong',msg+'不能为纯数字',redcol,0);if(focusId=='')focusId=id;setBorderColor(obj,redcol);return 0;}else{showTS(id,'ok','',greencol,0);setBorderColor(obj,greencol);}
return 1;}
function checkemail(id,session,isempty){var str=$(id).value.trim();var isempty=isempty?isempty:0;var rm=/^[_\.0-9a-zA-Z-]+[0-9a-zA-Z]@([0-9a-zA-Z-]+\.)+[a-zA-Z]{2,4}$/;if(isempty&&!str){showTS(id,'wrong','email不能为空。',redcol);if(focusId=='')focusId=id;return 0;} if(session){if(str!=''&&!str.match(rm)){showTS(id,'wrong','输入不正确，请重新输入。',redcol);if(focusId=='')focusId=id;return 0;}}else if(str==''||!str.match(rm)){showTS('email','wrong','请输入正确的email。',redcol);if(focusId=='')focusId='email';return 0;}
if(str!=''){showTS(id,'ok','',greencol);}
return 1;}
function checkother(id, type, msg, de, sub,len) {
    var len = len ? len : 100;
	var str = $(id).value.trim();
	var relid = '';
	if(msg && msg == '验证码'){
		if(type == 1 && !de && (str == '' || str == '比如：12345')) {
			showTS(id, 'wrong', '您必须输入'+msg, redcol, sub);
			if(focusId == '') focusId = id;
			return 0;
		}
		if(type == 1 && !de && !/^(\d+)$/.test(str)) {
			showTS(id, 'wrong', msg+'必须为阿拉伯数字！', redcol, sub);
			if(focusId == '') focusId = id;
			return 0;
		}
	}else{
		if(type == 1 && !de && str == '') {
			showTS(id, 'wrong', '您必须输入'+msg, redcol, sub);
			if(focusId == '') focusId = id;
			return 0;
		}
	}
	if(type == 2 && str != '' && isNaN(str)) {
		showTS(id, 'wrong', msg+'应该为数字。', redcol, sub);
		if(focusId == '') focusId = id;
		return 0;
	}
	if(type == 3 && !de && (str == '' || isNaN(str))) {
		showTS(id, 'wrong', msg+'不能为空，并且必须为数字。', redcol, sub);
		if(focusId == '') focusId = id;
		return 0;
	}
	if(type == 5 && (str == '' || !isNaN(str) || checkstr(str)>len*2 || checkstr(str)<4)){
		showTS(id, 'wrong', msg+'不能为空，并且不能为数字,长度限制在2到'+len+'个汉字之间。', redcol, sub);
		if(msg=='职位名称' && document.getElementById('jobname_hidden')){
			document.getElementById('jobname_hidden').style.display="none";
		}
		if(focusId == '') focusId = id;
		return 0;
	}
	if(type == 6 && (str == '' || checkstr(str)>150 || checkstr(str)<4)){
		showTS(id, 'wrong', msg+'不能为空，长度限制在2到75个汉字之间。', redcol, sub);
		if(focusId == '') focusId = id;
		return 0;
	}
	if(type == 7 && str == 0){
		showTS(id, 'wrong', '您必须选择'+msg, redcol, sub);
		if(focusId == '') focusId = id;
		return 0;
	}
	if(type == 8 && !de) {
		if(str == '' || isNaN(str)){
			showTS(id, 'wrong', '请填写非0的数字，且不能为空！', redcol, sub);
			if(focusId == '') focusId = id;

			return 0;
		}
		else if((/([\+\-\.])+/.test(str)) || parseInt(str)==0){
			showTS(id, 'wrong', '请填写0以外的整数', redcol, sub);
			if(focusId == '') focusId = id;

			return 0;
		}else if(checkstr(str)>len){
			showTS(id, 'wrong', '长度不能超过'+len+'个数字', redcol, sub);
			if(focusId == '') focusId = id;

			return 0;
		}
	}
	if(type==9){
		relid = id;
		if(str ==0 ){
			showTS('extvalues_BIRTHDAY', 'wrong', '您必须选择'+msg, redcol, sub,relid);
			if(focusId == '') focusId = id;
			return 0;
		}
		id = 'extvalues_BIRTHDAY';
	}
	if(type==10){
		relid = id;
		showTS('extvalues_BIRTHDAY', 'ok', '', greencol, sub,relid);
		if(focusId == '') focusId = id;
		id = 'extvalues_BIRTHDAY';
	}
	if(type == 11 && !de) {
		if(str != ''){
			if(isNaN(str)){
				showTS(id, 'wrong', '请填写数字', redcol, sub);
				if(focusId == '') focusId = id;

				return 0;
			}
			else if((/([\+\-\.])+/.test(str)) || parseInt(str)==0){
				showTS(id, 'wrong', '请填写0以外的整数', redcol, sub);
				if(focusId == '') focusId = id;

				return 0;
			}else if(checkstr(str)>len){
				showTS(id, 'wrong', '长度不能超过'+len+'个数字', redcol, sub);
				if(focusId == '') focusId = id;

				return 0;
			}
		}
	}
	if (type == 12 && !de) { //special use for house 整套户型
		var room = $('extvalues_ROOM').value.trim();
		var roomhall = $('extvalues_ROOMHALL').value.trim();
		var roomtoilet = $('extvalues_ROOMTOILET').value.trim();
		if ($('extvalues_ROOMHUTCH')) {
		    id = 'extvalues_ROOMHUTCH';
		} else {
		    id = 'extvalues_ROOMTOILET';
		}
		str = $(id).value.trim();
		
		if (room == '' || isNaN(room) || room <1 || room.length > len){
		     showTS(id, 'wrong', '居室必须是数字并且不能为0！', redcol, sub, 'extvalues_ROOM');
		    if (focusId == '') focusId = 'extvalues_ROOM';
		    return 0;		
		}
		if (roomhall == '' || isNaN(roomhall) || roomhall <0 || roomhall.length > len){
		     showTS(id, 'wrong', '请填写数字', redcol, sub, 'extvalues_ROOMHALL');
		    if (focusId == '') focusId = 'extvalues_ROOMHALL';
		    return 0;		
		}
		if (roomtoilet == '' || isNaN(roomtoilet) || roomtoilet <0 || roomtoilet.length > len){
		     showTS(id, 'wrong', '请填写数字', redcol, sub, 'extvalues_ROOMTOILET');
		    if (focusId == '') focusId = 'extvalues_ROOMTOILET';
		    return 0;		
		}
		if (str == '' || isNaN(str) || str <0 || str.length > len){
		    showTS(id, 'wrong', '请填写数字', redcol, sub);
		    if (focusId == '') focusId = id;
		    return 0;
		}
		
	}
	if (type == 13 && !de) { //special use for house louceng
		var floorval = $('extvalues_FLOOR').value.trim();
		var floornumval = $('extvalues_FLOORNUM').value.trim();
		id = 'extvalues_FLOORNUM';
		if(len != 3992){
			if (floorval == '' || isNaN(floorval) || floornumval == '' || isNaN(floornumval)) {
			    showTS(id, 'wrong', '请填写数字', redcol, sub, 'extvalues_FLOOR');
			    if (focusId == '') focusId = id;
			    return 0;
			}
		}else{
			if (isNaN(floorval) || isNaN(floornumval)) {
			    showTS(id, 'wrong', '请填写数字', redcol, sub);
			    if (focusId == '') focusId = id;
			    return 0;
			}
		}
		len = 2;
		if ((/([\+\-\.])+/.test(floorval)) || parseInt(floorval) == 0 || (/([\+\-\.])+/.test(floornumval)) || parseInt(floornumval) == 0) {
		    showTS(id, 'wrong', '请填写0以外的整数', redcol, sub);
		    if (focusId == '') focusId = id;
		    return 0;
		} else if (checkstr(floorval) > len || checkstr(floornumval) > len) {
		    showTS(id, 'wrong', '长度不能超过' + len + '个数字', redcol, sub);
		    if (focusId == '') focusId = id;
		    return 0;
		} else if (floorval && floornumval && (parseInt(floorval) > parseInt(floornumval))) {
		    showTS(id, 'wrong', '总楼层不能小于所在楼层', redcol, sub);
		    if (focusId == '') focusId = id;
		    return 0;
		}
	}

	if(str!='') {
		showTS(id, 'ok', '', greencol, sub,relid);
	} else showTS(id, '', '', graycol, sub,relid);
	return 1;
}
function checkbirth(id,msg,flag){var birth_y=$('extvalues_BIRTHYEAR').value.trim();var birth_m=$('extvalues_BIRTHMONTH').value.trim();var birth_d=$('extvalues_BIRTHDAY').value.trim();if(flag){if(birth_y==0){showTS(id,'wrong','您必须选择'+msg,redcol,1,'extvalues_BIRTHYEAR');if(focusId=='')focusId='extvalues_BIRTHYEAR';return 0;}
if(birth_m==0){showTS(id,'wrong','您必须选择'+msg,redcol,1,'extvalues_BIRTHMONTH');if(focusId=='')focusId='extvalues_BIRTHMONTH';return 0;}
if(birth_d==0){showTS(id,'wrong','您必须选择'+msg,redcol,1,'extvalues_BIRTHDAY');if(focusId=='')focusId='extvalues_BIRTHDAY';return 0;}}else{if(birth_d!=0&&birth_m!=0&&birth_y==0){showTS(id,'wrong','您必须填写正确'+msg,redcol,1,'extvalues_BIRTHYEAR');if(focusId=='')focusId='extvalues_BIRTHYEAR';return 0;}else if(birth_d!=0&&birth_m==0){showTS(id,'wrong','您必须选择'+msg,redcol,1,'extvalues_BIRTHMONTH');if(focusId=='')focusId='extvalues_BIRTHYEAR';return 0;}else if(birth_d!=0&&birth_y==0){showTS(id,'wrong','您必须选择'+msg,redcol,1,'extvalues_BIRTHYEAR');if(focusId=='')focusId='extvalues_BIRTHYEAR';return 0;}else if(birth_d!=0&&birth_y!=0&&birth_m==0){showTS(id,'wrong','您必须选择'+msg,redcol,1,'extvalues_BIRTHMONTH');if(focusId=='')focusId='extvalues_BIRTHYEAR';return 0;}else if(birth_m!=0&&birth_y==0){showTS(id,'wrong','您必须选择'+msg,redcol,1,'extvalues_BIRTHYEAR');if(focusId=='')focusId='extvalues_BIRTHYEAR';return 0;}}
showTS(id,'ok','','',1,'');return 1;}
function getId(type,i,selectedindex){if(!$(type+i)){var spanObj=document.createElement("span");spanObj.id=type+i;spanObj.className='redfont';$('show_'+type).appendChild(spanObj);}
if(i==1){$(type+i).innerHTML=$(type+'['+i+']').options[selectedindex].text;}else{$(type+i).innerHTML='> '+$(type+'['+i+']').options[selectedindex].text;}
for(var j=i+1;j<=5;j++){if($(type+j))$(type+j).innerHTML='';}}
(function(){var a=!-[1,];var b=/webkit\/(\d+)/i.test(navigator.userAgent)&&(RegExp.$1<525);var c=[];var e=function(){for(var i=0;i<c.length;i++)c[i]()};var d=document;d.ready=function(f){if(!a&&!b&&d.addEventListener)return d.addEventListener('DOMContentLoaded',f,false);if(c.push(f)>1)return;if(a)(function(){try{d.documentElement.doScroll('left');e()}catch(err){setTimeout(arguments.callee,0)}})();else if(b)var t=setInterval(function(){if(/^(loaded|complete)$/.test(d.readyState))clearInterval(t),e()},0)}})();document.ready(function(){if(window.ED&&ED.mapLat&&ED.mapLng&&GBrowserIsCompatible){if(GBrowserIsCompatible()){var a=null;var b="map_canvas";a=new GMap2(document.getElementById(b));a.addControl(new GSmallMapControl());a.addControl(new GScaleControl());a.addControl(new GMenuMapTypeControl());var c=new GLatLng(ED.mapLat,ED.mapLng);a.setCenter(c,13);var d=new GMarker(c);a.addOverlay(d)}}});
function IsIEBrowser(){if(navigator.userAgent.indexOf("MSIE")!=-1){return true;}else{return false;}}
function addsubways(){var htmlcon=$('subwaycon');var num=$('totalsubway').value;var addbtn=$('addsubway');var subwaystr='';var extvalues=$('extvalues_SUBWAYSTATION');var extvaluesA=$('extvalues_SUBWAYSTATIONA');var total=htmlcon.childNodes.length;if(total>=4){addbtn.disabled=true;}else{var exttxt=extvalues.options[extvalues.selectedIndex].text;var extval=extvalues.options[extvalues.selectedIndex].value;var exttxtA=extvaluesA.options[extvaluesA.selectedIndex].text;var extvalA=extvaluesA.options[extvaluesA.selectedIndex].value;var subwayobj=document.createElement("li");if(IsIEBrowser()==true){subwayobj.setAttribute("id","showsubway"+num);}else{subwayobj.id="showsubway"+num;}
subwayobj.className='subway';subwayobj.style.paddingLeft="0px";htmlcon.appendChild(subwayobj);subwayobj.innerHTML='<label>'+exttxt+'&nbsp;&nbsp;&nbsp;&nbsp;'+exttxtA+'<input name="" type="button" onclick="deletesubway('+num+')" value="删除" class="deletebtn" /><input type="hidden" name="subwayval[]" value="'+extval+'" /><input type="hidden" name="subwayvalA[]" value="'+extvalA+'" /></label>';num++;$('totalsubway').value=num;if(total>=4)
addbtn.disabled=true;}
if(total>=3)
addbtn.disabled=true;}
function deletesubway(num){var addbtn=$('addsubway');var htmlcon=$('subwaycon');htmlcon.removeChild($("showsubway"+num));var total=htmlcon.childNodes.length;if(total>=4){addbtn.disabled=true;}else{addbtn.disabled=false;}}
function checkcheckbox(id,checkname,msg){var chk=false;var chakall=document.getElementsByName(checkname);for(i=0;i<chakall.length;i++){if(chakall[i].checked){chk=true;break;}}
if(!chk){showTS(id,'wrong','您必须选择'+msg,redcol,1,id);}else{showTS(id,'ok','',greencol,1,id);}
return 1;}
function zhaopintype(obj){var s=obj.value;if(s==2){document.getElementById('kaizhan').style.display="none";document.getElementById('meizhou').style.display="block";}else{document.getElementById('meizhou').style.display="none";document.getElementById('kaizhan').style.display="block";}}
function checkSearch(form,n,txt){if(typeof(txt)=='undefined'){txt='输入职位或公司名称'}
var kw=form;if(n==0){if(kw.value.trim()==''){kw.value=txt.trim();}}
if(n==1){if(kw.value.trim()==txt){kw.value='';}}}
 
_isIE6 = window.VBArray && !window.XMLHttpRequest;
_isMobile = 'createTouch' in document && !('onmousemove' in _elem);
var postpop = {
	docPx: function(elem, name) {
		return Math.max(
			elem.documentElement['client' + name],
			elem.body['scroll' + name], elem.documentElement['scroll' + name],
			elem.body['offset' + name], elem.documentElement['offset' + name]
		)
	},
	dialog: function() {
		var lockMaskWrap = document.getElementById('dialogCase');
		if (lockMaskWrap === null) {
			return 0;	
		}
		var docWidth = postpop.docPx(document, "Width"),
			docHeight = postpop.docPx(document, "Height"),			
			lockMask = lockMaskWrap && lockMaskWrap.children[1],
			domTxt = '(document).documentElement',
			sizeCss = _isMobile ? 'width:' + docWidth + 'px;height:' + docHeight + 'px' : 'width:100%;height:100%',
			ie6Css = _isIE6 ? 'position:absolute;left:expression(' + domTxt + '.scrollLeft);top:expression(' + domTxt + '.scrollTop);width:expression(' + domTxt + '.clientWidth);height:expression(' + domTxt + '.clientHeight)'			: '';
		lockMaskWrap.style.cssText = sizeCss + ';background:#000;filter:alpha(opacity=60);opacity:0.6;position:fixed;z-index:99999;top:0;left:0;overflow:hidden;' + ie6Css;
		lockMaskWrap.children[0].style.display = "none";
		
		lockMask.style.cssText = "position:static;width:100%;height:100%;background:url(http://img02.edeng.cn/images/fresh/loading1.gif?ver=13125) no-repeat center center";
		lockMask.innerHTML = '';
		
		// 让IE6锁屏遮罩能够盖住下拉控件
		if (_isIE6) {
			lockMask.innerHTML = '<iframe src="about:blank" style="width:100%;height:100%;position:absolute;top:0;left:0;z-index:-1;filter:alpha(opacity=0)"></iframe>';
		}
		lockMaskWrap.style.display = 'block';
	}
};

function checkphone(isempty,phonetype){var phonetype=$("phonetype").value;var isempty=isempty?isempty:0;switch(phonetype){case'1':var str=$('phone').value.trim();var n=str.length;if(!n&&isempty){showTS('phone','wrong','手机号码不能为空！',redcol);if(focusId=='')focusId='phone';return 0}if(n&&!(/^1[3|5|8|4|7][0-9]\d{8}$/.test(str))){showTS('phone','wrong','请填写正确的手机号码，号码应为11位数字！',redcol);if(focusId=='')focusId='phone';return 0}if(n>0){showTS('phone','ok','',greencol)}else{showTS('phone','','',graycol)}return 1;break;case'2':var landline0=$("landline0").value.trim();var landline1=$("landline1").value.trim();if(isempty&&(landline0=='区号'||!landline0.length)){setBorderColor($("landline0"),redcol);focusId='landline0';showTS('phone','wrong','区号，电话不能为空。','');return 0}if(isempty&&(landline1=='电话'||!landline1.length)){setBorderColor($("landline1"),redcol);focusId='landline1';showTS('phone','wrong','区号，电话不能为空。','');return 0}if(landline0.length&&!(/^[0-9]{1,4}$/.test(landline0))){setBorderColor($("landline0"),redcol);showTS('phone','wrong','电话号码填写错误，请填写正确的电话号码。','');return 0}if(landline1.length&&!(/^[0-9]{1,9}$/.test(landline1))){setBorderColor($("landline1"),redcol);showTS('phone','wrong','电话号码填写错误，请填写正确的电话号码。','');return 0}setBorderColor($("landline0"),greencol);setBorderColor($("landline1"),greencol);showTS('phone','ok','','');return 1;break;case'3':var specphone0=$("specphone0").value.trim();var specphone1=$("specphone1").value.trim();var specphone2=$("specphone2").value.trim();if(isempty&&!specphone0.length){setBorderColor($("specphone0"),redcol);focusId='specphone0';showTS('phone','wrong','电话不能为空。','');return 0}if(isempty&&!specphone1.length){setBorderColor($("specphone1"),redcol);focusId='specphone1';showTS('phone','wrong','电话不能为空。','');return 0}if(isempty&&!specphone2.length){setBorderColor($("specphone2"),redcol);focusId='specphone2';showTS('phone','wrong','电话不能为空。','');return 0}if(specphone0.length&&!(/^[0-9]{1,4}$/.test(specphone0))){setBorderColor($("specphone0"),redcol);showTS('phone','wrong','电话填写错误，请填写正确的电话号码。','');return 0}if(specphone1.length&&!(/^[0-9]{1,4}$/.test(specphone1))){setBorderColor($("specphone1"),redcol);showTS('phone','wrong','电话填写错误，请填写正确的电话号码。','');return 0}if(specphone2.length&&!(/^[0-9]{1,4}$/.test(specphone2))){setBorderColor($("specphone2"),redcol);showTS('phone','wrong','电话填写错误，请填写正确的电话号码。','');return 0}setBorderColor($("specphone0"),greencol);setBorderColor($("specphone1"),greencol);setBorderColor($("specphone2"),greencol);showTS('phone','ok','','');return 1;break}}function phone_operate(obj){$('phonetype').value=obj.value;switch($('phonetype').value){case'1':$('landline0').style.border='';$('landline1').style.border='';$('specphone0').style.border='';$('specphone1').style.border='';$('specphone2').style.border='';break;case'2':$('phone').style.border='';$('specphone0').style.border='';$('specphone1').style.border='';$('specphone2').style.border='';break;case'3':$('phone').style.border='';$('landline0').style.border='';$('landline1').style.border='';break}$("phonespan").className=""}
