<?php

namespace App\controllers;

use App\models\Customer;
use Phalcon\Mvc\Controller;

class CustomersController extends Controller
{
    public function indexAction()
    {
        $customers = $this->modelsManager
            ->createBuilder()
            ->from(['c' => Customer::class])
            ->columns([
                'id' => 'c.id',
                'value' => 'c.name',
            ])
            ->getQuery()
            ->execute()
            ->toArray();

        return $this->response->setJsonContent($customers);
    }
}