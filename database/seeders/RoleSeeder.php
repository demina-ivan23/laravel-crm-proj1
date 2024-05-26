<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $observer = Role::create([
            'title' => 'Observer',
            'description' => 'observer'
        ]);
        $writer = Role::create([
            'title' => 'Writer',
            'description' => 'writer'
        ]);
        $editor = Role::create([
            'title' => 'Editor',
            'description' => 'editor'
        ]);
        $admin = Role::create([
            'title' => 'Admin',
            'description' => 'admin'
        ]);
        $superadmin = Role::create([
            'title' => 'Superadmin',
            'description' => 'superadmin'
        ]);
        foreach (Permission::all() as $permission) {
            $superadmin->permissions()->attach($permission->id);
            if ($permission->title !== 'be_untouchable') {
                $admin->permissions()->attach($permission->id);
            }
        }
        $arrayForObserver = ['prospect-read-web', 'prospect-read-api', 'product-read-web', 
        'product-read-api', 'order-read-web', 'order-read-api', 'user-read-self-web', 'user-read-self-api'];
        $arrayForWriter = ['prospect-write-web', 'prospect-write-api', 'product-write-web',
         'product-write-api', 'order-write-web', 'order-write-api', 'user-write-self-web', 'user-write-self-api'];
        $arrayForEditor = ['prospect-edit-web', 'prospect-edit-api', 'product-edit-web', 
        'product-edit-api', 'order-edit-web', 'order-edit-api', 'user-edit-self-web', 'user-edit-self-api',
         'prospect-read-web', 'prospect-read-api', 'product-read-web', 'product-read-api', 'order-read-web', 
         'order-read-api', 'user-read-self-web', 'user-read-self-api'];
         foreach($arrayForObserver as $forObserver){
            $observer->permissions()->attach(Permission::where('title', $forObserver)->first());
         }
         foreach($arrayForWriter as $forWriter){
            $writer->permissions()->attach(Permission::where('title', $forWriter)->first());
         }
         foreach($arrayForEditor as $forEditor){
            $editor->permissions()->attach(Permission::where('title', $forEditor)->first());
         }
    }
}
