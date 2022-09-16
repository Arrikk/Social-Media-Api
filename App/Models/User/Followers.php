<?php
namespace App\Models\User;

use App\Models\User;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Followers extends Model
{
    use TraitsModel;
    static $table = 'friends';

    /**
     * Get followers
     * @param $
     */
    public static function followers($userId)
    {
        
    }

    public static function followings($userId)
    {
        $friends = self::findOne(['user_id' => $userId]);
        $friends = explode(',', $friends->followings);
        $resp = [];
        foreach ($friends as $value) {
            if($value == '') continue;
            $resp[] = User::getUserMinified($value);
        }
        return $resp;
    }
}