;;;var iterate = function (obj){var	s="遍历对象"+obj+"的属性：\n";	for(var i in obj)	s+=i+":"+obj[i]+"\n<br />";	return s;};
var $GEO_NAME= '';
String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, "");
};

/*Object*/
var $$ = function (id) {
	return 'string' == typeof id ? document.getElementById(id) : id;
};
;;;var iterate = function (obj){var	s="遍历对象"+obj+"的属性：\n";	for(var i in obj)	s+=i+":"+obj[i]+"\n<br />";	return s;};

String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, "");
};

/*Object*/
var $$ = function (id) {
	return 'string' == typeof id ? document.getElementById(id) : id;
};
var edengGeo = {
	load: 0,
	args : {},
	geo_id : 0,
	parseArgs : function(query) {
		var pairs = query.split("&"); // Break at ampersand
		for ( var i = 0; i < pairs.length; i++) {
			var pos = pairs[i].indexOf('='); // Look for "name=value"
			if (pos == -1)
				continue; // If not found, skip
			var argname = pairs[i].substring(0, pos); // Extract the name
			var value = pairs[i].substring(pos + 1); // Extract the value
			value = decodeURIComponent(value); // Decode it, if needed
			this.args[argname] = value; // Store as a property
		}
	},
	getArg : function(arg) {
		return this.args[arg] ? this.args[arg] : null;
	},
	getQueryString : function(val) {
		var uri = window.location.search;
		var re = new RegExp("" + val + "=([^&?]*)", "ig");
		return ((uri.match(re)) ? decodeURIComponent(uri.match(re)[0].substr(val.length + 1))
				: null);
	},
	getLevel: function(id) {
		var level = [];
		while (id != 0) {			
			level.unshift(id);
			id = $GEO[id].t;
		}
		return level;
	},
	findGeoByPid : function (pid){
		var ret = [];
		for(var i in $GEO){
			if($GEO[i].t == pid){
				ret.push($GEO[i]);
			}
		}
		return ret;
	},
	findGeoTraceById : function (id){
		var ret = [];
		var geo = edengGeo.findGeoById(id);
		if(geo != null){
			ret.unshift(geo);
			edengGeo.findGeoParentByGeoC(geo, ret);
		}
		return ret;
		
	},
	findGeoParentByGeo : function(geo){
		if(geo != null && geo.t != 1){
			return edengGeo.findGeoById(geo.t);
		}
		return null;
	},
	findGeoParentByGeoC : function(geo, ret){
		var parent = edengGeo.findGeoParentByGeo(geo);
		if(parent != null){
			ret.unshift(parent);
			edengGeo.findGeoParentByGeoC(parent, ret);
		}
	},
	findGeoById : function(id){
		return $GEO[id] == undefined?null:$GEO[id];
	},
	gennerOptions : function(geos){
		var options = [];
		options.push(new Option("请选择", -1));
		for(var k in geos){
			options.push(new Option(geos[k].n, geos[k].i));
		}
		return options;
	},
	choiceValue : function(obj, value) {
		for(var i = 0; i < obj.options.length; i++){
			var v = obj.options[i].value;
			if(v == value){
				obj.options[i].selected = true;
				break;
			}
		}
	},
	choice : function(obj){
		edengGeo.geo_id = 0;
		var value = arguments[1] ? arguments[1] : null; 
		if(value == null){
			index = obj.selectedIndex;
			value = obj.options[index].value;
		}else{
			edengGeo.choiceValue(obj, value);
		}
		edengGeo.clearNextOpts(obj);
		var slt = edengGeo.gennerSlt(value);		
		if(slt != null){
			var span = document.createElement("span");
			span.style.width = "5px";
			span.innerHTML = "&nbsp;";
			obj.parentNode.appendChild(span);
			obj.parentNode.appendChild(slt);
		}else{
			edengGeo.geo_id = value;
		}
		$$("geo_id").value = edengGeo.geo_id;
		if (edengGeo.load == 1)
		{
			var level = edengGeo.getLevel(value);
			$GEO_NAME = '';
			for	(var i in level) {
				$GEO_NAME += $GEO[level[i]].n;	
			}
			var exdate = new Date();
			exdate.setDate(exdate.getDate() + 60);
			var _lastGeo = level.reverse().join(",");
			document.cookie = "lastGeo=" + escape(_lastGeo)+ ";expires=" + exdate.toGMTString() + ";domain="+window.location.host+";path=/";	
		} else {
			try{
				var level = edengGeo.getLevel(value);
				$GEO_NAME = '';
				for	(var i in level) {
					$GEO_NAME += $GEO[level[i]].n;	
				}
			}catch(e){}
		}
		
		return slt;
	},
	clearNextOpts : function(obj){
		var opts = obj.parentNode.childNodes;
		var bA = false;
		for(var k = 0; k < opts.length; k++){
			if(bA){
				opts[k].parentNode.removeChild(opts[k]);
				k--;
			}
			if(opts[k] == obj){
				bA = true;
			}
		}
	},
	gennerSlt : function (pid){
		var cats = edengGeo.findGeoByPid(pid);
		if(cats.length == 0){
			return null;
		}
		var opts =  edengGeo.gennerOptions(cats);
		var slt = document.createElement("select");
		slt.className = "yangshi";
		slt.style.height = "26px";
		slt.onchange = function(){
			edengGeo.choice(this)
		};
		edengGeo.boundOpts(slt, opts);
		return slt;
	},
	boundOpts : function (slt, opts){
		for(var k in opts){
			slt.options.add(opts[k]);
		}
		return slt;
	},
	boundDefault : function (){
		var geos = edengGeo.findGeoByPid(1);
		edengGeo.boundOpts($$("province"), edengGeo.gennerOptions(geos));
	},
	history : function(){
		var cookies = document.cookie.split("; "),
			_lastGeo = null;
		for (var i = 0; i < cookies.length; i++) {
			var cookie = cookies[i].split("="),
				cid = 1,
				html = '';
			if (cookie[0] == "lastGeo") {
				_lastGeo = decodeURI(unescape(cookie[1]));	
				break;			
			}
		}
		if (_lastGeo != null)
		{
			var cookies = _lastGeo.split(","),
				cid = 1,
				html = '<span>您上次发布的地区:</span><span>';
			for (var i = cookies.length-2; i>=0; i--) {
				cid = cookies[i];
				html += '<a href="javascript:;" onclick="edengGeo.init(' + cid + ')">' + $GEO[cid].n + '</a>' + (i == 0 ? '' : ' &gt; ');
			}
			//html += '<span> (这里保存您最近一次发步信息的地区信息，点击名称可以直接选中当前地区)</span></li>';
			html += '</span><span class="close" onclick="ed.hide(this)" title="关闭"><span>';
			$$("history").innerHTML = html;
			$$("history").style.display = "block";
		} else {
			$$("history").style.display = "none";
		}
	},
	init : function(){
		try{
			var geotrace = edengGeo.getQueryString("geotrace");
			var lastGeo = 1;
			if(geotrace != null){
				geos = geotrace.split(",");
				lastGeo = parseInt(geos[0]);
			}
			if(isNaN(lastGeo) || lastGeo <= 0){
				lastGeo = 1;
			}
			lastGeo = arguments[0] ? arguments[0] : lastGeo; 
			if(lastGeo == 1){
				edengGeo.boundDefault();
			}else{
				var geos = edengGeo.findGeoTraceById(lastGeo);
				if(geos.length == 0){
					edengGeo.boundDefault();
					return;
				}
				var topObj = $$("province");
				for(var k = 0; k< geos.length; k++){
					var geo = geos[k];
					var gs = [];
					gs = edengGeo.findGeoByPid(geo.t);
					edengGeo.boundOpts(topObj, edengGeo.gennerOptions(gs));
					topObj = edengGeo.choice(topObj, geo.i);
				}
			}
		}catch(e){
			edengGeo.boundDefault();
		}
		if (edengGeo.load == 0)
		{
			edengGeo.history();
		}
		edengGeo.load = 1;

	}
};