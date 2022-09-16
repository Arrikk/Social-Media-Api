<?php

namespace App\Controllers;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Subscriptions\Subscriptions as SubscriptionsSubscriptions;
use App\Models\Subscriptions\SubscriptionSettings;
use Core\Http\Res;

class Subscriptions extends Authenticated
{
    public function _subscribe($data)
    {
        $to = $this->route_params['id'] ?? null;
        if($to):
            $sub = SubscriptionsSubscriptions::subscribe($to, $this->user->id);
            Res::json($sub);
        endif;
    }

    public function _unsubscribe()
    {
        $to = $this->route_params['id'] ?? null;
        if($to):
            $sub = SubscriptionsSubscriptions::unsubscribe($to, $this->user->id);
            Res::json($sub);
        endif;

    }

    public function _update($data)
    {
        $this->required(['amount' => $data->amount ?? '']);
        Res::json(SubscriptionSettings::updateSubscription($this->user->id, (float) $data->amount));
    }

    public function _subscriptions()
    {
        Res::json(SubscriptionsSubscriptions::mySubscriptions($this->user->id));
    }
}
