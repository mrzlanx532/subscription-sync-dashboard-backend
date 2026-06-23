<?php

namespace App\controllers;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->response->setJsonContent([
            'status' => 200,
        ]);
    }

    public function notFoundAction()
    {
        return $this->response->setStatusCode(404, 'Not Found');
    }
}