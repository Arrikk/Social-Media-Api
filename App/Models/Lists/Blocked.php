<?php

namespace App\Models\Lists;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Blocked extends Model
{
    use TraitsModel;
    static $table = 'lists'; # declare table name

    public static function makeBlock($id)
    {
        // if (!self::findOne(['user_id' => $id, 'and.name' => self::$name])) :
            return self::dump([
                'user_id' => $id,
                'name' => BLOCKED,
                'slug' => BLOCKED,
                'is_editable' => 0,
                'lists' => ''
            ]);
        // endif;
    }

    public static function getBlocked($id)
    {
        return self::findOne([
            'user_id' => $id,
            'and.slug' => BLOCKED
        ]);
    }

    public static function block($userToBlock, $userBlocking)
    {
        
    }
}
