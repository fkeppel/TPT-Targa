<?php

class UsersController extends BaseController {

    /**
     * Display a listing of the resource.
     * GET /project
     *
     * @return Response
     */
    protected $layout = "main";

    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getDashboard')));
    }

    public function getRegister() {
        $this->layout->content = View::make('users.register');
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), User::$rules);

        if ($validator->passes()) {
            $user = new User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();

            return Redirect::to('users/login')->with('message', 'Thanks for registering!');
        } else {
            return Redirect::to('users/register')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
        }
    }

    public function getLogin() {
        $status['anab'] = 'login';
        $status['link'] = 'users/login';
        $status['user'] = 'nn';
        $params['status'] = $status;
        $params['content'] = View::make('users.login');

        return View::make('main', $params);
    }

    public function postSignin() {
        $user = Input::get('email');
        if (strtoupper($user) == 'MKÖ'){
            //echo('MKÖ');exit;
            $user = 'mk2';
        }
        if (Auth::attempt(array('username' => Input::get('email'), 'password' => Input::get('password')))) {
            return Redirect::to('users/dashboard')->with('message', 'You are now logged in!');
        } else {
            return Redirect::to('users/login')
                            ->with('message', 'Kombination Benutzername/Passwort ist nicht hinterlegt!')
                            ->withInput();
        }
    }

    public function getDashboard() {
        $this->layout->content = View::make('users.dashboard');
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::to('users/login')->with('message', 'Your are now logged out!');
    }

}
