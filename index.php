<?php
include_once('DatabaseDataPrinter.php');

$customers = new DatabaseDataPrinter('customerName', 'customers'); //En vez de meter aquí los datos, crear dos funciones dentro de database printer que tengan estos datos y asi aqui no hay que hacer nada de la query
try {
    $customers->printDatabaseData();
} catch (Exception $e){
    echo 'Exception: ',  $e->getMessage();
}

$products = new DatabaseDataPrinter('productName', 'products'); //Cargarme esto, que en teoria tienen que hacer la misma funcionalidad que al principio y eso es solo la de arriba XD
$products->printDatabaseData();
