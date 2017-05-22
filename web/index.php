<?php

namespace App;

use App\Model\TaskEntity;
use App\Model\TaskGateway;
use App\Service\TaskService;
use Ramsey\Uuid\Uuid;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

date_default_timezone_set('Europe/Brussels');

require_once __DIR__ . '/../vendor/autoload.php';

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = new Application();
$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../templates',
]);

$app['debug'] = true;

$pdo = new \PDO('sqlite:' . __DIR__ . '/../data/task.db');
$taskService = new TaskService(new TaskGateway($pdo));
$app['ts'] = $taskService;

$app->get('/', function () use ($app) {
    return $app['twig']->render('home.twig', [
        'tasks' => $app['ts']->getAllTasks()
    ]);
});

$app->post('/add', function (Request $request) use ($app) {
    $uuid = Uuid::uuid4();
    $taskEntity = new TaskEntity(
        $uuid->toString(),
        $request->get('label'),
        $request->get('description'),
        (1 === (int) $request->get('done'))
    );
    $app['ts']->addTask($taskEntity);
    return $app->redirect('/');
});

$app->get('/detail/{id}', function ($id) use ($app) {
    $taskEntry = $app['ts']->findTask($id);
    return $app['twig']->render('detail.twig', [
        'task' => $taskEntry,
    ]);
});

$app->get('/change/{id}', function ($id) use ($app) {
    $taskEntry = $app['ts']->findTask($id);
    return $app['twig']->render('edit.twig', [
        'task' => $taskEntry,
    ]);
});

$app->post('/update', function (Request $request) use ($app) {
    $taskEntity = new TaskEntity(
        $request->get('id'),
        $request->get('label'),
        $request->get('description'),
        (1 === (int) $request->get('done'))
    );
    $app['ts']->updateTask($taskEntity);
    return $app->redirect('/detail/' . $request->get('id'));
});

$app->get('/done/{id}', function ($id) use ($app) {
    $taskEntry = $app['ts']->findTask($id);
    $app['ts']->markTaskDone($taskEntry);
    return $app->redirect('/detail/' . $id);
});

$app->run();