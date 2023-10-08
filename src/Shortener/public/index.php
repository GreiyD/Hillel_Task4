<?php

use App\DI\Container;

require_once __DIR__ . '/../autoload.php';
$config = require_once __DIR__ . '/../../DI/config.php';

$container = new Container();

foreach ($config['services'] as $key => $service) {
    $container->add($key, $service);
}

$converter = $container->get('UrlConverter1');

$urlString = "https://laravel.su";
//$urlString = "https://www.google.com.ua";
//$urlString = "https://www.adidas.ua";
//$codeString = "wguFAot";
$codeString = "/h3rHva";

echo $urlString . "<br>";
echo $converter->encode($urlString);
echo "<br>------------------------<br>";

echo $codeString . "<br>";
echo $converter->decode($codeString);