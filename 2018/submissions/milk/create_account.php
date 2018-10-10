<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create account | Milk market</title>
	<script src="elements/libs/stellar-sdk.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="elements/jquery/jquery.js"></script>
	<script type="text/javascript" src="elements/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="elements/js/main.js"></script>
	<link rel="stylesheet" href="elements/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="elements/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="elements/css/main.css">

	<script>
		var pair="";

		function CreateAccount() {
			// ONLY ON TESTNET. THE CODE BELOW FUNDS THE ACCOUNT WITH 10,000 XLM.
			var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');
			// var result = document.getElementById("result");

			pair = StellarSdk.Keypair.random();

			var secretkey = pair.secret();
			var publickey =pair.publicKey();

			$("#private_key").val(pair.secret()).removeAttr("disabled");
			$("#public_key").val(pair.publicKey()).removeAttr("disabled");

			$("#log").val("Loading...");
			$.ajax({
					type: "POST",
					url: "https://friendbot.stellar.org",
					data: {addr: publickey},
					dataType:'JSON', 
					success: function(response){
						$("#log").val("Account funded with 10,000 XLM").removeAttr("disabled");
						alert("Account created!!!");
					}
			});

		}

		function GetAccount(){

			var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');
			var result = document.getElementById("result");

			// the JS SDK uses promises for most actions, such as retrieving an account
			server.loadAccount(pair.publicKey()).then(function(account) {
				result.innerHTML += '<br><br><br>Getting Balances for account: ' + pair.publicKey();
				account.balances.forEach(function(balance) {
					//console.log('Type:', balance.asset_type, ', Balance:', balance.balance);
					result.innerHTML += "<br>Type:"+ balance.asset_type + ', Balance:'+balance.balance;
				});
			});

		}
	</script>
</head>
<body>
	<?php include 'elements/includes/header_nav.php';?>
	<section>
		<div id="result">
			<div class="well col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 shadow">
				<div class="form-group">
					<h2>
						CREATE ACCOUNT 
					</h2>
					<label for="fname" class="rbm">First name*</label>
					<input type="text" class="form-control" id="fname" name="fname">
					<br>
					<label for="lname" class="rbm">Last name*</label>
					<input type="text" class="form-control" id="lname" name="lname">
					<br>
					<label for="uname" class="rbm">User name*</label>
					<input type="text" class="form-control" id="uname" name="uname">
					<br>
					<label for="email" class="rbm">Email</label>
					<input type="email" class="form-control" id="email" name="email">
					<br>
					<label for="password" class="rbm">Password*</label>
					<input type="password" class="form-control" id="password" name="password">
					<br>
					<label for="private_key">Private key</label>
					<input type="text" class="form-control" id="private_key" disabled="disabled">
					<br>
					<label for="public_key">Public key</label>
					<input type="text" class="form-control" id="public_key" disabled="disabled">
					<br>
					<textarea id="log" class="form-control" rows="5" disabled="disabled"></textarea>
					<br>
					<button id="create_token" class="btn btn-warning btn-block" onclick="CreateAccount()">Create account</button>
				</div>
			</div>
		</div>
	</section>
	<footer></footer>
</body>
</html>