<?php

namespace App\Models\Settings;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Privacy extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "settings"; # declear table only if using traitModel
    public static $error = [];

    public static function privacy($id, $name)
    {
        $privacy = self::findOne([
            'setting_category' => PRIVACY,
            'and.setting_name' => $name,
            'and.user_id' => (int) $id
        ]);

        if ($privacy) :
            $mode = $privacy->setting_value == SHOW ? HIDE : SHOW;
            $privacy =  self::findAndUpdate([
                'setting_category' => PRIVACY,
                'and.id' => (int) $privacy->id,
                'and.setting_name' => $name
            ], ['setting_value' => $mode]);
            return (int) $privacy->setting_value ? true : false; 
        else :
           $privacy = self::dump([
                'user_id' => $id,
                'setting_category' => PRIVACY,
                'setting_name' => $name,
                'setting_value' => $name == SHOW_SUBSCRIPTION ? SHOW : HIDE
            ]);
            return (int) $privacy->setting_value ? true : false; 
        endif;
        return $privacy;
    }
}
