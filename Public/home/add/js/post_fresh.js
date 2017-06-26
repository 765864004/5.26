var $$ = function(id) {
	return 'string' == typeof id ? document.getElementById(id) : id;
};


String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/g, "");
};
// Browser
var $B = (function(ua) {
	var b = {
		msie : /msie/.test(ua) && !/opera/.test(ua),
		opera : /opera/.test(ua),
		safari : /webkit/.test(ua) && !/chrome/.test(ua),
		firefox : /firefox/.test(ua),
		chrome : /chrome/.test(ua)
	};
	var vMark = "";
	for ( var i in b) {
		if (b[i]) {
			vMark = "safari" == i ? "version" : i;
			break;
		}
	}
	b.version = vMark && RegExp("(?:" + vMark + ")[\\/: ]([\\d.]+)").test(ua) ? RegExp.$1
			: "0";

	b.ie = b.msie;
	b.ie6 = b.msie && parseInt(b.version, 10) == 6;
	b.ie7 = b.msie && parseInt(b.version, 10) == 7;
	b.ie8 = b.msie && parseInt(b.version, 10) == 8;

	return b;
})(window.navigator.userAgent.toLowerCase());

/* DOM */
var $D = {
	getScrollTop : function(node) {
		var doc = node ? node.ownerDocument : document;
		var body = doc.documentElement || doc.body;
		return body.scrollTop;
	},
	getScrollLeft : function(node) {
		var doc = node ? node.ownerDocument : document;
		return doc.documentElement.scrollLeft || doc.body.scrollLeft;
	},
	getDocWidth : function() {
		var doc = document.documentElement || document.body;
		return doc.scrollWidth;
	},
	nowStyle : function(elem) {
		return document.defaultView ? document.defaultView.getComputedStyle(
				elem, null) : elem.currentStyle;
	},
	rect : function(node) {
		var left = 0, top = 0, right = 0, bottom = 0;
		// ie8的getBoundingClientRect获取不准确。 不仅 IE8，IE都不准，换用 offset 累加的方式。仔细测发现
		// getBoundingClientRect 在某些浏览器可以精确到小数，但 offset 累加只能整数。
		// TODO IE6 还有1像素的错位
		if (!node.getBoundingClientRect || $B.ie) {
			var n = node;
			while (n) {
				left += n.offsetLeft;
				top += n.offsetTop;
				n = n.offsetParent;
			}
			;
			right = left + node.offsetWidth;
			bottom = top + node.offsetHeight;
		} else {
			var rect = node.getBoundingClientRect();
			left = right = this.getScrollLeft(node);
			top = bottom = this.getScrollTop(node);
			left += rect.left;
			right += rect.right;
			top += rect.top;
			bottom += rect.bottom;
		}
		;
		return {
			"left" : left,
			"top" : top,
			"right" : right,
			"bottom" : bottom
		};
	}
};

var ed = {};
ed.setting = {
	menu: "nav",
	submenu: "submenu",
	inforsearch: "mysearch",
	history: "history",
	key: "keyword",
	keyword: "请输入关键字查找您要发布的分类",
	lastNavId: 0,
	lastSubId: 0,
	lastBoxId: 0,
	step: "step",
//	step1: "index.html",
//	step2: "step2.html"
	step1: "choice_cat_geo2.php",
	step2: "post_msg2.php"
}
ed.fn = {
	getId: function(name) {
		var str = window.location.search.split("&"),
			id = 0;
		for (var i in str) {
			if (str[i].indexOf(name+"=") > -1) {				
				id = str[i].split("=")[1];		
				break;
			}
		}
		return id;
	},
	getCattrace: function() {
		return ed.fn.getId("cattrace");
	},
	getGeotrace: function() {
		return ed.fn.getId("geotrace");
	},
	getLevel: function(id) {
		var level = [];
		while (id != 0) {			
			level.unshift(id);
			id = $CAT[id].t;
		}
		return level;
	},
	getSon: function(pid) {
		var son = [];
		for (var i in $CAT) {
			if ($CAT[i].t == pid) {
				son.push($CAT[i].i);					
			}
		}
		return son;
	},
	getPid: function(id) {
		id = $CAT[id]&&$CAT[id].t || -1; 
		return id;
	},
	findCatByName : function(name) {
		var ret = [];
		for ( var i in $CAT) {
			if ($CAT[i].n.indexOf(name) > -1) {
				var cat = $CAT[i];
				var out = [{"i":i,"n":cat.n,"c":0}];
				this.findParentById(cat, out)
				ret.push(out);
			}
		}
		return ret;
	},
	findParentById : function(cat, out) {
		if (cat != null && cat.t != 0) {
			var parent = this.findCatById(cat.t);
			out.unshift(parent);
			this.findParentById(parent, out);
		}
	},
	findCatById : function(id) {
		return $CAT[id] == undefined?null:$CAT[id];
	}
}

