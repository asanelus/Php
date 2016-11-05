/**
 * 
 */
var g = {};

function addEvent(obj, type, fn) {
	if(obj.addEventListener) {
		obj.addEventListener(type, fn, false);
	}
	else if (obj.attachEvent) {
		obj.attachEvent('on' + type, fn);
	} else {
		alert('Your browser is not compatible with this site. ' + 
			'Consider using Google Chrome, Mozilla Firefox, or ' +
			'Internet Explorer 9 and up.');
	}
}

function preventDefaultSubmit(e) {
	if(e.preventDefault) {
		e.preventDefault();
	}	else {
		e.returnValue = false;
	}
	return false;
}

function registerLogoutButton(e) {
	var logoutBtn = document.getElementById('logout-btn');
	// Redirects the page to home controller's logout function
	window.location.href = "home/logout";
}

function init() {
	addEvent(document.getElementById('logout-btn'), 'mousedown', registerLogoutButton);
}
addEvent(window, 'DOMContentLoaded', init);