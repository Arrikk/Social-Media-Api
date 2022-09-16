<?php

namespace App\Models\Lists;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class CloseFriends extends Model
{
    use TraitsModel;
    static $table = 'lists'; # declare table name

    public static function makeCloseFriends($id)
    {
        // if (!self::findOne(['user_id' => $id, 'and.name' => self::$name])) :
            return self::dump([
                'user_id' => $id,
                'name' => CLOSE_FRIENDS,
                'slug' => strtolower(CLOSE_FRIENDS),
                'is_editable' => 0,
                'lists' => ''
            ]);
        // endif;
    }
}
