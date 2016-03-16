<?php 

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Department;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/tickets';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest', ['except' => ['logout', 'showRegistrationForm', 'register']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, ['name' => 'required|max:255', 'email' => 'required|email|max:255|unique:users', 'password' => 'required|confirmed|min:6', 'password_confirmation' => 'required|min:6', 'staff_nos' => 'required|min:8|max:8|unique:users', 'department_id' => 'required']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $role = Role::where('name', '=', 'agent')->first();
        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => bcrypt($data['password']), 'staff_nos' => $data['staff_nos'], 'department_id' => $data['department_id']]);
        $user->attachRole($role);
        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        $departments = Department::lists('name', 'id');
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        $data = array('departments' => $departments);
        return view('auth.register', $data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
            $request, $validator);
        }

        $this->create($request->all());

        session()->flash('notification', 'User has been created successfully');
        session()->flash('notification_type', 'alert-success');
        session()->flash('notification_important', true);

        return redirect($this->redirectPath());
    }
}