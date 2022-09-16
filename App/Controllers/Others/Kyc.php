<?php

namespace  App\Controllers\Others;

use App\Controllers\Authenticated\Authenticated;
use App\Models\Kyc as ModelsKyc;
use Core\Http\Res;

class Kyc extends Authenticated
{

    public function _get($data)
    {
        // $this->isAdmin();
        $kyc = ModelsKyc::kyc($data);
        Res::json($kyc);
    }

    public function _count()
    {
        Res::json(ModelsKyc::kycCount());
    }

    public function _single()
    {
        $id = $this->route_params['id'] ?? 0;
        Res::json(ModelsKyc::kycById($id)); 
    }

    public function _action($data)
    {
        $type = $data->action;
        $id = $data->id;
        $currentUser = $this->user->id;
        Res::json(ModelsKyc::kycAction($id, $type, $currentUser));
    }

    public function _start()
    {
        Res::json(['token' => ModelsKyc::startKyc($this->user->id)]);
    }

    public function _upload($data)
    {
        $token = $this->route_params['token'];
        Res::json(['Ready to upload' => $token]);
    }
}
