var StellarSdk = require('stellar-sdk');
var server = new StellarSdk.Server('https://horizon-testnet.stellar.org');

var pair = StellarSdk.Keypair.random();

var secret_key = pair.secret();
// SAV76USXIJOBMEQXPANUOQM6F5LIOTLPDIDVRJBFFE2MDJXG24TAPUU7
var public_key = pair.publicKey();

console.log(secret_key);
console.log(public_key);