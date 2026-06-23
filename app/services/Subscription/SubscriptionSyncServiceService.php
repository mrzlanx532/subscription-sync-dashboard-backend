<?php

namespace App\services\Subscription;

use App\models\Customer;
use App\models\Subscription;
use Stripe\StripeClient;
use Stripe\Customer as StripeCustomer;
use Stripe\Subscription as StripeSubscription;

class SubscriptionSyncServiceService extends SubscriptionSyncServiceAbstract
{
    public function handle()
    {
        $this->db->begin();

        $stripe = new StripeClient($_ENV['STRIPE_SECRET_KEY']);

        $subscriptions = $stripe->subscriptions->all([
            'expand' => ['data.customer'],
        ]);

        foreach ($subscriptions as $subscription) {
            $customer = $this->findOrCreateCustomer($subscription->customer);
            $this->findOrCreateSubscription($subscription, $customer);
        }

        $this->db->commit();
    }

    private function findOrCreateSubscription(StripeSubscription $stripeSubscription, Customer $customer)
    {
        $subscription = Subscription::findFirst([
            'stripe_id = :stripe_id:',
            'bind' => [
                'stripe_id' => $stripeSubscription->id,
            ]
        ]);

        if (!$subscription) {
            $subscription = new Subscription;
        }

        $subscription->stripe_id = $stripeSubscription->id;
        $subscription->customer_id = $customer->id;
        $subscription->status = $stripeSubscription->status;
        $subscription->save();
    }

    private function findOrCreateCustomer(StripeCustomer $stripeCustomer)
    {
        $customer = Customer::findFirst([
            'stripe_id = :stripe_id:',
            'bind' => [
                'stripe_id' => $stripeCustomer->id,
            ]
        ]);

        if (!$customer) {
            $customer = new Customer;
        }

        $customer->stripe_id = $stripeCustomer->id;
        $customer->email = $stripeCustomer->email;
        $customer->name = $stripeCustomer->name;
        $customer->save();

        return $customer;
    }
}