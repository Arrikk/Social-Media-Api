<?php

namespace App\Controllers;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Lists\Lists as ListsLists;
use App\Models\Lists\NewList;
use Core\Http\Res;

class Lists extends Authenticated
{
    /**
     * Add or remove from a list
     * @return bool>object>array
     */
    public function _action($data)
    {
        // Res::json($this->user);
        $id = $this->route_params['list'] ?? null;
        if (
            isset($data->userTo)
            && !empty($data->userTo)
            && $id
        ) :
            $data->list = $id;
            $data->userCurrent = $this->user->id;

            Res::json([
                'status' => true,
                'message' => ListsLists::addOrRemove($data)
            ]);

            Res::status(400)->json(['error' => 'Unable to bookmark feed']);
        else :
            Res::status(400)->json(['error' => 'Some action required']);
        endif;
    }

    /**
     * Lists for logged in user
     * @return bool>object>array
     */
    public function _lists($data)
    {
        Res::json(ListsLists::getLists($this->user->id, $data->check ?? null));
    }
    
    /**
     * Get users and details of a list
     * @return bool>object>array
     */
    public function _details()
    {
        if(isset($this->route_params['slug'])):
            $slug = $this->route_params['slug'];
            Res::json(ListsLists::getlistDetails($this->user->id, $slug));
        else:
            Res::status(400)->json(['error' => 'Error occured']);
        endif;
    }

    public function _new($data)
    {
        if (
            isset($data->name)
            && $data->name !== ''
            && isset($data->id)
        ) :
            $this->isUser($data->id);
            Res::json(NewList::makeList($this->user->id, $data->name));
        else :
            Res::status(400)->json(['error' => "Action Denied"]);
        endif;
    }

    public function _update($data)
    {
        if (
            isset($data->name)
            && !empty($data->name)
            && isset($data->user)
            && !empty($data->user)
            && isset($this->route_params['list'])
        ) :
            $this->isUser($data->user);
            $data->listId = (int) $this->route_params['list'];
            Res::json(ListsLists::updateList($data));
        else :
            Res::status(400)->json(['error' => "Action Denied"]);
        endif;
    }
}
