<?php

class UsersController extends \BaseController {
    /**
     * @return mixed
     * Show user login form
     */
    public function getLoginForm(){
        return View::make('auth.login');
    }

    //return a list of users
    public  function index()
    {

    }


    /**
     * @return mixed
     * Process user login request
     */
    public function postLogin(){
        $data = [];
        $rules = array('email'=>'required','password'=>'required');
        $validator = Validator::make(Input::all(),$rules);

        if ($validator->passes()){
            $credentials = array('Email'=>Input::get('email'),
                'password'=>Input::get('password')
            );

            $var = Api::FindUserBy('email',Input::get('email'));
            $hashed = Hash::make(Input::get('password'));
            $data = [$var,$hashed];
           // return Response::json($data);


            if (Auth::attempt($credentials)){
                $user =  User::find(Auth::user()->UserProfileID);
                if ($user->ChangePassword){
                    Session::put('user__',$user->Email);

                    Auth::logout();

                    return Redirect::route('get.change.password');
                }
                return Redirect::intended('dashboard');
            }else{
                Session::flash('error_msg','Invalid login credentials or account not activated');
                return Redirect::to('login');
            }
        }

        //$data['error'] = "Username and/or Password is invalid";
        return View::make('auth.login')
            ->withErrors($validator);

    }

    /**
     * @return mixed
     * Load user profile view
     */
    public function profile(){
        $user = User::find(Auth::id());
        return View::make('auth.profile')
            ->with('entity',$user);
    }


    public function viewProfile($id){
        $user = User::find($id);
        if (!$user){
            Session::flash('message','User not found');
            return View::make('layouts.404');
        }
        return View::make('security.profile')
            ->with('entity',$user);
    }
    /**
     * @return mixed
     *
     */
    protected function getPasswordRemindResponse()
    {
        return Password::remind(Input::only("email"));
    }


    protected function isInvalidUser($response)
    {
        return $response === Password::INVALID_USER;
    }

    /**
     * @param $token
     * @return mixed
     *
     */
    public function reset($token)
    {
        if ($this->isPostRequest()) {
            $credentials = Input::only(
                    "email",
                    "password",
                    "password_confirmation"
                ) + compact("token");

            $response = $this->resetPassword($credentials);

            if ($response === Password::PASSWORD_RESET) {
                return Redirect::route("user/profile");
            }

            return Redirect::back()
                ->withInput()
                ->with("error", Lang::get($response));
        }

        return View::make("user/reset", compact("token"));
    }

    /**
     * @param $credentials
     * @return mixed
     * Reset user password
     */
    protected function resetPassword($credentials)
    {
        return Password::reset($credentials, function($user, $pass) {
            $user->password = Hash::make($pass);
            $user->save();
        });
    }

    /**
     * @return mixed
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        unset($_SESSION);

        return Redirect::to("/");
    }

    /**
     * @return mixed
     * Show user registration form
     */
    public function getRegistrationForm(){
        return View::make('auth.register');
    }



