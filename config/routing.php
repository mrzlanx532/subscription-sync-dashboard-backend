<?php

declare(strict_types=1);

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group;

$router = new Router(false);

$api = new Group([
    'namespace' => 'App\\controllers',
]);

$api->setPrefix('/api');

$api->addGet('', [
    'controller' => 'index',
    'action'     => 'index',
]);

$api->addGet('/subscriptions', [
    'controller' => 'subscriptions',
    'action'     => 'index',
]);

$api->addGet('/subscriptions/test', [
    'controller' => 'subscriptions',
    'action'     => 'test',
]);

$api->addPost('/subscriptions/sync', [
    'controller' => 'subscriptions',
    'action'     => 'sync',
]);

$api->addGet('/customers', [
    'controller' => 'customers',
    'action'     => 'index',
]);

$router->notFound([
    'controller' => 'index',
    'action'     => 'notFound',
]);

$router->mount($api);

return $router;