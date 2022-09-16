<?php

namespace App\Models\Lists;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Restrict extends Model
{
    use TraitsModel;
    static $table = 'lists'; # declare table name

    public static function makeRestrict($id)
    {
        // if (!self::findOne(['user_id' => $id, 'and.name' => self::$name])) :
            return self::dump([
                'user_id' => $id,
                'name' => RESTRICT,
                'slug' => strtolower(RESTRICT),
                'is_editable' => 0,
                'lists' => ''
            ]);
        // endif;
    }
}
