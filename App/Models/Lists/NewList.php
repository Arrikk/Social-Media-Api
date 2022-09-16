<?php

namespace App\Models\Lists;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class NewList extends Model
{
    use TraitsModel;
    static $table = 'lists'; # declare table name

    public static function makeList($id, $name)
    {
            $list = self::dump([
                'user_id' => $id,
                'name' => $name,
                'is_editable' => 1,
                'lists' => ''
            ]);

            return (object) [
                'name' => $list->name,
                'id' => $list->id,
                'isEditable' => $list->is_editable ? true : false,
                'listCount' => 0,
                'slug' => $list->id
            ];
    }
}
