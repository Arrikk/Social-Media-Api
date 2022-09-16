<?php
namespace App\Models\User;

use App\Models\User;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Notifications extends Model
{
    use TraitsModel;
    static $table = 'notifications';

    public static function notify($item = [])
    {
        extract($item);
        return self::dump([
            'description' => $description,
            'user_id' => $user,
            'category' => $category,
            'agent' => $agent
        ]);

    }

    public static function myNotifications($user, $extra)
    {
        $currentPage = $extra->page ?? 1;
        $currentPage = (int) $currentPage;
        $limit = $extra->limit ?? LIMIT;

        if ($currentPage < 1) $currentPage = 1;
        $startAt = ($currentPage - 1) * $limit;

        $notifications = self::find(['user_id' => $user, '$.limit' => "$startAt, $limit"]);
        foreach ($notifications as $key => $notification) {
            $notifications[$key] = [
                'notificationId' => (int) $notification->id,
                'description' => self::clean(nl2br($notification->description)),
                'agent' => User::getUserMinified($notification->agent),
                'date' => $notification->createdAt,
                'isForComment' => $notification->category == COMMENT,
                'isForTip' => $notification->category == TIP,
                'isForSubscription' => $notification->category == SUBSCRIPTION,
                'isForPromotion' => $notification->category == PROMOTIONS,
            ];
        }
        return $notifications;
    }
}