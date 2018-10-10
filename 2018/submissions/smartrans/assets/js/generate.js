var pair="";
//
function getAll(){
  //@first make output selector empty
  $(".some1").empty();
  $(".some").empty();
  $(".some1").show();
  $(".some").show();
  $(".transactionTitle").show();
  var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');
  var pkey = document.getElementById('newOne').value;
  server.loadAccount(pkey).then(function(account) {

  $(".some1").append(
    "<h5 class='transactionTitle'>Account Balance</h5>"+
    "<table class='table table-dark table1'><thead>"+
   "<tr><th>Asset</th><th>Amount</th><th>Issuer Key</th></tr></thead>");

   //
   $(".some").append("<h5 class='transactionTitle'>Account Transactions</h5>"+
   "<table class='table table-dark table2'><thead>"+
    "<tr><th>Asset</th><th>Balance</th><th>Account</th><th>Date</th></tr></thead>");
    //
   account.balances.forEach(function(balance) {
     var asset="";
     var issue="";
     var ass="";
     var issuerKey=balance.asset_issuer;
     if (balance.asset_type=="native") {
       asset="XLM";
       issue="";
       ass="";
     }else {
       asset=balance.asset_code;
       issue=pkey.substring(0,3)+'***'+pkey.substring(pkey.length-3);
       ass=issuerKey.substring(0,3)+'***'+issuerKey.substring(issuerKey.length-3);
     }

      $(".table1").append(
       "<tbody><tr>"+"<td>"+asset+"</td><td>"+balance.balance+"</td>"+
       "<td>"+issue+"</td>"+"</tr></tbody>");
    //
    if (asset!=='XLM') {
      //append to table2
      $(".table2").append(
       "<tbody><tr>"+"<td>"+asset+"("+ass+")"+"</td><td>"+balance.balance+"</td>"+
       "<td>"+ass+"</td>"+
       "<td> Today at :"+new Date().getHours()+":"+new Date().getMinutes()+"</td></tr></tbody>");
    }
   });
  });
}
$(".gen-btn").on("click",function(e){
  e.preventDefault();
  $(".div-loader").fadeIn(300);
   StellarSdk.Network.useTestNetwork();
    //append pair
    pair = StellarSdk.Keypair.random();
   //create secret key
   var secret=pair.secret();
   //public key
   var publickey =pair.publicKey();
   //
   var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');
   //
   $.ajax({
    type: "POST",
    url: "https://friendbot.stellar.org",
    data: {addr: publickey},
    dataType:'JSON',
    success: function(response){
      $("#newToken").val(secret);
      //getAll();
      //hide loading spinner
      $(".div-loader").fadeOut(300);
    }
  });
})
/*get some btn*/
$(".get-btn-some").on("click",function(e) {
  e.preventDefault();
    $(".errors").empty();
  if ($("#newOne").val()==="") {
    $(".errors").
    append("<div class='alert alert-danger'>Please insert your public key from Stellar portal.</div>");
  }
  $(".div-loader").fadeIn(300);
  getAll();
  $(".div-loader").fadeOut(300);
});

//@Distributor key button
$(".distributor-btn").on("click",function(e) {
  e.preventDefault();
  $(".div-loader").fadeIn(300);
   StellarSdk.Network.useTestNetwork();
     // create a completely new and unique pair of keys
   // see more about KeyPair objects: https://stellar.github.io/js-stellar-sdk/Keypair.html
    pair = StellarSdk.Keypair.random();
   //create secret key
   var secret=pair.secret();
   //public key
   var publickey =pair.publicKey();
   //
   var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');
   //
   $.ajax({
    type: "POST",
    url: "https://friendbot.stellar.org",
    data: {addr: publickey},
    dataType:'JSON',
    success: function(response){
      $("#newDist").val(secret);
      //hide loading spinner
      $(".div-loader").fadeOut(300);
    }
  });
})


