<?php

namespace App\services;

use Phalcon\Di\Di;

abstract class BaseService
{
    protected $db;
    public function __construct()
    {
        $di = Di::getDefault();
        $this->db = $di->get('db');
    }

    abstract public function handle();
}