ed.step = function(step) {
	var index = 1,
		html = '';
	for (; index <= 3; index++) {
		html += '<span' + (index == 2 ? ' class="mid"' : '') + '>';
		if (index < step) {	
			var cattrace = ed.fn.getCattrace().split(",")[1],
				geotrace = ed.fn.getGeotrace();
			html += '<a href="' + (ed.setting.step1 + "?cmd=insert&cattrace=" + cattrace + "&geotrace=" + geotrace) + '"></a>';	
		}
		html += '</span>';			
	}
	$$(ed.setting.step).innerHTML = html;
	$$(ed.setting.step).className = "wrap step step" + step;
	ed.lastpublish(step);
}

ed.choice = function(id) {
	var myson = ed.fn.getSon(id);
	if (myson.length == 0) {
		var level = ed.fn.getLevel(id),
			cattrace = level.reverse().join(",");		
		//alert( ed.setting.step2 + "?cmd=insert&cattrace=" + cattrace + "&geotrace=" + ed.fn.getGeotrace() + "&step2=" + ed.fn.getPid(id))
		window.location = ed.setting.step2 + "?cmd=insert&cattrace=" + cattrace + "&geotrace=" + ed.fn.getGeotrace() + "&cat=" + id + "&step2=" + ed.fn.getPid(id);
	} else if ($CAT[id].t == 0){
		ed.submenu(id, myson);
	} else {
		ed.box(id, myson);			
	}
}

ed.menu = function(id) {	
	var html = "",
		k = 1,
		curr = !$CAT[id] ? 1 : ed.fn.getLevel(id)[0],
		menu = ed.fn.getSon(0);
	for (var i=0; i<menu.length; i++) {		
		var cat = $CAT[menu[i]];
			html += '<li' + (curr == cat.i ? ' class="curr"' : '') + (i==-1?' style="border-top:0"': (i==menu.length? ' style="border-bottom:0"' : '')) + ' id="ed_nav_' + cat.i + '"><a hidefocus href="javascript:;" onclick="ed.submenu(' + cat.i + ')"><s></s>'+ cat.n +'</a></li>';
	}
	ed.setting.lastNavId = "ed_nav_" + curr;
	$$(ed.setting.menu).innerHTML = html;
};
ed.submenu = function(id, myson) {
	$$(ed.setting.lastNavId).className = '';
	$$("ed_nav_" + id).className = 'curr';
	ed.setting.lastNavId = "ed_nav_" + id;
	
	ed.setting.lastSubId = id;	
	if (myson == undefined) {
		myson = ed.fn.getSon(id);
	}
	var html = '',
		last = '';
	for (var i=0; i<myson.length; i++) {
		var _html = '',
			_cat  = $CAT[myson[i]];
		for (var j in $CAT) {
			if ($CAT[j].t == _cat.i) {
				_html += '<dd id="ed_' + $CAT[j].i + '"><a' + ($CAT[j].c != undefined ? ' class="color' + $CAT[j].c + '"' : '') +' href="javascript:;" onclick="ed.choice(' + $CAT[j].i + ')">' + $CAT[j].n + '</a></dd>';
			}
		}
		if (_html.length == 0) {
			_html += '<dd id="ed_' + _cat.i + '"><a' + (_cat.c != undefined ? ' class="color' + _cat.c + '"' : '') +' href="javascript:;" onclick="ed.choice(' + _cat.i + ')">' + _cat.n + '</a></dd>'	
		}	
		if (_cat.n.indexOf("\u5176\u4ED6") > -1) {
			last = 	'<dl><dt id="ed_' + _cat.i + '">' +_cat.n + '</dt>' + _html + '</dl>';
		} else {
			html += '<dl><dt id="ed_' + _cat.i + '">' +_cat.n + '</dt>' + _html + '</dl>';
		}
	}
	
	var submenu = $$(ed.setting.submenu);
	submenu.style.height = "auto";
	submenu.innerHTML = html + last;
	
	var h1 = submenu.offsetHeight;
		h2 = $$(ed.setting.menu).offsetHeight;
	h1 = Math.max(h1, h2);
	
	submenu.style.height = h1 + "px";
}

