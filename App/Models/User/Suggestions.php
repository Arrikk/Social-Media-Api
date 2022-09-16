<?php
namespace App\Models\User;

use App\Models\Subscriptions\Subscriptions;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Suggestions extends Model
{
    use TraitsModel;
    static $table = 'users';

    public static function suggest ($subscriber)
    {
        $suggestions = self::find([
            'is_verified' => '1',
            '$.order' => 'createdAt DESC',
            '$.limit' => 18
        ]);

        $suggest = array();

        foreach ($suggestions as $key => $value) :
            # check if current user has subscribe to suggested user
            $subscription = Subscriptions::subscription($subscriber, $value->id);
            # is current user is subscribed skip and move to check next suggested user
            if($subscription) continue;
            if($value->id == $subscriber) continue;

            $suggest[] = (object) [
                'name' => $value->display_name,
                'username'=> $value->username,
                'avatar' => $value->avatar,
                'userId' => $value->id,
            ];
        endforeach;

        return $suggest;

    }
}