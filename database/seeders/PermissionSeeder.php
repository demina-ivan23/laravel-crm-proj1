<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Prospect management permissions
        Permission::create([
            'title' => 'prospect-read-web'
        ]);
        Permission::create([
            'title' => 'prospect-read-api'
        ]);
        Permission::create([
            'title' => 'prospect-write-web'
        ]);
        Permission::create([
            'title' => 'prospect-write-api'
        ]);
        Permission::create([
            'title' => 'prospect-edit-web'
        ]);
        Permission::create([
            'title' => 'prospect-edit-api'
        ]);
        Permission::create([
            'title' => 'prospect-delete-web'
        ]);
        Permission::create([
            'title' => 'prospect-delete-api'
        ]);
        //ProspectState management permissions
        Permission::create([
            'title' => 'prospect_state-read-web'
        ]);
        Permission::create([
            'title' => 'prospect_state-read-api'
        ]);
        Permission::create([
            'title' => 'prospect_state-write-web'
        ]);
        Permission::create([
            'title' => 'prospect_state-write-api'
        ]);
        Permission::create([
            'title' => 'prospect_state-edit-web'
        ]);
        Permission::create([
            'title' => 'prospect_state-edit-api'
        ]);
        //Product management permissions
        Permission::create([
            'title' => 'product-read-web'
        ]);
        Permission::create([
            'title' => 'product-read-api'
        ]);
        Permission::create([
            'title' => 'product-write-web'
        ]);
        Permission::create([
            'title' => 'product-write-api'
        ]);
        Permission::create([
            'title' => 'product-edit-web'
        ]);
        Permission::create([
            'title' => 'product-edit-api'
        ]);
        //Order management permissions
        Permission::create([
            'title' => 'order-read-web'
        ]);
        Permission::create([
            'title' => 'order-read-api'
        ]);
        Permission::create([
            'title' => 'order-write-web'
        ]);
        Permission::create([
            'title' => 'order-write-api'
        ]);
        Permission::create([
            'title' => 'order-edit-web'
        ]);
        Permission::create([
            'title' => 'order-edit-api'
        ]); 
        Permission::create([
            'title' => 'order-delete-web'
        ]);
        Permission::create([
            'title' => 'order-delete-api'
        ]);
        //OrderStatus management permission
        Permission::create([
            'title' => 'order_status-read-web'
        ]);
        Permission::create([
            'title' => 'order_status-read-api'
        ]);
        Permission::create([
            'title' => 'order_status-write-web'
        ]);
        Permission::create([
            'title' => 'order_status-write-api'
        ]);
        Permission::create([
            'title' => 'order_status-edit-web'
        ]);
        Permission::create([
            'title' => 'order_status-edit-api'
        ]);
        //Order chart reading permission
        Permission::create([
            'title' => 'order-chart-read-web'
        ]);
        Permission::create([
            'title' => 'order-chart-read-api'
        ]);
        //User self-management permissions
        Permission::create([
            'title' => 'user-read-self-web'
        ]);
        Permission::create([
            'title' => 'user-read-self-api'
        ]);
        Permission::create([
            'title' => 'user-edit-self-web'
        ]);
        Permission::create([
            'title' => 'user-edit-self-api'
        ]);

        //User all-management permissions
        Permission::create([
            'title' => 'user-read-all-web'
        ]);
        Permission::create([
            'title' => 'user-read-all-api'
        ]);
        Permission::create([
            'title' => 'user-write-web'
        ]);
        Permission::create([
            'title' => 'user-write-api'
        ]);
        Permission::create([
            'title' => 'user-edit-all-web'
        ]);
        Permission::create([
            'title' => 'user-edit-all-api'
        ]);
        //User role permissions:
        Permission::create([
            'title' => 'user-give-role-web'
        ]);
        Permission::create([
            'title' => 'user-give-role-api'
        ]);
        Permission::create([
            'title' => 'user-remove-role-web'
        ]); 
        Permission::create([
            'title' => 'user-remove-role-api'
        ]);
        //Role management permissions:
        Permission::create([
            'title' => 'role-read-web'
        ]);
        Permission::create([
            'title' => 'role-read-api'
        ]); 
        Permission::create([
            'title' => 'role-write-web'
        ]);
        Permission::create([
            'title' => 'role-write-api'
        ]);
        Permission::create([
            'title' => 'role-edit-web'
        ]);
        Permission::create([
            'title' => 'role-edit-api'
        ]);
        //Untouchability for superadmins,
        //which means this users cant be edited by other users, 
        //given or taken from roles 
        //neither via web nor via api
        Permission::create([
            'title' => 'be_untouchable'
        ]);
        //Dashboard permissions
        Permission::create([
            'title' => 'states-dashboard'
        ]);
        Permission::create([
            'title' => 'users-roles-dashboard'
        ]);
        Permission::create([
            'title' => 'prospects-products-orders-dashboard'
        ]);
    }
}