ed.box = function(id, myson) {	
	if ($$(ed.setting.lastBoxId)) {
		$$(ed.setting.lastBoxId).style.display = "none";
	}

	var level = ed.fn.getLevel(id),
		lastBoxId = "ed_" + id + "_ul";			
	ed.setting.lastBoxId = lastBoxId;
	if (ed.setting.lastSubId != level[0]) {
		ed.submenu(level[0], ed.fn.getSon(level[0]));
	}  	
	if (level.length == 2) {
		var el = $$("ed_"+id).parentNode,
			top = $D.rect(el).top;
		el.className = "highlight";
		window.scrollTo(0,top);
		return false;	
	} else {
		$$("ed_"+id).parentNode.removeAttribute("class");
	}
	
	var	ul = $$(lastBoxId);
	if (ul == null) {
		var dd = $$("ed_" + id),
			div = $$(ed.setting.submenu),
			xy1 = $D.rect(dd),
			xy2 = $D.rect(div),
			style1 = '',
			style2 = '',
			html = '',
			left = '<div class="div_dl_left">',
			right = '<div class="div_dl_right">',
			html = '',
			cat = [];
			
		ul = document.createElement("ul");
		ul.id = lastBoxId;
		dd.className = "dialog";
		dd.appendChild(ul);
		dd.style.position = "relative";
		for (var i in myson) {
			cat = $CAT[myson[i]];
			html += '<li><a href="javascript:;" onclick="ed.choice(' + cat.i + ')">' + cat.n + '</a></li>';	
		}
		ul.innerHTML = html + '<li class="close" onclick="ed.hide(this)"></li>';				
		if (xy1.left - xy2.left + ul.offsetWidth < div.offsetWidth) {
			style1 += 'left:0px;';
			style2 += 'left:' + (dd.offsetWidth - 19)/2 + 'px;';
		} else {
			style1 += 'right:0px;';
			style2 = 'right:' + (dd.offsetWidth - 19)/2 + 'px;';
		}
		if (xy1.top - xy2.top + ul.offsetHeight < div.offsetHeight) {
			style1 += 'top:28px;';
			style2 += 'top:-7px;background-position:0 -4px';
		} else {
			style1 += 'bottom:28px;';
			style2 += 'bottom:-7px;';
		}		
		var li = document.createElement("li");
		li.style.cssText = style2;
		li.className = "arrow";		
		ul.style.cssText = style1;
		ul.appendChild(li)			
	} else {
		ul.style.display = "block";	
	}
	
	var top = $D.rect(ul.parentNode).top;
	window.scrollTo(0,top);
}
ed.hide = function(el) {
	el.parentNode.style.display = "none";
}

ed.hideSearch = function() {
	$$(ed.setting.inforsearch).style.display = "none";
};
ed.searchCat = function(){
	var val = $$(ed.setting.key).value.trim(),
		html = '',
		cat = [],
		inforsearch = $$(ed.setting.inforsearch);
	if (val.length > 0 && val != ed.setting.keyword) {
		var linkseparator = ' -&gt; ';
		cat = ed.fn.findCatByName(val);
		html += '<h4 class="gray"><a class="fr" href="javascript:void(0);" onclick="ed.empty()">清空</a>\u627E\u5230\u4E0E\u201C<span class="redfont">' + val + '</span>\u201D\u76F8\u5173\u7684\u5206\u7C7B\u5171' + cat.length + '\u4E2A:</h4><ul>';
		if (cat.length > 0) {
			for (var i = 0; i < cat.length; i++) {
				html += '<li' + (i%2==0? ' class="keyover"' : '') + '><em>' + (i+1) + ".</em>";
				for (var j = 0; j < cat[i].length; j++) {
					html += '<a href="javascript:void(0);" onclick="ed.choice(' + cat[i][j].i + ');ed.hideSearch();">'+cat[i][j].n.replace(val,'<b>'+val+'</b>')+'</a> -&gt; ';
				}
				html = html.substr(0, html.length - 7) + '<i onclick="ed.hide(this)"></i></li>';
			}
			html += "</ul>";
			if(ed.cookie.get("recore") != "") {
				val = val + "," + ed.cookie.get("recore");
			}
			ed.cookie.add("record", val, 60);
		} else {
			html = '<h4 class="gray"><a class="fr" href="javascript:void(0);" onclick="ed.empty()">清空</a>\u62B1\u6B49\uFF0C\u6CA1\u6709\u627E\u5230\u4E0E\u201C<span class="redfont">'+val+'</span>\u201D\u76F8\u5173\u7684\u7C7B\u522B\u3002</h4>';
		}
	} else {
		inforsearch.style.display = "none";
		return false;
	}
	inforsearch.innerHTML = html;
	inforsearch.style.display = "block";
};
ed.empty = function() {
	$$(ed.setting.key).value = "";
	$$(ed.setting.key).focus();	
	ed.hideSearch();
}
ed.keyBlur = function(o){
	if(o.value == ""){
		o.value = ed.setting.keyword;
		o.style.color = "#ccc";
	}
};
ed.keyClick = function(o){
	if(o.value == ed.setting.keyword){
		o.value = "";		
	}
	o.style.color = "#333";
	ed.searchCat();
};
ed.keyDown = function(o) {
	var e = o.keyCode ? o.keyCode : o.which;
	switch(e){
		case 13: // enter
			ed.searchCat();
			break;
		case 27:
			$("#mysearch1").hide();				
			break;
		default:
			//ed.searchCat();
		// no default
	}
};
ed.keyUp = function(o) {
	var e = o.keyCode ? o.keyCode : o.which;
    if (e==38 || e==40 || e==13 || e==27){
       return null;
	}
	ed.searchCat();
}

