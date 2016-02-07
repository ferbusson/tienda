<?php
// DIC configuration

$container = $app->getContainer();

// view renderer, visualiza paginas en el navegador
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog envia mensajes en la consola
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


$container['db'] = function($c){
$settings = $c->get('settings')['db'];
$host = $settings['host'];
$usr = $settings['usr'];
$pass = $settings['pass'];

return new PDO($host,$usr,$pass);

};
