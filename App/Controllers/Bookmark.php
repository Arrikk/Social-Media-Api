<?php

namespace App\Controllers;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Bookmark as ModelsBookmark;
use Core\Http\Res;

class Bookmark extends Authenticated
{
    public function _bookmark($data)
    {

        if (isset($this->route_params['id']) && $feed = $this->route_params['id']) :
            // $this->isUser($data->user);
            $data->user = $this->user->id;
            $data->feed = (int) $feed;
            
            if ($bookmarked = ModelsBookmark::bookmark($data)):
                $message = 'Bookmarked';
                if(is_bool($bookmarked)) $message = 'Removed';
                Res::json([
                    'status' => true,
                    'message' => $message
                ]);
            endif;
            Res::status(400)->json(['error' => 'Unable to bookmark feed']);
        else :
            Res::status(400)->json(['error' => 'Some action required']);
        endif;
    }

    public function _bookmarks()
    {
        Res::json(ModelsBookmark::bookmarks($this->user));
    }
}
