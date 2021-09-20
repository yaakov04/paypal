<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$producto = $_POST['producto'];                 //Aquí obtenemos el nombre del producto que se imprimira en el html
$total = floatval($_POST['precio']);            //Aquí le asignamos a la variable $total el costo total de la compra
$refernceId= uniqid();                          //Aquí le asigno un id aleatorio, pero tal vez seria bueno pasarle un id propio de la base de datos




use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

$request = new OrdersCreateRequest();
$request->prefer('return=representation');
$request->body = [
                     "intent" => "CAPTURE",
                     "purchase_units" => [[
                         "reference_id" => $refernceId,   //Aquí se le pasa la variable $id
                         "amount" => [
                             "value" => $total,           //Aquí le pasa la variable $total
                             "currency_code" => "MXN" 
                         ]
                     ]],
                     "application_context" => [
                          "cancel_url" => "https://example.com/cancel",
                          "return_url" => "http://localhost:5500/pago_finalizado.php"  //Despues de ir a la pagina de paypal y pagar te redirecciona a esta pagina en donde finaliza el pago
                     ] 
                 ];

try {
    $response = $client->execute($request);
    //print_r($response->result); //imprime los detalles la orden
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
    <title>Checkout</title>
</head>
<body>
   <div class="formulario contenedor">
        <h2>Su pedido:</h2>
            <?php
                $pagarUrl = $response->result->links[1]->href; //aqui asigno a la variable $pagarUrl la url de pago aceptado o aprovado por el comprador, hay varias urls mas para verlas: << var_dump($response->result->links) >>
            ?>
        <div>
            <span>Producto:</span>
            <span><?php echo $producto ?></span> 
        </div>
        <div>
            <span>Total a pagar:</span>
            <span><strong><?php echo $total ?></strong></span>
        </div>
        <div class="btn_contenedor">
            <a  href="<?php echo $pagarUrl; //Este enlace te redirecciona a la pagina de paypal ?>" class="btn_pagar">Pagar</a>
        </div>
   </div>
</body>
</html>



