<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Create Token</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json">
    <link href="assets/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="elements/css/main.css" rel="stylesheet">
    <script src="assets/lib/jquery/dist/jquery.js"></script>
	<script src="assets/lib/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/stellar-sdk/0.8.0/stellar-sdk.js"></script>
  </head>

<body>
  	<?php include 'elements/includes/header_nav.php';?>
	<section>
		<div class="container" style="margin-bottom: 30px">
			<div class="row">
				<div class="col-sm-4">
					<h2>
						CREATE TOKEN 
						<img id="waitingimg" src="elements/images/loading.svg" width="50px" style="display: none;float: right; top: 0"/>
					</h2>
				</div>
				<div class="col-sm-12">
					<p class="well" id="reponse"></p>
					<p class="well" id="asset_name"></p>
					<p class="well" id="issuer_secret_key"></p>
					<p class="well" id="distribution_Secret_key"></p>

					<div class="well">
						<div class="form-group col-sm-12 col-xs-12">
							<input class="form-control" type="text" id="issuer_key" name="issuer_key" placeholder="ISSUER SECRET KEY"/>
							<br>
							<button class="btn btn-warning center-block" onclick="createissuer()">
								Generate New Account
							</button>
						</div>
						<div class="form-group col-sm-12 col-xs-12">
							<input class="form-control" type="text" id="distribution_key" name="distribution_key" placeholder="DISTRIBUTOR SECRET KEY"/>
							<br>
							<button class="btn btn-warning center-block" onclick="createdistribution()">
								Generate New Account
							</button>
						</div>
						<div class="form-group col-sm-6 col-xs-12">
							<input class="form-control" type="text" max="12" min="4" id="asset_code" name="asset_code" placeholder="TOKEN CODE"/>
						</div>
						<div class="form-group col-sm-6 col-xs-12">
							<input class="form-control" type="number" id="amount" name="amount" placeholder="AMOUNT"/>
						</div>
						<div class="form-group col-sm-6 col-xs-12">
							<input class="form-control" type="text" max="12" min="4" id="home_domain" name="home_domain" placeholder="HOME DOMAIN"/>
						</div>
						<div class="form-group col-sm-6 col-xs-12">
							<input class="form-control" type="text" id="sell_asset_amount" name="sell_asset_amount" placeholder="How many tokens to distribute" style="display:none"/>
						</div>
						<div class="form-group col-sm-6 col-xs-12">
							<input class="form-control" type="text" id="market" name="market" placeholder="Token price in XLM" style="display:none"/>
						</div>

						<div class="form-group col-sm-6 col-xs-12" >
							<input class="form-control" type="text" id="empty" name="xxxxxxxxxxxxxxxxxxxx" placeholder=" " style="visibility: hidden"/>
						</div>
						<div class="form-group col-sm-6 col-xs-12">
							<input type="checkbox" id="exchange" onclick="exchangeFunction()" name="exchange">
							Distribute on Stellar Decentralised Exchange<br>
						</div>
						<div class="form-group col-sm-6 col-xs-12">
							<input type="checkbox" id="lock" name="lock">Lock Account<br>
						</div>
						<button class="btn btn-warning center-block btn-block atm abm" onclick="createToken()">
							CREATE TOKEN
						</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<footer>
	</footer>
  </body>
    <script type="text/javascript">
		document.getElementById('reponse').style.display="none";
		document.getElementById('distribution_Secret_key').style.display="none";
		document.getElementById('asset_name').style.display="none";
		document.getElementById('issuer_secret_key').style.display="none";
		//  var StellarSdk = require('stellar-sdk');

		function exchangeFunction(){

			var exchange_box =document.getElementById('exchange');

			if(exchange_box.checked == true){
			//Price for Asset on Market
			document.getElementById('market').style.display = "block";
			document.getElementById('empty').style.visibility = "hidden";

			//Amount of Asset to float on Market
			document.getElementById('sell_asset_amount').style.display = "block";
			}else{
			//Price for Asset on Market
			document.getElementById('market').style.display = "none";
			//Amount of Asset to float on Market
			document.getElementById('sell_asset_amount').style.display = "none";
			document.getElementById('empty').style.visibility = "hidden";
			}

		}

		/*document.getElementById('distribution_key').onclick = function() {
		this.select();
		document.execCommand('copy');
		alert('Public Key Copied');
		}

		document.getElementById('issuer_key').onclick = function() {
		this.select();
		document.execCommand('copy');
		alert('Secret Key Copied');
		}*/



		function createissuer() {

		document.getElementById('waitingimg').style.display = "block";

		// body...
		StellarSdk.Network.useTestNetwork();

		// create a completely new and unique pair of keys
		// see more about KeyPair objects: https://stellar.github.io/js-stellar-sdk/Keypair.html
		var pair = StellarSdk.Keypair.random();

		var secretkey = pair.secret();
		// SAV76USXIJOBMEQXPANUOQM6F5LIOTLPDIDVRJBFFE2MDJXG24TAPUU7
		var publickey =pair.publicKey();
		// GCFXHS4GXL6BVUCXBWXGTITROWLVYXQKQLF4YH5O5JT3YZXCYPAFBJZB


		var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');

		$.ajax({
		type: "POST",
		url: "https://friendbot.stellar.org",
		data: {addr: publickey},
		dataType:'JSON', 
		success: function(response){
		document.getElementById('issuer_key').value = secretkey;
		document.getElementById('waitingimg').style.display = "none";
		}
		});

		}

		function createdistribution() {
			document.getElementById('waitingimg').style.display = "block";
			// body...
			StellarSdk.Network.useTestNetwork();

			// create a completely new and unique pair of keys
			// see more about KeyPair objects: https://stellar.github.io/js-stellar-sdk/Keypair.html
			var pair = StellarSdk.Keypair.random();

			var secretkey = pair.secret();
			// SAV76USXIJOBMEQXPANUOQM6F5LIOTLPDIDVRJBFFE2MDJXG24TAPUU7
			var publickey =pair.publicKey();
			// GCFXHS4GXL6BVUCXBWXGTITROWLVYXQKQLF4YH5O5JT3YZXCYPAFBJZB


			var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');

			$.ajax({
			type: "POST",
			url: "https://friendbot.stellar.org",
			data: {addr: publickey},
			dataType:'JSON', 
			success: function(response){
			// console.log(response);
			document.getElementById('distribution_key').value = secretkey;
			document.getElementById('waitingimg').style.display = "none";
			}
			});

			}

			function createToken() {
			//Asset_code
			var asset_code = document.getElementById('asset_code').value;
			//Amount of Asset to float on Market
			var sell_asset_amount = document.getElementById('sell_asset_amount').value;

			if (asset_code.length < 4 || asset_code.length > 12 ) {
				alert("Please use atleast 4 Characters in Token");
			} else if(sell_asset_amount >limit_amount){
				alert("Please issue less tokens on the exchange");
			}else{
				document.getElementById('waitingimg').style.display = "block";
				document.getElementById('reponse').style.display="none";
				// body...
				StellarSdk.Network.useTestNetwork();
				var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');

				//issuer_key
				var issuer_key = document.getElementById('issuer_key').value;
				//distribution_key
				var distribution_key = document.getElementById('distribution_key').value;

				//"SBAMMGVGJBJ54V4YUTEILN3MF2TB57IT5WYMQZ6XIUN6WV5Z6VD75Q2Z"

				//limit
				var limit_amount = document.getElementById('amount').value.toString();


				var exchange_box =document.getElementById('exchange');
				var lock_box =document.getElementById('lock');

				//Price for Asset on Market
				var market = document.getElementById('market').value; 

				// Keys for accounts to issue and receive the new asset
				// var issuingKeys = StellarSdk.Keypair
				//   .fromSecret('SCZANGBA5YHTNYVVV4C3U252E2B6P6F5T3U6MM63WBSBZATAQI3EBTQ4');
				// var receivingKeys = StellarSdk.Keypair
				//   .fromSecret('SDSAVCRE5JRAI7UFAVLE5IMIZRD6N6WOJUWKY4GFN34LOBEEUS4W2T2D');

			try{
				var issuingKeys = StellarSdk.Keypair
				.fromSecret(issuer_key);
				var receivingKeys = StellarSdk.Keypair
				.fromSecret(distribution_key);
				// Create an object to represent the new asset
				var astroDollar = new StellarSdk.Asset(asset_code, issuingKeys.publicKey());
			} catch (err){
				document.getElementById('waitingimg').style.display = "none";
				document.getElementById('reponse').style.display="block";
				document.getElementById('reponse').innerHTML = "Token Failed due to Invalid Keys";
				document.getElementById("requestACall").reset();
			}
			// First, the receiving account must trust the asset
			server.loadAccount(receivingKeys.publicKey())
			.then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			// The `changeTrust` operation creates (or alters) a trustline
			// The `limit` parameter below is optional
			.addOperation(StellarSdk.Operation.changeTrust({
				asset: astroDollar,
				limit: limit_amount
			}))
			.build();
				transaction.sign(receivingKeys);
				return server.submitTransaction(transaction);
			})

			// Second, the issuing account actually sends a payment using the asset
			.then(function() {
				return server.loadAccount(issuingKeys.publicKey())
			})
			/*.then(function(issuer) {
			if(exchange_box.checked == true){
			var transaction = new StellarSdk.TransactionBuilder(issuer)
			.addOperation(StellarSdk.Operation.manageOffer({
			selling: astroDollar,
			buying: StellarSdk.Asset.native(),
			amount: sell_asset_amount,
			price : market
			}))
			.build();
			transaction.sign(issuingKeys);

			return server.submitTransaction(transaction);
			}else{
			//do nothing
			}
			})*/
			.then(function(issuer) {

			if (exchange_box.checked == true && lock_box.checked == true) {
				var transaction = new StellarSdk.TransactionBuilder(issuer)
				.addOperation(StellarSdk.Operation.payment({
				destination: receivingKeys.publicKey(),
				asset: astroDollar,
				amount: limit_amount
			})).addOperation(StellarSdk.Operation.setOptions({
			      lowThreshold : "1",
			      medThreshold : "2",
			      highThreshold : "3",
			      source : issuingKeys.publicKey()

			})).addOperation(StellarSdk.Operation.manageOffer({
				selling: astroDollar,
				buying: StellarSdk.Asset.native(),
				amount: sell_asset_amount,
				price : market
			})).addOperation(StellarSdk.Operation.setOptions({
				homeDomain: document.getElementById("home_domain").value
			
			})).build();
				transaction.sign(issuingKeys);

				return server.submitTransaction(transaction);

			} else if (exchange_box.checked == false && lock_box.checked == true) {
				var transaction = new StellarSdk.TransactionBuilder(issuer)
				.addOperation(StellarSdk.Operation.payment({
				destination: receivingKeys.publicKey(),
				asset: astroDollar,
				amount: limit_amount
			})).addOperation(StellarSdk.Operation.setOptions({
			      lowThreshold : "1",
			      medThreshold : "2",
			      highThreshold : "3",
			      source : issuingKeys.publicKey()

			})).addOperation(StellarSdk.Operation.setOptions({
				homeDomain: document.getElementById("home_domain").value
			}))
			.build();
				transaction.sign(issuingKeys);
				return server.submitTransaction(transaction);
			}else if (exchange_box.checked == true && lock_box.checked == false) {
				var transaction = new StellarSdk.TransactionBuilder(issuer)
				.addOperation(StellarSdk.Operation.payment({
				destination: receivingKeys.publicKey(),
				asset: astroDollar,
				amount: limit_amount
				})).addOperation(StellarSdk.Operation.manageOffer({
				selling: astroDollar,
				buying: StellarSdk.Asset.native(),
				amount: sell_asset_amount,
				price : market
				})).addOperation(StellarSdk.Operation.setOptions({
				homeDomain: document.getElementById("home_domain").value
				}))
				.build();
				transaction.sign(issuingKeys);

				return server.submitTransaction(transaction);
			}else if (exchange_box.checked == false && lock_box.checked == false)   {
				var transaction = new StellarSdk.TransactionBuilder(issuer)
				.addOperation(StellarSdk.Operation.payment({
				destination: receivingKeys.publicKey(),
				asset: astroDollar,
				amount: limit_amount,

				})).addOperation(StellarSdk.Operation.setOptions({
				homeDomain: document.getElementById("home_domain").value
				}))
				.build();
				transaction.sign(issuingKeys);

				return server.submitTransaction(transaction);
			}

			}).then(function(issuer) {

			if( distribution_key == "SBAMMGVGJBJ54V4YUTEILN3MF2TB57IT5WYMQZ6XIUN6WV5Z6VD75Q2Z"){
					//SBAMMGVGJBJ54V4YUTEILN3MF2TB57IT5WYMQZ6XIUN6WV5Z6VD75Q2Z
					database_register(receivingKeys.publicKey(),issuingKeys.publicKey(),asset_code);
				}else{
					// do nothing
					document.getElementById('reponse').style.display="block";
					document.getElementById('distribution_Secret_key').style.display="none";
					document.getElementById('asset_name').style.display="none";
					document.getElementById('issuer_secret_key').style.display="none";
					document.getElementById('waitingimg').style.display = "none";

					document.getElementById('reponse').innerHTML = "Successfully Created Token<br>Token Code: "+ asset_code+"<br>Issuer: "+issuer_key+"<br>Distributor: "+distribution_key+"<br>Please store keys to avoid losing accounts";

					// // document.getElementById('distribution_Secret_key').innerHTML = "Token Distributor :- "+receiving_key;
					// // console.log(receiving_key);
					// document.getElementById('asset_name').innerHTML = "Token :- "+asset_namez;
					// document.getElementById('issuer_secret_key').innerHTML = "Token Issuer:- "+ issuer_keyz;
					document.getElementById("requestACall").reset();
				}

			}).catch(function(error) {
				console.error('Error!', error);

				document.getElementById('waitingimg').style.display = "none";
				document.getElementById('reponse').style.display="block";
				document.getElementById('reponse').innerHTML = "Successfully Created Token<br>Token Code: "+ asset_code+"<br>Issuer: "+issuer_key+"<br>Distributor: "+distribution_key+"<br>Please store keys to avoid losing accounts";
				document.getElementById("requestACall").reset();

			});
		}


		function database_register(receiving_key,issuer_keyz,asset_namez) {
			$.ajax({
				type: "POST",
				url: "https://clicmonkey.xyz/tokenmaker/assetregister.php",
				data: {asset_name: asset_namez,issuer_key: issuer_keyz},
				dataType:'JSON', 
				success: function(response){
				// console.log(response);
					document.getElementById('reponse').style.display="block";
					document.getElementById('distribution_Secret_key').style.display="none";
					document.getElementById('asset_name').style.display="none";
					document.getElementById('issuer_secret_key').style.display="none";
					document.getElementById('waitingimg').style.display = "none";

					document.getElementById('reponse').innerHTML = "Successfully Created Token";
					document.getElementById('distribution_Secret_key').innerHTML = "Token Distributor :- "+receiving_key;
					console.log(receiving_key);
					document.getElementById('asset_name').innerHTML = "Token :- "+asset_namez;
					document.getElementById('issuer_secret_key').innerHTML = "Token Issuer:- "+ issuer_keyz;
					document.getElementById("requestACall").reset();

				}
			});
		}
	}
    </script>
</html>