    /**
     * @return mixed
     * Register user process
     */
    public function postRegister(){
        #var_dump(Input::all());die();
        $rules = array(
            'FirstName' => 'required|max:255',
            'MiddleName' => 'required|max:255',
            'LastName' => 'required|max:255',
            'Mobile' => 'required|max:15',
            'IDNumber' => 'required|max:12',
            'email' => 'required|email|max:255|unique:UserProfile',
            'password' => 'required|confirmed|min:6',
        );

        $v = Validator::make(Input::all(),$rules);

        if ($v->passes()){
            $data['confirm_token'] = md5(uniqid(mt_rand(), true));
            $data['email']=Input::get('email');
            $input = Input::all();
            $params = ['CreatedBy'=>0,'status'=>1];
            $id = Api::CustomerProfileID($params);
            #dd($id);
            $creds = array(
                'FirstName' => $input['FirstName'],
                'MiddleName' =>$input['MiddleName'],
                'LastName' =>$input['LastName'],
                'IDNumber' => $input['IDNumber'],
                'Mobile'=>$input['Mobile'],
                'Email' => $input['email'],
                'CustomerProfileID'=>$id,
                'password' => $input['password'],
                'ConfirmationToken' => $data['confirm_token'],
                'Active'=>0,
                'ChangePassword'=>0
            );

            if ($this->register($creds)){
                $me = Api::FindUserBy('Email',$creds['Email']);
                $pro = CustomerProfile::findOrFail($id);
                $pro->CreatedBy = $me->id();
                $pro->save();

                $data['FirstName'] = $creds['FirstName'];
                $data['LastName'] = $creds['LastName'];
                $data['MiddleName'] = $creds['MiddleName'];
                $data['password'] = $creds['password'];
                $data['EmailTitle'] = 'New Account Information';
                $data['subject'] = $data['EmailTitle'];
                $data['email'] = $creds['Email'];

                Api::sendMail('ActivateAccount',$data);

                Session::flash('success_msg','User registration success. Please activate your account user the confirmation
                    link sent to your email address');
                return Redirect::route('home');
            }else{
                Session::flash('error_msg','Registration failure contact Support Team');
                return Redirect::route('register')
                    ->withInput(Input::except(array('password','password_confirmation')));
            }
        }
        return Redirect::route('get.register')
            ->withErrors($v)
            ->withInput(Input::except(array('password','password_confirmation')));
    }

    /**
     * @return mixed
     * Show user registration form
     */
    public function getAddAccount(){
        return View::make('users.new');
    }

    /**
     * @return mixed
     * Register user process as logged in admin
     */
    public function postAddAccount(){
        #var_dump(Input::all());die();
        $rules = array(
            'FirstName' => 'required|max:255',
            'MiddleName' => 'required|max:255',
            'LastName' => 'required|max:255',
            'Mobile' => 'required|max:15',
            'IDNumber' => 'required|max:12',
            'email' => 'required|email|max:255|unique:UserProfile',
            'password' => 'required|min:6',
        );

        $v = Validator::make(Input::all(),$rules);

        if ($v->passes()){
            $data['email']=Input::get('email');
            $input = Input::all();
            $params = ['CreatedBy'=>0,'status'=>1];
            $id = Api::CustomerProfileID($params);
            $creds = array(
                'FirstName' => $input['FirstName'],
                'MiddleName' =>$input['MiddleName'],
                'LastName' =>$input['LastName'],
                'IDNumber' => $input['IDNumber'],
                'Mobile'=>$input['Mobile'],
                'Email' => $input['email'],
                'CustomerProfileID'=>$id,
                'password' => $input['password'],
                'ConfirmationToken' => '',
                'Active'=>1,
                'ChangePassword'=>1

            );

            if ($this->register($creds)){
                $data['FirstName'] = $creds['FirstName'];
                $data['LastName'] = $creds['LastName'];
                $data['MiddleName'] = $creds['MiddleName'];
                $data['password'] = $creds['password'];
                $data['EmailTitle'] = 'New Account Information';
                $data['subject'] = $data['EmailTitle'];
                Api::sendMail('NewAccount',$data);

                Session::flash('success_msg','User Account created successfully');
                return Redirect::route('list.users');
            }else{
                Session::flash('error_msg','Registration failure contact Support Team');
                return Redirect::route('add.user')
                    ->withInput(Input::except(array('password','password_confirmation')));
            }
        }
        return Redirect::route('add.user')
            ->withErrors($v)
            ->withInput(Input::except(array('password','password_confirmation')));
    }

    /**
     * @param $creds
     * @param bool $activate
     * @return bool
     * Register user helper function
     */
    public function register($creds){

        return User::create([
            'FirstName' => $creds['FirstName'],
            'MiddleName' =>$creds['MiddleName'],
            'LastName' =>$creds['LastName'],
            'IDNumber' => $creds['IDNumber'],
            'Mobile'=>$creds['Mobile'],
            'Email' => $creds['Email'],
            'CustomerProfileID'=>$creds['CustomerProfileID'],
            'password' => Hash::make($creds['password']),
            'ConfirmationToken'=>$creds['ConfirmationToken'],
            'Active'=>$creds['Active'],
            'ChangePassword'=>$creds['ChangePassword']
        ]);

    }

    /**
     * @param $userId
     * @param $code
     * @return mixed
     * Activate user
     */
    public function activate($code){
        $user = Api::FindUserBy('ConfirmationToken',$code);
        //print_r($user);die();
        if ($user){
            if ($user->Active == 1){
                Session::flash('error_msg','Your account is already confirmed');
                return Redirect::to('login');
            }else{
                if ($user->ConfirmationToken === $code){
                    $user->ConfirmationToken = '';
                    $user->Active =1;
                    $user->save();

                    Session::flash('success_msg', 'Account Activation Successful Please login below.');
                    return Redirect::to('/login');
                }
            }
        }

        Session::flash('error_msg', 'Unable to activate user Try again later or contact Support Team.');
        return Redirect::to('/login');
    }




    public function toggleStatus($id){
        $user = User::find($id);
        if (!$user){
            Session::flash('error_msg','User not found');
            return Redirect::action('UsersController@index');
        }

        if ($user->active){
            $user->active = 0;
        }else{
            $user->active = 1;
        }
        $user->save();

        Session::flash('success_msg','User status changed successfully');
        return Redirect::action('UsersController@index');

    }

    public function getChangePassword()
    {
        Session::put('change_password_token',csrf_token());
        #dd(['user__'=>Session::get('user__'),'change_password_token'=>Session::get('change_password_token')]);

        return View::make('auth.reset',['user__'=>Session::get('user__'),'change_password_token'=>Session::get('change_password_token')]);
    }

    public function changePassword()
    {
        $token = Session::get('change_password_token');
        $rules = array(
            'user__'=>'required|exists:UserProfile,Email',
            'change_password_token'=>"required|in:$token",
            'password'=>'required|confirmed|min:6',
        );
        $messages = array(
            'in' => 'Invalid request token',
        );


        $valid = Validator::make(Input::all(),$rules,$messages);
        if ($valid->passes()){
            //var_dump(Input::all());die();
            $user = Api::FindUserBy('Email',Input::get('user__'));
            $user->password = Hash::make(Input::get('password'));
            $user->ChangePassword = '';
            $user->save();

            Session::flash('success_msg','You have successfully changed your password');
            return Redirect::route('my.profile');
        }
        //var_dump($valid->errors());die();
        return Redirect::action('UsersController@getChangePassword')
            ->withErrors($valid);
    }

    public function getUsersList(){
        $profileID = Auth::user()->CustomerProfileID;

        $users = User::where('CustomerProfileID','=',$profileID)->get();

        return View::make('users.index',['entities'=>$users]);
    }

    /**
     * Show profile of current logged in user
     * @return mixed
     */
    public function showMyProfile()
    {
        $user = User::findOrFail(Auth::id());
        return View::make('auth.profile',['entity'=>$user]);
    }

    /**
     * Show user profile as per user
     * @param $id
     * @return mixed
     */
    public function showUserProfile($id)
    {
        $user = User::findOrFail($id);
        return View::make('auth.profile',['entity'=>$user]);
    }


}