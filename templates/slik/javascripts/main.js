

// VIEW CHANGING FUNCTIONS

function initializeViews (defView) {
	var icons_div = document.getElementById('icons-view');
	var details_div = document.getElementById('details-view');
	if (icons_div.innerHTML != '') {
		showIcons();
	} else if (details_div.innerHTML != '') {
		showDetails();
	} else if (defView == 'icons') {
		showIcons();
	} else if (defView == 'details') {
		showDetails();
	}
}

function showIcons (url) {
	document.getElementById('details-view').style.display = 'none';
	var div = document.getElementById('icons-view');
	if	(div.innerHTML == '') {
		ajax_updater('_icons.php', 'icons-view', 'loading');
	} else {
		div.style.display = 'block';
	}
	setImage('view-details', 'images/view-details.gif');
	setImage('view-icons', 'images/view-icons-active.gif');
}

function showDetails (url) {
	document.getElementById('icons-view').style.display = 'none';
	var div = document.getElementById('details-view');
	if	(div.innerHTML == '') {
		ajax_updater('_details.php', 'details-view', 'loading');
	} else {
		div.style.display = 'block';
	}
	setImage('view-details', 'images/view-details-active.gif');
	setImage('view-icons', 'images/view-icons.gif');
}


// MISC. FUNCTIONS

function divChange(whatDiv, fromClass, toClass) {
	var div = document.getElementById(whatDiv);
	if ( div.className == toClass ) { div.className = fromClass } else { div.className = toClass };
}

function goToURL(where) {
	document.location.href = where;
}

function setDiv(whatDiv, toClass) {
	document.getElementById(whatDiv).className = toClass;
}

function setImage(what, newSrc) {
	document.getElementById(what).src = newSrc;
}

function ajax_updater(url, target, msgbox) {
	new Ajax.Updater(target, url,
		{
			method:'get',
			asynchronous:true,
			evalScripts:true,
			onComplete:function(){ new Effect.Fade(msgbox, {queue:{scope:'ajax', position:'end'}}); new Effect.BlindDown(target, {queue:{scope:'ajax', position:'end'}});},
			onLoading:Effect.Appear(msgbox, {queue:{scope:'ajax', position:'end'}})
		}
	);
}


/* POPUP FUNCTIONS */
function iP (el, img) {
	if (img) var append = '<div class="preview"><img src="' + img + '" /></div>';
	else var append = '';
	ol_relx = null;
	return overlib(document.getElementById('p'+el).innerHTML + append);
}
function dP (el, img) {
	if (img) var append = '<img src="' + img + '" />';
	ol_relx = 46;
	return overlib(document.getElementById('d'+el).innerHTML+ append);
}
function o () {
	return nd();
}

function dH(item) {
	item.className = 'ih';
}
function dO(item, whatclass) {
	item.className = whatclass;
}



