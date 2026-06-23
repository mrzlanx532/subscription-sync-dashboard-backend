<?php

use App\services\Subscription\SubscriptionSyncServiceAbstract;
use App\services\Subscription\SubscriptionSyncServiceService;

$di->setShared(SubscriptionSyncServiceAbstract::class, function () use ($di) {
    return new SubscriptionSyncServiceService();
});