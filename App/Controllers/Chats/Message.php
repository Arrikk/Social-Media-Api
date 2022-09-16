<?php
namespace App\Controllers\Chats;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Chats\Messages;
use Core\Http\Res;

class Message extends Authenticated
{
    /**
     * Send chat message
     */
    public function _chat($data)
    {
        $message = $data->message ?? '';
        $senderId = $data->senderId ?? '';
        $receiverId = $data->receiverId ?? '';

        $this->required([
            'message' => $message ?? '',
            'receiverId' => $receiverId ?? '',
            'senderId' => $senderId
        ]);

        $this->isUser((int) $senderId);
        Res::json(Messages::message($data, $_FILES));
    }

    /**
     * Get messages
     */
    public function _chats()
    {
        $chatsWith = $this->route_params['username'] ?? '';
        $this->required(['chatsWith' => $chatsWith]);
        $currentUser = $this->user->id;
        Res::json(Messages::messages($currentUser, $chatsWith));
        
    }

    public function _conversations()
    {
        Res::json(Messages::recent($this->user->id));
    }
}