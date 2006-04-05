
function set_view (view) {
	if (view != readCookie('dList_simple_viewMode')) {
		createCookie('dList_simple_viewMode', view, 365);
		document.location.href = '';
	}
}

function set_lang (lang) {
	if (lang != readCookie('dList_language')) {
		createCookie('dList_language', lang, 365);
		document.location.href = '';
	}
}

/* Cookie Related Functions */
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	} else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name) {
	createCookie(name,"",-1);
}