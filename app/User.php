<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Kordy\Ticketit\Models\Category;
use Kordy\Ticketit\Models\Agent;
use \Auth;

class User extends Authenticatable
{
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'staff_nos', 'department_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function department()
    {
        $id = auth()->user()->id;
        return Department::where('id', '=', $id)->first();
    }
    
    public function category()
    {
        $user = auth()->user();
        $id = $user->id;
        if($user->ticketit_agent) 
        {
            return Agent::find($id)->categories;
        }
        elseif ($user->ticketit_admin) {
            return ['Administrator'];
        }
    }
}
