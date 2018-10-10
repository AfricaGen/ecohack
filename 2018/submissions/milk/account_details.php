<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Acount Details | Shoes market</title>
	<script src="elements/libs/stellar-sdk.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="elements/jquery/jquery.js"></script>
	<script type="text/javascript" src="elements/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="elements/js/main.js"></script>
	<link rel="stylesheet" href="elements/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="elements/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="elements/css/main.css">

	<script>
		function GetAccount(public_key){
			// alert(public_key);
			$("#loading").removeClass("hidden");

			var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');

			// the JS SDK uses promises for most actions, such as retrieving an account
			server.loadAccount(public_key).then(function(account) {
				$(".panel-title").html(`Getting Balances for account: ${public_key}`);
				
				account.balances.forEach(function(balance) {
					//console.log('Type:', balance.asset_type, ', Balance:', balance.balance);
					$("table").append(`<tr class='success'><td>${balance.asset_type}</td><td>${balance.balance}</td></tr>`);
				});

				$("#loading").addClass("hidden");
			});

		}
	</script>
</head>
<body>
	<?php include 'elements/includes/header_nav.php';?>
	<section>
		<div class="container well atm abm">
			<div class="form-group">
				<img id="loading" class="hidden" src="elements/images/loading.svg" width="30px"/>
				<label for="public_key">Public key </label>
				<input type="text" class="form-control" id="public_key" required>
				<br>
				<button id="create_token" class="btn btn-warning btn-block" onclick="GetAccount($('#public_key').val())">Check</button>
			</div>
		</div>
		<div id="result" class="container">
			<div class="panel panel-default table-responsive">
				<div class="panel-heading">
					<p class="panel-title text-center"></p>
				</div>
				<table class="table table-hover table-bordered text-center">
					<tr>
						<th>Type</th>
						<th>Balance</th>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	</section>
	<footer></footer>
</body>
</html>