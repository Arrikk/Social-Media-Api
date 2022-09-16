<?php

namespace App\Models\Feed;

use App\Models\Feed\Feed;
use App\Models\User;
use App\Models\User\Notifications;
use Core\Http\Res;
use Core\Model;
use Core\Traits\Model as TraitsModel;

class Comment extends Model
{
    use TraitsModel;
    static $table = 'comments';

    public static function make($data)
    {
        $feed = Feed::findFeed($data);
        if ($feed && $feed = $feed[0]) :
            if ($feed->canComment) :

                Notifications::notify([
                    'agent' => $data->id,
                    'user' => $feed->user_id,
                    'description' => 'Commented on your feed',
                    'category' => COMMENT
                ]);

                return self::dump([
                    'feed_id' => $data->feed,
                    'user_id' => $data->id,
                    'comment' => self::clean($data->comment)
                ]);
            else :
                Res::status(400)->json(['error' => 'You are not allowed to comment on this feed']);
            endif;
        else :
            Res::status(404)->json(['error' => 'Feed not found']);
        endif;
    }

    public static function getComments($feed, $user = null)
    {
        $col = 'id, feed_id, user_id as author, comment, likes as likesCount, createdAt';

        $feeds = self::find([
            'feed_id' => $feed
        ], $col);

        foreach ($feeds as $feed => $val) :
            $author = User::getUser($val->author, (int) $user);


            $feeds[$feed]->author = $author;

            $feeds[$feed]->rawText = $feeds[$feed]->comment;
            $feeds[$feed]->comment = html_entity_decode(nl2br($feeds[$feed]->comment));
            $likes = explode(',', $feeds[$feed]->likesCount);
            $feeds[$feed]->likesCount = count($likes) -1;

            # check if user already liked this comment
            $liked = in_array($user, $likes);
            # set is liked to true if user already liked
            $feeds[$feed]->isLiked = $liked ? true : false;
            # set canlike if user can still like comment
            $feeds[$feed]->canLike = !$liked ? true : false;
        endforeach;

        return $feeds;
    }

    public static function getCommentCount($feed)
    {
        return self::findOne(['feed_id' => $feed], 'count(*) as totalComment');
    }

    public static function delete($id)
    {
        $comment = self::findOne(['id' => $id->id]);

        if ($comment && $comment->user_id == $id->user) :
            return self::findAndDelete([
                'id' => $id->id,
                'and.user_id' => $id->user
            ]);
        else :
            Res::status(401)->json(['error' => 'Operation Denied']);
        endif;
    }

    public static function likeUnlike($id)
    {
        $comment = self::findOne(['id' => $id->id]);

        if ($comment) :
            if (strstr($comment->likes, $id->user . ',')) return self::unlike($id);
            else return self::like($id);
        else :
            Res::status(404)->json(['error' => 'Comment not Found']);
        endif;
    }

    public static function like($id)
    {
        self::findAndUpdate(
            ['id' => $id->id],
            ['likes' => $id->user . ','],
            self::$concat
        );
        return 'Liked';
    }

    public static function unlike($id)
    {
        self::findAndUpdate(
            ['id' => $id->id],
            ['likes' => ''],
            ['name' => self::$replace, 'from' => $id->user.',']
        );
        return 'Unliked';
    }
    
}
