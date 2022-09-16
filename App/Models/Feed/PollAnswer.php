<?php

namespace App\Models\Feed;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class PollAnswer extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "poll_answers"; # declear table only if using traitModel
    public static $error = [];

    public static function craft(array $param, $exec = true)
    {
        return self::dump($param);
        // return $param;          
    }

    public static function retrieve($param = [], $type = '*', $exec = true)
    {
       return self::findOne($param, $type, $exec);
    }

    public static function answer($data)
    {
        if(self::isAnswered($data)):
            return false;
        else:
            return self::craft([
                'user_id' => (int) $data->user,
                'feed_id' => (int) $data->feed,
                'poll_option_id' => $data->option
            ]);
        endif;
    }

    public static function isAnswered($data, $alt = [])
    {
        extract($alt);
        return self::retrieve([
            'user_id' => $data->user ?? $user,
            'and.feed_id' => $data->feed ?? $feed
        ]);
    }
}