ed.gotop = function(id) {
	var el = $$(id);
	if (el) {
		var t = function() {
			el.style.display = ((document.documentElement.scrollTop + document.body.scrollTop) == 0) ? "none": "block"	
		};
		el.onclick = function() {
			window.scrollTo(0, 0);
			t()
		};
		window.onscroll = t	
	}
}

ed.lastpublish = function(step) {
	if (step == 1) { //读
		var cattrace = ed.cookie.get("lastpublish");
		if (cattrace != "") {
			var cookies = cattrace.split(","),
				cid = cookies[cookies.length-1],
				html = '<span>根据历史记录，您是否要发布信息到：</span><span>';
			for (var i = cookies.length-1; i >= 0; i--) {
				cid = cookies[i];
				html += '<a hidefocus href="javascript:;" onclick="ed.choice(' + cid + ')">' + $CAT[cid].n + '</a>' + (i == 0 ? '' : ' &gt; ') + '';
			}
			html += '</span><span class="close" onclick="ed.hide(this)" title="关闭"></span>';
			$$(ed.setting.history).innerHTML = html;
			$$(ed.setting.history).style.display = "block";
		} else {			
			$$(ed.setting.history).style.display = "none";
		}
	} else if (step == 2) { //存			
		var cattrace = ed.fn.getCattrace();
		ed.cookie.add("lastpublish", cattrace, 60);
	}
}

ed.cookie  = {
	loca: window.location.host,
	add: function(name, value, expiredays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + expiredays);
		document.cookie = name + "=" + escape(value)+ ((expiredays==null) ? "" : ";expires=" + exdate.toGMTString()) + ";domain="+this.loca+";path=/";	
	},
	get: function(name) {
		var cookies = document.cookie.split("; ");
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].split("=");
            if (cookie[0] == name) {
                return decodeURI(unescape(cookie[1]));
            }
        }
        return "";
	},
	del: function(name) {
		var exdate = new Date();
        exdate.setDate(exdate.getDate() - 1);
        document.cookie = name + "=overdue;domain="+this.loca+";path=/;expires=" + exdate.toGMTString();
	}	
}
ed.dialog = function() {
	document.body.onclick = function(e) {
		var e = e || window.event,
			elem = e.target || e.srcElement,
			submenu = $$(ed.setting.lastBoxId);
		while (elem) {
			if (elem.className && elem.className.indexOf('dialog')>-1) {
				return;
			}
			elem = elem.parentNode;
		}
		$$(ed.setting.inforsearch).style.display = "none";
		if(submenu) {
			submenu.style.display = "none";
		}
	}	
}

ed.init = function() {
	var step = window.location.search.indexOf("step2=");
	if (step >= 0) {
		step = 2	
	} else {
		step = 1;		
	}
	ed.step(step);
	if (step == 1) {
		var id = ed.fn.getCattrace();
		if (id == 0) {
			id = 1;
		} else {
			id = id.split(",")[0];
		}
		try{
			id = !$CAT[id] ? 1 : id;
		}catch(e){
			id = 1;
		}
		ed.menu(id);
		ed.choice(id);
		ed.dialog();		
	} else {
		//edengGeo.init();	
	}
	ed.gotop("gotopbtn");
}

function _addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function() {
			oldonload();
			func();
		}
	}
}
_addLoadEvent(ed.init)
