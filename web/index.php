<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Service\BookService;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;


$pdo = new \PDO($config['db']['dsn']);
$bookService = new BookService($pdo);

$app = new Application();
$app->register(new TwigServiceProvider(), [
   'twig.path' => __DIR__ . '/../templates'
]);
$app['debug'] = true;
$app['bs'] = $bookService;

$app->get('/', function () use ($app) {
    return $app['twig']->render('home.twig', [
        'books' => $app['bs']->getBooks(),
    ]);
});

$app->run();