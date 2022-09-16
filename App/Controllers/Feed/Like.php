<?php
namespace App\Controllers\Feed;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Feed\Like as FeedLike;
use Core\Http\Res;

class Like extends Authenticated
{
    /**
     * Create feed
     */
    public function _like($data)
    {
        $feed = (int) $this->route_params['feed'] ?? 0;
        if ($feed !== 0) :
            $data->id = $this->user->id;
            $data->feed = $feed;
            if($like = FeedLike::craft($data)):
                Res::json(['status' => true, 'message' => $like]);
            else:
                Res::status(400)->json(['error' => "Sorry we could'nt catch that"]);
            endif;
        else :
            Res::status(400)->json(['error' => "Some input fields are required"]);
        endif;
    }


}
