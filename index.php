<?php
include_once('DatabaseDataPrinter.php');

$customers = new DatabaseDataPrinter('customerName', 'customers');
$customers->printDatabaseData();

$products = new DatabaseDataPrinter('productName', 'products');
$products->printDatabaseData();
