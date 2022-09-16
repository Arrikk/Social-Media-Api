<?php

namespace  App\Controllers\Others;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Withdrawals as ModelsWithdrawals;
use Core\Http\Res;

class Withdrawals extends Authenticated
{
    /**
     * Make a witihdrawal request 
     * accessible to all user and admin
     */
    public function _create($data)
    {
        if(isset($data->user) && isset($data->amount)):
            $this->isUser($data->user);
            Res::json(ModelsWithdrawals::make($data));
        else:
            Res::status(400)->json(['error' => "Invalid Request"]);
        endif;
    }

    /**
     * Get all user withdrawals
     * accessible to only admins
     */
    public function _get($data)
    {
        $this->isAdmin();
        $Withdrawals = ModelsWithdrawals::Withdrawals($data);
        Res::json($Withdrawals);
    }

    /**
     * get withdrawal details
     * accessible to only admins
     */
    public function _single()
    {
        $this->isAdmin();
        $id = $this->route_params['id'];
        Res::json(ModelsWithdrawals::withdrawalDetails($id));
    }

    public function _count()
    {
        // $this->admin();
        Res::json(ModelsWithdrawals::withdrawalsCount());
    }

    /**
     * Make a withdrawal action(accept or decline)
     * accessible to only admins
     */
    public function _action($data)
    {
        $this->isAdmin();
        $type = $data->action;
        $id = $data->id;
        Res::json(ModelsWithdrawals::withdrawalAction($id, $type));

    }

    /**
     * Get a user withdrawal history
     * accessible to all
     */
    public function _history()
    {
        // $user = $this->user->id;
        // Res::json(ModelsWithdrawals::withdrawalHistory($user));
    }
    
    public function _myWithdrawals()
    {
        Res::json(ModelsWithdrawals::myWithdrawals($this->user->id));
    }
}
