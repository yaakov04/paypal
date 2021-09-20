<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;



$orderID=$_GET['token'];       //aqui se le asigna a la variable  $orderID un token que viene en la url (ese token es el id de la orden asignado por paypal)

//para que se finalice el pago hay que ejecutar este codigo

$request = new OrdersCaptureRequest($orderID);           //se le pasa la variable $orderID
$request->prefer('return=representation');
try {
    
    $response = $client->execute($request);
    //print_r($response);           //imprime los detalles del pago
}catch (HttpException $ex) {
    echo $ex->statusCode;
    print_r($ex->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/5.0.0/normalize.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Pago finalizado</title>
</head>
<body>
    <div class="formulario contenedor">
    <h2>Pagos con Paypal</h2>
        <?php
        $respuesta = $response->result->status;

        if($respuesta == 'COMPLETED'){?>
        <div>
            <span>El pago se realizo correctamente!</span>
        </div>
        <div>
            <span>La orden de pago es: <strong><?php echo $orderID; ?></strong> </span>
        </div>
        <?php }?>
    </div>
    

</body>
</html>

