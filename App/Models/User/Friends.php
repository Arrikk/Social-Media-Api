<?php

namespace App\Models\User;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Friends extends Model
{
    use TraitsModel; # use model trait to get more model options
    static $table = 'friends'; # friends table

    public static function craft($data)
    {
        return self::dump($data);
    }

    public static function friend($data)
    {
        # check if user is already following>infollowers list
        $follower = self::findOne([
            'user_id' => $data->toFollow,
            '$.and' => self::inset($data->isFollowing, 'followers')
        ]);

        # check if user has followed in following list
        $following = self::findOne([
            'user_id' => $data->isFollowing,
            '$.and' => self::inset($data->toFollow, 'followings')
        ]);

        if ($follower && $following) :
            # unfollow
            self::unfollow($data);
            return 'Unfollowed';
        else :
            # follow
            self::follow($data);
            return 'Followed';
        endif;
        return;
    }


    /**
     * Follow
     */
    private static function follow($data)
    {
        self::findAndUpdate(
            ['user_id' => $data->toFollow],
            [
                'followers' => $data->isFollowing . ','
            ],
            static::$concat
        );
        self::findAndUpdate(
            ['user_id' => $data->isFollowing],
            [
                'followings' => $data->toFollow . ','
            ],
            static::$concat
        );
    }

    /**
     * Unfollow
     */
    private static function unfollow($data)
    {
        self::findAndUpdate(
            ['user_id' => $data->toFollow],
            [
                'followers' => ''
            ],
            [
                'name' => self::$replace,
                'from' => $data->isFollowing . ','
            ]
        );
        self::findAndUpdate(
            ['user_id' => $data->isFollowing],
            [
                'followings' => ''
            ],
            [
                'name' => self::$replace,
                'from' => $data->toFollow . ','
            ]
        );
    }

    public static function makeFriends($id)
    {
        return self::dump([
            'user_id' => $id,
            'followings' => '',
            'followers' => ''
        ]);
    }

    /**
     * check if a user is following
     * @param int $user > user id to check
     */
    public static function isFollowing($user, $following)
    {
        return self::findOne([
            'user_id' => $user,
            '$.and' => self::inset($following, 'followings')
        ]);
    }

    /**
     * check if a user is following
     * @param int $user > user id to check
     */
    public static function isFollower($user, $follower)
    {
        return self::findOne([
            'user_id' => $user,
            '$.and' => self::inset($follower, 'followers')
        ]);
    }
    
}
