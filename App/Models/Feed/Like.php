<?php

namespace App\Models\Feed;

use Core\Model;
use Core\Traits\Model as TraitsModel;

/**
 * Like unlike model
 */

class Like extends Model
{
    use TraitsModel;
    static $table = 'feed';

    public static function craft($data)
    {
        # check if user already liked this feed
        $alreadyLiked = self::findOne([
            'id' => $data->feed,
            '$.and' => self::inset($data->id, 'likes')
        ]);

        if ($alreadyLiked) :
            # unlike Feed
            self::unlike($data);
            return 'Unlike';
        else :
            # Like feed
            self::like($data);
            return 'Liked';
        endif;
    }

    /**
     * Like feed
     * @param object $data
     * @return mixed
     */
    protected static function like($data)
    {
        return self::findAndUpdate(
            ['id' => $data->feed],
            ['likes' => $data->id . ','],
            self::$concat
        );
    }

    /**
     * UnLike feed
     * @param object $data
     * @return mixed
     */
    protected static function unlike($data)
    {
        return self::findAndUpdate(
            ['id' => $data->feed],
            ['likes' => ''],
            ['name' => self::$replace, 'from' =>  $data->id . ',']
        );
    }
}
