<?php

namespace App\Models\Feed;

use Core\Model;
use Core\Traits\Model as TraitsModel;

class Poll extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "poll_options"; # declear table only if using traitModel
    public static $error = [];

    public static function craft(array $param, $exec = true)
    {
        return self::dump($param);
        // return $param;          
    }

    public static function retrieve($param = [])
    {
        $poll = self::find($param);

        # Get the poll count > how many times votes
        foreach ($poll as $key => $val) :
            $count = PollAnswer::retrieve(
                ['poll_option_id' => $val->id],
                'COUNT(*) AS count'
            );
            $poll[$key]->count = (int) $count->count;
        endforeach;
        return $poll;
    }
}
