<?php

namespace App\models;

use Phalcon\Mvc\Model;

class Customer extends Model
{
    public function initialize()
    {
        $this->setSource('customers');
    }

    public function beforeCreate(): void
    {
        $now = date('Y-m-d H:i:s');

        $this->created_at = $now;
        $this->updated_at = $now;
    }

    public function beforeUpdate(): void
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }
}