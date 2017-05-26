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

<div>
    <input type="button" value="Buy Item" id="buyBtn" />
	</br>
    <input type="button" value="Supply Item" id="supplyBtn" />
    <input value="0" type="text" placeholder="value" id="valueTxt" />
</div>

<?php
/* DENGAN TRY CATCH */
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
	 
	} catch( Exception $e ) {
		throw new Exception("Try later, sorry, too much guys other there, or it's not your day.");
	}



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

</html>