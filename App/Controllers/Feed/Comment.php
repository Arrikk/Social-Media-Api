<?php

namespace App\Controllers\Feed;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Feed\Comment as ModelsComment;
use Core\Http\Res;

class Comment extends Authenticated
{
    /**
     * Create feed
     */
    public function _create($data)
    {
        // Res::json($this->user);
        if (isset($data->comment) && isset($this->route_params['feed'])) :
           
            $data->feed  = (int) $this->route_params['feed'];
            $data->id = $this->user->id; 

            $feed = ModelsComment::make($data);
            Res::json($feed);

        else :
            Res::status(400)->json(['error' => "Request Error"]);
        endif;
    }

    /**
     * Get Comments
     */
    public function _comments()
    {
        if (isset($this->route_params['feed'])) :
            $feed = $this->route_params['feed'];
            Res::json(ModelsComment::getComments($feed, $this->user->id));
        else :
            Res::status(400)->json(['error' => 'Sorry we couldn\'t catch that']);
        endif;
    }

    /**
     * Delete Comment
     */
    public function _delete($_)
    {
        $id = (int) $this->route_params['id'] ?? 0;

        if($id):

            $_->id = $id;
            $_->user = $this->user->id;

            Res::json(ModelsComment::delete($_));
        else:
            Res::status(400)->json(['error' => 'Sorry we couldn\'t catch that']);
        endif;
    }

    public function _lunlike($_)
    {
        if(isset($this->route_params['id'])){

            $_->user = $this->user->id;
            $_->id = $this->route_params['id'];

            Res::json(['message' => ModelsComment::likeUnlike($_)]);
        }
    }
}
