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
    <input type="button" value="Buy Item" id="buyBtn" />
	<br>
	<input type="button" value="Show Item" id="showItem" />
	<br>
    <input type="button" value="Supply Item" id="supplyBtn" />
    <input value="0" type="text" placeholder="value" id="valueTxt" />
</div>

<?php

/* MENGGUNAKAN TRANSACTION() */
	try {
		echo "
		<script type=\"text/javascript\">
			$(document).ready(function() {
				
				// var wilmaRef = new Firebase('https://SampleChat.firebaseIO-demo.com/users/wilma');
				// wilmaRef.transaction(function(currentData) {
					// if (currentData === null) {
						// return {name: {first: 'Wilma', last: 'Flintstone'} };
					// } else {
						// console.log('User wilma already exists.');
						// return; // Abort the transaction.
					// }
				// }, function(error, committed, snapshot) {
					// if (error)
						// console.log('Transaction failed abnormally!', error);
					// else if (!committed)
						// console.log('We aborted the transaction (because wilma already exists).');
					// else
						// console.log('User wilma added!');
					// console.log('Wilma\'s data: ', snapshot.val());
				// });

				var sQ = $('#supplyQuantity');
				var bB = $('#buyBtn');
				var item = $('#showItem');
				var sB = $('#supplyBtn');
				var database = firebase.database();
				
				sB.click(function () {

					var itemRef = firebase.database().ref();
					itemRef.transaction(function(currentData) {
						if (currentData === null) {
							//var a =1;

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

				item.click(function () {
					database.ref('/item/').once('value').then(function(snapshot) {
					  var value = snapshot.val().quantity;
					 	document.getElementById(\"itemTotal\").innerHTML =value;
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

			});
		</script>
		";
	 
	} catch( Exception $e ) {
		throw new Exception("Try later, sorry, too much guys other there, or it's not your day.");
	}
	
	
/* DENGAN TRY CATCH */
/*	
	try {
		echo "
		<script type=\"text/javascript\">
			$(document).ready(function() {
				var sQ = $('#supplyQuantity');
				var bB = $('#buyBtn');
				var sB = $('#supplyBtn');
				var database = firebase.database();
				
				sB.click(function () {
								
					// return firebase.database().ref('/item/').once('value').then(function(snapshot) {
					//   var quantity = snapshot.val().quantity;
						
					document.getElementById(\"itemTotal\").innerHTML = parseInt(document.getElementById(\"valueTxt\").value);
					//   	database.ref('item/').set({
					// 		name: 'laptop',
					// 		quantity: quantity + parseInt(document.getElementById(\"valueTxt\").value)
					// 	});

					// });	

					database.ref('item/').set({
						name: 'laptop',
						quantity: parseInt(document.getElementById(\"valueTxt\").value)
					});
				});

				bB.click(function writeUserData(name, quantity) {
					firebase.database().ref('item/' + name).set({
						quantity: quantity
					});
				});
			});
		</script>
		";
	 
	} catch( Exception $e ) {
		throw new Exception("Try later, sorry, too much guys other there, or it's not your day.");
	}
*/


/* DENGAN MUTEX (MUTEX SUDAH TIDAK SUPPORT) */
/*
$mutex = Mutex::create();
var_dump(Mutex::lock($mutex));

	echo "
	<script type=\"text/javascript\">
		$(document).ready(function() {
			var sQ = $('#supplyQuantity');
			var bB = $('#buyBtn');
			var sB = $('#supplyBtn');
			var database = firebase.database();
			
			sB.click(function () {
							
				// return firebase.database().ref('/item/').once('value').then(function(snapshot) {
				//   var quantity = snapshot.val().quantity;
					
				document.getElementById(\"itemTotal\").innerHTML =
				parseInt(document.getElementById(\"valueTxt\").value);
				//   	database.ref('item/').set({
				// 		name: 'laptop',
				// 		quantity: quantity + parseInt(document.getElementById(\"valueTxt\").value)
				// 	});

				// });	

				database.ref('item/').set({
					name: 'laptop',
					quantity: parseInt(document.getElementById(\"valueTxt\").value)
				});
			});

			bB.click(function writeUserData(name, quantity) {
				firebase.database().ref('item/' + name).set({
					quantity: quantity
				});
			});
		});
	</script>
	";
	
var_dump(Mutex::unlock($mutex));
Mutex::destroy($mutex);
*/

?>
  
  
<!-- TANPA MUTEX -->
<!--
<script type="text/javascript">
    $(document).ready(function() {
        var sQ = $('#supplyQuantity');
        var bB = $('#buyBtn');
        var sB = $('#supplyBtn');
		var database = firebase.database();
		
        sB.click(function () {
						
			// return firebase.database().ref('/item/').once('value').then(function(snapshot) {
			//   var quantity = snapshot.val().quantity;
			  	
			document.getElementById("itemTotal").innerHTML =
			parseInt(document.getElementById("valueTxt").value);
			//   	database.ref('item/').set({
			// 		name: 'laptop',
			// 		quantity: quantity + parseInt(document.getElementById("valueTxt").value)
			// 	});

			// });	

			database.ref('item/').set({
				name: 'laptop',
				quantity: parseInt(document.getElementById("valueTxt").value)
			});
		});

		bB.click(function writeUserData(name, quantity) {
			firebase.database().ref('item/' + name).set({
				quantity: quantity
			});
		});
    });
</script>
-->

</body>
<!--
<script>
function writeNewPost() {
	// A post entry.
	var postData = {
	name: 'laptop',
	quantity: '3'
	};

	// Get a key for a new Post.
	var newPostKey = firebase.database().ref().child('posts').push().key;

	// Write the new post's data simultaneously in the posts list and the user's post list.
	var updates = {};
	updates['/posts/' + newPostKey] = postData;
	updates['/user-posts/' + uid + '/' + newPostKey] = postData;

	return firebase.database().ref().update(updates);
}
</script>
-->
</html>