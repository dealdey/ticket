<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class UserController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', ['user' => Auth::user()]);
    }
    
    public function update(Request $request, $id)
    {
        $changePassword = trim($request->input('password')) !== '' ? true : false;
        $user = Auth::user();
        $validate = [
            'name' => 'required|max:255',
        ];
        if($changePassword) {
            \Log::info('validate password');
            $validate = [
                'name' => 'required|max:255',
                'password' => 'required|min:6',
                'new_password' => 'required|min:8',
            ];
        }
        $this->validate($request, $validate);
        $update = $changePassword ? $request->only('name', 'password', 'new_password') : $request->only('name');
        $matchPassword = $changePassword ? \Hash::check($update['password'], $user->password) : false;
        if(trim($update['name']) !== ''){
            if ($changePassword && $matchPassword) {
                $user->password = bcrypt($update['new_password']);
                $user->name = $update['name'];
                $user->save();
                Auth::guard($this->getGuard())->login($user);
                session()->flash('notification', 'Done! Profile updated successfully (Kindly logout and login again to confirm your password change)');
                session()->flash('notification-type', 'alert-success');
                \Log::info('got here, update method - password changed');
            }
            elseif ($changePassword && !($matchPassword)) {
                session()->flash('notification', 'Oh snap! Seems your old password is incorrect');
                session()->flash('notification-type', 'alert-danger');
                \Log::info('got here, update method - invalid old password');
            }
            else {
                $user->name = $update['name'];
                $user->save();
                session()->flash('notification', 'Done! Your name was updated successfully');
                session()->flash('notification-type', 'alert-success');
                \Log::info('got here, update method - name update');
            }
        }
        else {
            session()->flash('notification', 'Oh snap! Seems your password is incorrect');
            session()->flash('notification-type', 'alert-danger');
            \Log::info('got here, update method - invalid password');
        }
        session()->flash('notification-important', true);
        return redirect()->route('profile');
    }
    
    /**
     * Get the guard to be used during password change.
     *
     * @return string|null
     */
    protected function getGuard()
    {
        return property_exists($this, 'guard') ? $this->guard : null;
    }
}
