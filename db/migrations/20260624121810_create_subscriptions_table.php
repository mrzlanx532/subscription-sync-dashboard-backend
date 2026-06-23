<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSubscriptionsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('subscriptions');

        $table
            ->addColumn('stripe_id', 'string', ['limit' => 255])
            ->addColumn('customer_id', 'biginteger', ['signed' => false])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime')
            ->addColumn('status', 'string', ['limit' => 50])
            ->create();
    }
}
