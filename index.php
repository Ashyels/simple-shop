<!-- Web-based app example -->
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Firebase</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
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

<div style="display:inline-block;">	<p>[Laptop] Total Item = </p>	</div>
<div style="display:inline-block;">	<p id="laptopItemTotal"></p>	</div> <!-- menampilkan total laptop dari firebase -->
<div> <input value="0" type="text" placeholder="value" id="laptopValueTxt" />	</div>

<div style="display:inline-block;">	<p>[Ipad] Total Item = </p>	</div>
<div style="display:inline-block;">	<p id="ipadItemTotal"></p>	</div> <!-- menampilkan total ipad dari firebase -->
<div> <input value="0" type="text" placeholder="value" id="ipadValueTxt" />	</div>

<div style="display:inline-block;">	<p>[Camera] Total Item = </p>	</div>
<div style="display:inline-block;">	<p id="cameraItemTotal"></p>	</div> <!-- menampilkan total camera dari firebase -->
<div> <input value="0" type="text" placeholder="value" id="cameraValueTxt" />	</div>



<div>
	<br>
	<input type="button" value="Show Item" id="showItem" />
	<br>
	<br>
	<p>Transaction</p>
    <input type="button" value="Buy Item" id="buyBtn" />
    <input type="button" value="Supply Item" id="supplyBtn" />

	<br>

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
				var database = firebase.database();
				
				sB.click(function () {

					var itemRef = firebase.database().ref();
					itemRef.transaction(function(currentData) {
						if (currentData === null) {
							database.ref('/item/laptop').once('value').then(function(snapshot) {
								var value = snapshot.val().quantity;
								document.getElementById(\"laptopItemTotal\").innerHTML = value + parseInt(document.getElementById(\"laptopValueTxt\").value);
								firebase.database().ref('item/laptop').update({
									quantity: value + parseInt(document.getElementById(\"laptopValueTxt\").value)
								});

								return {
									laptop: {quantity: value + parseInt(document.getElementById(\"laptopValueTxt\").value) } 
								};
							});
							
							database.ref('/item/ipad').once('value').then(function(snapshot) {
								var value = snapshot.val().quantity;
								document.getElementById(\"ipadItemTotal\").innerHTML = value + parseInt(document.getElementById(\"ipadValueTxt\").value);
								firebase.database().ref('item/ipad').update({
									quantity: value + parseInt(document.getElementById(\"ipadValueTxt\").value)
								});

								return {
									ipad: {quantity: value + parseInt(document.getElementById(\"ipadValueTxt\").value) } 
								};
							});
							
							database.ref('/item/camera').once('value').then(function(snapshot) {
								var value = snapshot.val().quantity;
								document.getElementById(\"cameraItemTotal\").innerHTML = value + parseInt(document.getElementById(\"cameraValueTxt\").value);
								firebase.database().ref('item/camera').update({
									quantity: value + parseInt(document.getElementById(\"cameraValueTxt\").value)
								});

								return {
									camera: {quantity: value + parseInt(document.getElementById(\"cameraValueTxt\").value) } 
								};
							});
							
							alert(\"Supply Success!\");
						} else {
							console.log('quantity race condition.');
							return; // Abort the transaction.
						}
					}, function(error, committed, snapshot) {
						if (error)
							console.log('Transaction failed abnormally!', error);
						else if (!committed)
						{
							// console.log('We aborted the transaction');
						}
						else
							console.log('User quantity added!');
					});
				});

				sI.click(function () {
					database.ref('/item/laptop').once('value').then(function(snapshot) {
					  var value = snapshot.val().quantity;
					 	document.getElementById(\"laptopItemTotal\").innerHTML = value;
					});
					database.ref('/item/ipad').once('value').then(function(snapshot) {
					  var value = snapshot.val().quantity;
					 	document.getElementById(\"ipadItemTotal\").innerHTML = value;
					});
					database.ref('/item/camera').once('value').then(function(snapshot) {
					  var value = snapshot.val().quantity;
					 	document.getElementById(\"cameraItemTotal\").innerHTML = value;
					});
				});

				bB.click(function () {
					
					// var value = database.ref('/item/laptop').once('value').then(function(snapshot) {
							// return snapshot.val().quantity;
						// });
					var count = 0;
					var valLaptop = 10;
					var valIpad = 10;
					var valCamera = 10;
					
					var ref = new Firebase(\"https://simpleshop-89516.firebaseio.com/item\");
					ref.orderByChild(\"quantity\").on(\"child_added\", function(snapshot) {
						var itemName = snapshot.key();
						var itemData = snapshot.val();
						if(itemName == \"laptop\")
							if(itemData.quantity >= parseInt(document.getElementById(\"laptopValueTxt\").value))
							{
								count = count + 1;
								valLaptop = itemData.quantity - parseInt(document.getElementById(\"ipadValueTxt\").value);
								// console.log(count);
							}
						if(itemName == \"ipad\")
							if(itemData.quantity >= parseInt(document.getElementById(\"ipadValueTxt\").value))
							{
								count = count + 1;
								valIpad = itemData.quantity - parseInt(document.getElementById(\"ipadValueTxt\").value);
								// console.log(count);
							}
						if(itemName == \"camera\")
							if(itemData.quantity >= parseInt(document.getElementById(\"cameraValueTxt\").value))
							{
								count = count + 1;
								valCamera = itemData.quantity - parseInt(document.getElementById(\"ipadValueTxt\").value);								
								// console.log(count);
							}
						if(count == 3)
						{
							var updatedUserData = {};
							updatedUserData['item/laptop/'] = {
								quantity: valLaptop
							};
							updatedUserData['item/ipad/'] = {
								quantity: valIpad
							};
							updatedUserData['item/camera/'] = {
								quantity: valCamera
							};

							database.ref().update(updatedUserData, function(error) {
							if (error) {
								console.log(\"Error updating data:\", error);
							}
							});
						}

					});

						if(count == 3)
						{
							var updatedUserData = {};
							updatedUserData['item/laptop/'] = {
								quantity: valLaptop
							};
							updatedUserData['item/ipad/'] = {
								quantity: valIpad
							};
							updatedUserData['item/camera/'] = {
								quantity: valCamera
							};

							database.ref().update(updatedUserData, function(error) {
							if (error) {
								console.log(\"Error updating data:\", error);
							}
							});

							document.getElementById(\"laptopItemTotal\").innerHTML = valLaptop;
							document.getElementById(\"ipadItemTotal\").innerHTML = valIpad;
							document.getElementById(\"cameraItemTotal\").innerHTML = valCamera;
							alert(\"Transaksi Berhasil!\");
						}
						else if(count < 3)
							alert(\"Transaksi Gagal!\");
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