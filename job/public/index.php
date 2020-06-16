<?php
require '../CSY2028/AutoLoader.php';
require '../Connection/pdo.php';

$routes = new \Classes\Routes\Routes();
$entryPoint = new \CSY2028\EntryPoint($routes);
$entryPoint->run();