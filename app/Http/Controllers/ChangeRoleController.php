<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChangeRoleController extends Controller
{
    public function change_role($id){
    
        

 $user=User::where('id',$id)->first();     
    $user->update(['is_admin' => !$user->is_admin]);
    
    return response()->json('User Role has been Updated');
}



}