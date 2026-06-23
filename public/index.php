<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo\Mysql;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$di = new FactoryDefault();

$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir(
            APP_PATH . '/views/'
        );

        return $view;
    }
);

$di->set(
    'url',
    function () {
        $url = new UrlProvider();

        $url->setBaseUri('/');

        return $url;
    }
);

$di->setShared(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();

        $dispatcher->setDefaultNamespace(
            'App\controllers'
        );

        return $dispatcher;
    }
);

$di->setShared(
    'db',
    function () {
        return new Mysql([
            'host'     => $_ENV['DB_HOST'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'dbname'   => $_ENV['DB_NAME'],
            'charset'  => 'utf8mb4',
        ]);
    }
);

$di->setShared(
    'router',
    function () {
        return require_once BASE_PATH . '/config/routing.php';
    }
);

require_once BASE_PATH . '/config/cors.php';
require_once BASE_PATH . '/config/services.php';

try {
    $application = new Application($di);

    $response = $application->handle(
        $_SERVER['REQUEST_URI'] ?? '/'
    );

    $response->send();
} catch (Throwable $e) {
    echo '<pre>';
    echo $e;
    echo '</pre>';
}