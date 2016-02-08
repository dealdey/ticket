<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = new Role();
        $super->name         = 'super-admin';
        $super->display_name = 'Super Adminstrator';
        $super->description  = 'User is the super administrator of the application';
        $super->save();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator';
        $admin->description  = 'User is allowed to manage and edit other users';
        $admin->save();

        $agent = new Role();
        $agent->name         = 'agent';
        $agent->display_name = 'Platform Agent';
        $agent->description  = 'User is allowed to manage and edit tickets';
        $agent->save();

        $user = User::where('email', '=', 'adebayo@dealdey.com')->first();
        $user->attachRoles(array($super, $admin));

        $createUser = new Permission();
        $createUser->name         = 'create-user';
        $createUser->display_name = 'Create Users';
        $createUser->description  = 'can create new users';
        $createUser->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = 'Edit Users';
        $editUser->description  = 'can edit existing users';
        $editUser->save();

        $super->attachPermissions(array($createUser, $editUser));
    }
}
