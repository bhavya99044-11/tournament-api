<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function getRoles(){
        $roles=Role::all();
        return response()->json($roles,200);
    }

    public function assignRolePermission(Request $request){
        $role=Role::find($request->role_id);
        $role->givePermissionTo($request->permission);
        return response()->json(['message'=>'Permission assigned successfully'],200);
    }

    public function revokeRole(Request $request){
        try{
        $user=User::find(1);
        $user->removeRole($request->role);
        return response()->json(['message'=>'Role revoked successfully'],200);
        }
        catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()],404);
        }
    }

    public function revokeRolePermission(Request $request){
        $role=Role::find($request->role_id);
        $role->revokePermissionTo($request->permission);
        return response()->json(['message'=>'Permission revoked successfully'],200);
    }

    public function updateRolePermission(Request $request){
        try{
        $role=Role::find($request->role_id);
        $role->syncPermissions($request->permissions);
        return response()->json(['message'=>'Permission updated successfully'],200);
        }catch(\Exception $e){
            return response()->json(['message'=>$e->getMessage()],404);
        }
    }

    public function permissionCreate(Request $request){
        $permission = Permission::create(['name' => $request->permission]);
        return response()->json(['message'=>'Permission created successfully'],200);
    }

    public function assignRoleToUser(Request $request){
        try{
       $user=User::find($request->user_id);
       $user->assignRole($request->role);
       return response()->json(['message'=>'Role assigned successfully'],200);
    }catch(\Exception $e){
        return response()->json(['message'=>$e->getMessage()],404);
    }
    }
}
