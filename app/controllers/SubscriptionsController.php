<?php

namespace App\controllers;

use App\models\Customer;
use App\models\Subscription;
use App\services\Subscription\SubscriptionSyncServiceAbstract;
use Phalcon\Mvc\Controller;
use Stripe\StripeClient;

class SubscriptionsController extends Controller
{
    private $subscriptionSyncService;

    public function onConstruct()
    {
        $this->subscriptionSyncService = $this->di->get(SubscriptionSyncServiceAbstract::class);
    }
    public function indexAction()
    {
        $params = $this->request->getQuery();

        $subscriptionsBuilder = $this->modelsManager
            ->createBuilder()
            ->from(['s' => Subscription::class])
            ->leftJoin(Customer::class, 'c.id = s.customer_id', 'c')
            ->columns([
                's.id',
                's.stripe_id',
                's.created_at',
                's.status',

                'customer_id' => 'c.id',
                'customer_name' => 'c.name',
                'customer_stripe_id' => 'c.stripe_id',
                'customer_email' => 'c.email'
            ]);

        if (isset($params['customer_id'])) {
            $subscriptionsBuilder->andWhere('s.customer_id = :customer_id:', ['customer_id' => $params['customer_id']]);
        }

        $subscriptions = $subscriptionsBuilder
            ->getQuery()
            ->execute()
            ->toArray();

        $result = [];

        foreach ($subscriptions as $subscription) {
            $result[] = [
                'id' => $subscription['id'],
                'stripe_id' => $subscription['stripe_id'],
                'status' => $subscription['status'],
                'created_at' => $subscription['created_at'],
                'customer' => $subscription['customer_id'] ? [
                    'id' => $subscription['customer_id'],
                    'stripe_id' => $subscription['customer_stripe_id'],
                    'email' => $subscription['customer_email'],
                    'name' => $subscription['customer_name'],
                ] : null,
            ];
        }

        return $this->response->setJsonContent($result);
    }

    public function testAction()
    {
        $result = $this->subscriptionSyncService->handle();

        return $this->response->setJsonContent([
            'status' => 200,
            'data' => $result,
        ]);
    }

    public function syncAction()
    {
        $result = $this->subscriptionSyncService->handle();

        return $this->response->setJsonContent([
            'status' => 200,
            'result' => $result,
        ]);
    }
}