<?php

namespace App\Models\Feed;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Media extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "media"; # declear table only if using traitModel
    public static $error = [];

    public static function craft(array $param, $exec = true)
    {
        return self::dump($param); 
    }

    public static function getMediaById($id)
    {
        $col = 'media_type as mediaType, media_format as mediaFormat, media_data as source';
        return self::find(['feed_id' => $id], $col);
    }
    
}
