<?php

namespace App\Controllers\Feed;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Feed\Feed as ModelFeed;
use App\Models\Feed\PollAnswer;
use Core\Http\Res;

class Poll extends Authenticated
{
    /**
     * Create feed
     */
    public function _answer($data)
    {
        if (isset($data->feed) && !empty($data->feed) && isset($data->option) && !empty($data->option)) :
            $data->user = $this->user->id;
            if($stored = PollAnswer::answer($data)):
                Res::json($stored);
            else:
                Res::status(400)->json(['error' => "Sorry we could'nt catch that"]);
            endif;
        else :
            Res::status(400)->json(['error' => "Some input fields are required"]);
        endif;
    }


}
