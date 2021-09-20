<?php

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
// Para configurar el client id y el client secret deben configurar:
//cuantas sandbox, una personal y una de negocios en https://developer.paypal.com/developer/accounts (con la cuenta personal pueden simular pagos para hacer las pruebas)
//y luego configurar una aplicacion de rest api https://developer.paypal.com/developer/applications (de aqui sale el client id y el client secret)
$clientId = "<<PAYPAL-CLIENT-ID>>";
$clientSecret = "<<PAYPAL-CLIENT-SECRET>>";

$environment = new SandboxEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);
