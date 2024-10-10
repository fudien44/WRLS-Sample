<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{ /**
    * Run the database seeds.
    */
   public function run(): void
   {
       $user = User::create([
            'fname'=> 'Aldwin Carl',
            'mname'=>'Lozada',
            'lname'=>'Llenado',
           'email' => 'aldwincarl.acl@gmail.com',
           'password' => bcrypt('123456'),
           'role'=>'admin',
           'contactno'=>null
       ]);
       
       $role = Role::create(['name' => 'admin']);
        
       $permissions = Permission::pluck('id','id')->all();
      
       $role->syncPermissions($permissions);
        
       $user->assignRole([$role->id]);
   }
}
