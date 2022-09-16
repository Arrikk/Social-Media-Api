<?php

namespace App\Models;

use App\Models\Feed\Feed;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Bookmark extends Model
{

    use TraitsModel; # Use trait only if using the find methods

    /**
     * Each model class requires a unique table base on field
     * @return string $table ..... the table name e.g 
     * (users, posts, products etc based on your Model)
     */
    public static $table = "bookmarks"; # declear table only if using traitModel
    public static $error = [];

    public static function craft($param)
    {
        return self::dump($param);
    }

    public static function isBookmarked($data, $alt = ['user' => false, 'feed' => false])
    {
        # Check if feed has been bookmarked by the user
        extract($alt);
        return self::findOne([
            'user_id' => (int) $user ? $user : $data->user ,
            'and.feed_id' => (int) $feed ? $feed : $data->feed
        ]);
    }

    public static function bookMarks($user)
    {
        $bookmarks = self::select('*, bookmarks.user_id as bookmarkUser')
        ->from(self::$table)
        ->inner('feed')
        ->on('bookmarks.feed_id = feed.id')
        ->where("bookmarks.user_id = $user->id")
        ->exec();

        $formatted = Feed::formatFeed($bookmarks, $user);
        return $formatted;
    }

    public static function bookmark($data)
    {
        # Check if feed has been bookmarked by the user
        $isBookmarked = self::isBookmarked($data);

        if ($isBookmarked) :
            return self::findAndDelete([
                'id' => $isBookmarked->id,
                'and.feed_id' => $isBookmarked->feed_id
            ]);

        else :
            return self::dump([
                'user_id' => (int) $data->user,
                'feed_id' => (int) $data->feed
            ]);
        endif;
    }
}
