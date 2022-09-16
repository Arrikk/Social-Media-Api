<?php

namespace App\Controllers\Admin;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Content as ModelsContent;
use Core\Http\Res;

class Content extends Authenticated
{
    public function index()
    {
        Res::send('Content');
    }

    public function _create($data)
    {
        if (
            isset($data->duration)
            && isset($data->name)
            && isset($data->medium)
        ) :
        Res::json('Great');
        else :
            Res::status(400)->json(['empty' => 'Some fields are required']);
        endif;
    }

    public function get()
    {
        Res::json(ModelsContent::getContents());
    }
}
