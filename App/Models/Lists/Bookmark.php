<?php

namespace App\Models\Lists;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Bookmark extends Model
{
    use TraitsModel;
    static $table = 'lists'; # declare table name

    public static function makeBookmark($id)
    {
        // if (!self::findOne(['user_id' => $id, 'and.name' => self::$name])) :
            return self::dump([
                'user_id' => $id,
                'name' => BOOKMARK,
                'slug' => BOOKMARK,
                'is_editable' => 0,
                'lists' => ''
            ]);
        // endif;
    }
}
