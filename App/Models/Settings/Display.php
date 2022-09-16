<?php

namespace App\Models\Settings;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Display extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "settings"; # declear table only if using traitModel
    public static $error = [];

    public static function display($id)
    {
        # Find the setting if already exists
        $display = Display::findOne([
            'setting_category' => DISPLAY,
            'and.setting_name' => MODE,
            'and.user_id' => (int) $id
        ]);
        # if settings exists proceed to update settings
        if ($display) :
            $mode = $display->setting_value == LIGHT ? DARk : LIGHT; # Toggle light and dark mde
            $display = Display::findAndUpdate([
                'setting_category' => DISPLAY,
                'and.id' => (int) $display->id,
            ], ['setting_value' => $mode]);
        else :
            # create the setting if not exist
            $display = Display::dump([
                'user_id' => $id,
                'setting_category' => DISPLAY,
                'setting_name' => MODE,
                'setting_value' => LIGHT
            ]);
        endif;
        return $display->setting_value;
    }
}
