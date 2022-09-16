<?php

namespace App\Controllers\Feed;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Feed\Feed as ModelFeed;
use App\Models\Feed\Tips;
use Core\Http\Res;

class Feed extends Authenticated
{
    /**
     * Create feed
     */
    public function _create($data)
    {
        // Res::json($this->user);
        // Res::json([$data, $_FILES]);
        if (isset($data->id)) :
            $this->isUser($data->id); # Validate user with token
            
            $feed = ModelFeed::saveFeed($data, $_FILES);

            if ($feed)
                Res::json(['success' => "Feed was successfully created", 'poll' => $feed]);
            else
                Res::status(400)->json(['error' => "Unable to create feed"]);

        else :
            Res::status(400)->json(['error' => "Some input fields are required"]);
        endif;
    }

    /**
     * Get all feed
     */
    public function _feeds()
    { 
        // Res::json($this->user);
        Res::json(ModelFeed::getFeed($this->user));
    }

    /**
     * Add user to a feed subscription list
     * requires user id and feed id
     */
    public function _addToSubscriptionList($data)
    {
        if (isset($data->user) && !empty($data->user) && isset($data->feed) && !empty($data->feed)) :
            $this->isUser($data->user);
            Res::json(ModelFeed::addToPremiumList($data));
        else :
            Res::status(400)->json(['error' => "Action Denied"]);
        endif;
    }

    /**
     * Tip a feed
     */
    public function _tip($data)
    {
        if(isset($data->feed) && isset($data->amount)):
            $data->id = $this->user->id;
            Res::json(Tips::make($data));
        else:
            Res::status(400)->json(['error' => 'Allocation Error']);
        endif;
    }

    public function _feed($data)
    {
        $this->required(['agent' => $data->agent ?? '']);
        $data->id = $data->agent;
        Res::json(ModelFeed::getFeed($data, $data, $this->user->id));
    }
}
