<?php

namespace App\Models\Chats;

use App\Models\Conversations\Conversations;
use App\Models\User;
use Core\Model;
use Core\Traits\Model as ModelTrait;
use Module\Image;

class Messages extends Model
{
    use ModelTrait;
    static $table = 'messages';

    /**
     * Start a conversation
     */
    public static function message($data, $media = null)
    {
        $senderId = $data->senderId;
        $receiverId = $data->receiverId;
        $conversationId = 0;

        if (isset($media['image']) && !empty($media['image'])) :
            if (is_array($media['image']['name'])) :
                $upload = Image::multiple($media);
            else:
                $upload = Image::upload($media);
            endif;
        endif;

        return self::formatMessages(self::dump([
            'conversation_id' => $conversationId,
            'senderId' => $senderId,
            'receiverId' => $receiverId,
            'media' => json_encode($upload ?? ''),
            'message' => self::clean($data->message),
            'status' => UNREAD
        ]), $senderId);
    }

    public static function messages($me, $other)
    {
        $other = User::getUserById($other);
        $otherId = $other->id;

        $messages = self::select('*', static::$table)
            ->where('senderId', $me)
            ->and('receiverId', $otherId)
            ->or('receiverId', $me)
            ->and('senderId', $otherId)->exec();

        // if()
        foreach ($messages as $key => $message) {
            $messages[$key] = self::formatMessages($message, $me);
        }

        $other = User::getUserMinified($otherId);
        
        $other = (object)[
            'username' => $other->username,
            'id' => $other->id,
            'display_name' => $other->display_name,
            'avatar' => $other->avatar
        ];
        return (object) array_merge(['messages' => $messages], ['other' => $other]);
    }

    public static function formatMessages($data, $me = false)
    {
        $media = json_decode($data->media);
        return [
            'text' => html_entity_decode(nl2br($data->message)),
            'iAmSender' => $data->senderId == $me,
            'iAmReceiver' => $data->receiverId == $me,
            'read' => $data->status == READ,
            'unread' => $data->status == UNREAD,
            'withMedia' => !empty($media),
            'multipleMedia' => is_array($media),
            'media' => $media,
            'date' => $data->createdAt
        ];
    }

    public static function recent($user)
    {
        $recent = self::find([
            'receiverId' => $user,
            'or.senderId' => $user,
            '$.group' => 'senderId',
            'order.id' => 'DESC'
        ], 'DISTINCT *');

        foreach ($recent as $key => $value) {
            $other = [];
            
            $new = (object) self::formatMessages($value, $user);
            if($new->iAmSender)
                $other = User::getUserMinified($value->receiverId);
            if($new->iAmReceiver)
                $other = User::getUserMinified($value->senderId);
            $recent[$key] = $new;
            $recent[$key]->other = $other;
            
        }
        
        return $recent;
    }
}
