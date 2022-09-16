<?php

namespace App\Models\Settings;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Settings extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "settings"; # declear table only if using traitModel
    public static $error = [];

    public static function setting($id)
    {
        # Find the setting if already exists
        return Settings::find([
            'user_id' => (int) $id
        ]);
    }
}
