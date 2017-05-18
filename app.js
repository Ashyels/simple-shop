// Set master UI background color
Ti.UI.backgroundColor = '#000';

// Set vars
var winMain,
vwWebMain,
lblValue,
vwBtn;

// Set global event listener as Firebase callback
Ti.App.addEventListener('fireBaseCallback', function(e){
	Ti.App.info('Firebase message: ' + e.message);
	lblValue.text = e.message;
});

// Initialize main window
winMain = Ti.UI.createWindow({
	backgroundColor: 'blue'
});

// Load webview (with Firebase-infused goodness)
vwWebMain = Ti.UI.createWebView({
	url: Ti.Filesystem.resourcesDirectory + 'firebase.html',
	width: 1,
	height: 1,
	visible: false	// This will simply act as our Firebase vehicle so no need to show it
});

// Label to show the latest value
lblValue = Ti.UI.createLabel({
	text: 'Default text',
	width: 'auto',
	height: 'auto',
	font: {
		fontSize: 18
	},
	color: '#fff'
});

// Button to retrieve the latest value
vwBtn = Ti.UI.createView({
	width: 100,
	height: 100,
	backgroundColor: '#fff',
	top: 10,
	left: 10
});

vwBtn.addEventListener('click', function(e){
	var sLatestValue = vwWebMain.evalJS('sValue');
	alert('Latest value: ' + sLatestValue);
});

// Consolidate views
winMain.add(vwWebMain);
winMain.add(lblValue);
winMain.add(vwBtn);

// Open window
winMain.open();