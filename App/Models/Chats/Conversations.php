<?php
namespace App\Models\Conversations;

use App\Models\Messages\Messages;
use App\Models\User;
use Core\Model;
use Core\Traits\Model as ModelTrait;

class Conversations extends Model
{
    use ModelTrait;
    static $table = 'conversations';

    /**
     * Start a conversation
     */
    public static function start($sender, $receiver)
    {
        if(!self::conversation($sender, $receiver))
        return self::dump([
            'senderId' => (int) $sender,
            'receiverId' => (int) $receiver,
            'status' => OPENED
        ]);
    }

    /**
     * All conversations
     */
    public function conversations($currentUser)
    {
        $conversations =  self::find([
            'senderId' => $currentUser,
            'or.receiverId' => $currentUser,
            'and.status' => OPENED
        ]);

        foreach ($conversations as $key => $value) {
            $conversations[$key] = (object) [
                'sender' => $currentUser == $value->senderId ? 'ME' : User::getUserMinified($value->senderId),
                'receiver' => $currentUser == $value->receiverId ? 'Me' : User::getUserMinified($value->receiver),
                'lastMessage' => Messages::lastMessage($value->id)
            ];
        }
        return $conversations;
    }

    public static function conversation($sender, $receiver)
    {
        return self::findOne([
            'senderId' => $sender,
            'receiverId' => $receiver
        ]);
    }
}