/*create token*/

  function createToken() {
  $(".success").empty();
//Asset_code
var asset_code = document.getElementById('code').value;
   //Amount of Asset to float on Market
var sell_asset_amount = document.getElementById('amount').value;

    if (asset_code.length < 4 || asset_code.length > 12 ) {
 $(".success").append
("<div class='alert alert-danger'>please use 4 characters for token code.</div>");
} else if(sell_asset_amount >limit_amount){
  alert("Please issue less tokens on the exchange");
}else{
  $(".success").
  append("<div class='alert alert-success'>Well Done!! Token Successfully created.</div>");
 //$(".div-loader").fadeIn(300);
    //  document.getElementById('reponse').style.display="none";
    // body...
    StellarSdk.Network.useTestNetwork();
var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');

//issuer_key
var issuer_key = document.getElementById('newToken').value;
//distribution_key
var distribution_key = document.getElementById('newDist').value;

//"SBAMMGVGJBJ54V4YUTEILN3MF2TB57IT5WYMQZ6XIUN6WV5Z6VD75Q2Z"

//limit
var limit_amount = document.getElementById('amount').value.toString();


var exchange_box =document.getElementById('exchange');
var lock_box =document.getElementById('lock');



//Price for Asset on Market
var market = document.getElementById('amount').value;

// Keys for accounts to issue and receive the new asset
// var issuingKeys = StellarSdk.Keypair
//   .fromSecret('SCZANGBA5YHTNYVVV4C3U252E2B6P6F5T3U6MM63WBSBZATAQI3EBTQ4');
// var receivingKeys = StellarSdk.Keypair
//   .fromSecret('SDSAVCRE5JRAI7UFAVLE5IMIZRD6N6WOJUWKY4GFN34LOBEEUS4W2T2D');

try{var issuingKeys = StellarSdk.Keypair
  .fromSecret(issuer_key);
var receivingKeys = StellarSdk.Keypair
  .fromSecret(distribution_key);
// Create an object to represent the new asset
var astroDollar = new StellarSdk.Asset(asset_code, issuingKeys.publicKey());
} catch (err){
    //$(".div-loader").fadeOut(300);
      //document.getElementById('reponse').style.display="block";
      //document.getElementById('reponse').innerHTML = "Token Failed due to Invalid Keys";
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

  //  if (exchange_box.checked == true && lock_box.checked == true) {
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
        homeDomain: document.getElementById("domain").value
      }))
      .build();
    transaction.sign(issuingKeys);

    return server.submitTransaction(transaction);

  //}
  /* else if (exchange_box.checked == false && lock_box.checked == true) {
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
  }*/
  /*else if (exchange_box.checked == true && lock_box.checked == false) {
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
  }*//*else if (exchange_box.checked == false && lock_box.checked == false)   {
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
  }*/

  })
  .then(function(issuer) {

    if( distribution_key == "SBAMMGVGJBJ54V4YUTEILN3MF2TB57IT5WYMQZ6XIUN6WV5Z6VD75Q2Z"){
        //SBAMMGVGJBJ54V4YUTEILN3MF2TB57IT5WYMQZ6XIUN6WV5Z6VD75Q2Z
     database_register(receivingKeys.publicKey(),issuingKeys.publicKey(),asset_code);
    }else{
        // do nothing
        //document.getElementById('reponse').style.display="block";
    //document.getElementById('newDist').style.display="none";
    //document.getElementById('a').style.display="none";
    //document.getElementById('newToken').style.display="none";
    //document.getElementById('waitingimg').style.display = "none";
    console.log("added man");
    //document.getElementById('reponse').innerHTML = "Successfully Created Token<br>Token Code: "+ asset_code+"<br>Issuer: "+issuer_key+"<br>Distributor: "+distribution_key+"<br>Please store keys to avoid losing accounts";

    // // document.getElementById('distribution_Secret_key').innerHTML = "Token Distributor :- "+receiving_key;
    // // console.log(receiving_key);
    // document.getElementById('asset_name').innerHTML = "Token :- "+asset_namez;
    // document.getElementById('issuer_secret_key').innerHTML = "Token Issuer:- "+ issuer_keyz;
    //document.getElementById("requestACall").reset();
    }

  })
  .catch(function(error) {
    console.error('Error!', error);

    //document.getElementById('waitingimg').style.display = "none";
      //document.getElementById('reponse').style.display="block";
      //document.getElementById('reponse').innerHTML = "Token Failed due to Issuer being under funded or Token already exists";
      //document.getElementById("requestACall").reset();

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
    document.getElementById('newDist').style.display="none";
    document.getElementById('asset_name').style.display="none";
    document.getElementById('newToken').style.display="none";
    //document.getElementById('waitingimg').style.display = "none";

    //document.getElementById('reponse').innerHTML = "Successfully Created Token";
    document.getElementById('newDist').innerHTML = "Token Distributor :- "+receiving_key;
    console.log(receiving_key);
    //document.getElementById('asset_name').innerHTML = "Token :- "+asset_namez;
    //document.getElementById('issuer_secret_key').innerHTML = "Token Issuer:- "+ issuer_keyz;
    //document.getElementById("requestACall").reset();

    }
});

}


  }
