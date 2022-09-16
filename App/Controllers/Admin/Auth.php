<?php
namespace App\Controllers\Admin;

use App\Auth as AppAuth;
use Core\Controller;
use Core\Http\Res;
use Core\View;

class Auth extends Controller
{

    protected function before()
    {
        if(isset($_SESSION['token'])):
            $this->redirect('/dashboard/index');
        endif;
    }

    public function _login()
    {
        View::render('auth/login.html', ['title' => 'Admin Login']);
    }

    public function _setLogin($data)
    {
        $_SESSION['token'] = $data->token;
        Res::json($_SESSION['token']);
    }

    public function _forgot()
    {
        View::render('auth/forgot.html', ['title' => 'Forgot Password']);
    }

    public function logout()
    {
        AppAuth::logout();
        $this->redirect('/auth/login');
    }
}