<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;

class RoleService {

    static function storeRole(array $data)
    {
        $role = Role::create($data);
        $i = 0;
        foreach($data['permissions[]'] as $id){
            Permission::find($id) ? $role->permissions()->attach($id) : $i++;
        }
        if($i > 0)
        {
            return "Role created but $i permissions couldn\'t be found";
        }
        return 'Role created successfully';
    }

}