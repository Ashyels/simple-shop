<!-- Web-based app example -->
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Firebase</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

	<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>

<script>
	// Initialize Firebase
	var config = {
		apiKey: "AIzaSyAuEOy7PmZKtgpiGZXkYziJos9SBcTDqsQ",
		authDomain: "simpleshop-89516.firebaseapp.com",
		databaseURL: "https://simpleshop-89516.firebaseio.com",
		projectId: "simpleshop-89516",
		storageBucket: "simpleshop-89516.appspot.com",
		messagingSenderId: "224762672525"
	};
	firebase.initializeApp(config);
</script>
	
	</head>

<body>
<div style="display:inline-block;">
	<p>Total Item = </p>
</div>
<div style="display:inline-block;">
	<p id="itemTotal"></p>
</div>
<br>
<div style="display:inline-block;">
	<p id="buyTotal"></p>
</div>

<div>
	<input type="button" value="Show Item" id="showItem" />
	<br>
	<br>
    <input value="0" type="text" placeholder="value" id="valueTxt" />
	<p>Not Race Condition</p>
    <input type="button" value="Buy Item" id="buyBtn" />
    <input type="button" value="Supply Item" id="supplyBtn" />

	<br>
	<p>Race Condition</p>
    <input type="button" value="Buy Item" id="buyBtnRC" />
    <input type="button" value="Supply Item" id="supplyBtnRC" />
	
</div>

<?php

/* MENGGUNAKAN TRANSACTION() */
	try {
		echo "
		<script type=\"text/javascript\">
			$(document).ready(function() {
				
				var sI = $('#showItem');
				var bB = $('#buyBtn');
				var sB = $('#supplyBtn');
				var bBRC = $('#buyBtnRC');
				var sBRC = $('#supplyBtnRC');
				var database = firebase.database();
				
				sB.click(function () {

					var itemRef = firebase.database().ref();
					itemRef.transaction(function(currentData) {
						if (currentData === null) {
							database.ref('/item/').once('value').then(function(snapshot) {
								var value = snapshot.val().quantity;
								document.getElementById(\"itemTotal\").innerHTML = value + parseInt(document.getElementById(\"valueTxt\").value);
								firebase.database().ref('item/').set({
									name: 'laptop',
									quantity: value + parseInt(document.getElementById(\"valueTxt\").value)
								});

								return {
									item: {name: 'laptop', quantity: value+parseInt(document.getElementById(\"valueTxt\").value) } 
								};
							});
						} else {
							console.log('quantity race condition.');
							return; // Abort the transaction.
						}
					}, function(error, committed, snapshot) {
						if (error)
							console.log('Transaction failed abnormally!', error);
						else if (!committed)
							console.log('We aborted the transaction (because quantity race condition).');
						else
							console.log('User quantity added!');
						console.log('Laptop\'s data: ', snapshot.val());
					});
						
				});

				sI.click(function () {
					database.ref('/item/').once('value').then(function(snapshot) {
					  var value = snapshot.val().quantity;
					 	document.getElementById(\"itemTotal\").innerHTML = value;
					});
			
				});

				bB.click(function () {
					
					var itemRef = firebase.database().ref();
					itemRef.transaction(function(currentData) {
						if (currentData === null) {
							database.ref('/item/').once('value').then(function(snapshot) {
								var value = snapshot.val().quantity;
								if(value >= parseInt(document.getElementById(\"valueTxt\").value)){
									document.getElementById(\"itemTotal\").innerHTML = value - parseInt(document.getElementById(\"valueTxt\").value);
									firebase.database().ref('item/').set({
										name: 'laptop',
										quantity: value - parseInt(document.getElementById(\"valueTxt\").value)
									});									
								}
								else
									alert(\"Item Total is insufficient\");
								return {
									item: {name: 'laptop', quantity: value - parseInt(document.getElementById(\"valueTxt\").value) } 
								};
							});
						} else {
							console.log('quantity race condition.');
							return; // Abort the transaction.
						}
					}, function(error, committed, snapshot) {
						if (error)
							console.log('Transaction failed abnormally!', error);
						else if (!committed)
							console.log('We aborted the transaction (because quantity race condition).');
						else
							console.log('User quantity added!');
						console.log('Laptop\'s data: ', snapshot.val());
					});
						
				});

				sBRC.click(function () {
					database.ref('/item/').once('value').then(function(snapshot) {
						var value = snapshot.val().quantity;
						document.getElementById(\"itemTotal\").innerHTML = value + parseInt(document.getElementById(\"valueTxt\").value);
						firebase.database().ref('item/').set({
							name: 'laptop',
							quantity: value + parseInt(document.getElementById(\"valueTxt\").value)
						});

						return {
							item: {name: 'laptop', quantity: value+parseInt(document.getElementById(\"valueTxt\").value) } 
						};
					});					
				});
				
				bBRC.click(function () {
					database.ref('/item/').once('value').then(function(snapshot) {
						var value = snapshot.val().quantity;
						if(value >= parseInt(document.getElementById(\"valueTxt\").value)){
							document.getElementById(\"itemTotal\").innerHTML = value - parseInt(document.getElementById(\"valueTxt\").value);
							firebase.database().ref('item/').set({
								name: 'laptop',
								quantity: value - parseInt(document.getElementById(\"valueTxt\").value)
							});									
						}
						else
							alert(\"Item Total is insufficient\");
						return {
							item: {name: 'laptop', quantity: value - parseInt(document.getElementById(\"valueTxt\").value) } 
						};		
					});						
				});
				
			});
		</script>
		";
	 
	} catch( Exception $e ) {
		throw new Exception("Try later, sorry, too much guys other there, or it's not your day.");
	}
?>
</body>
</html>