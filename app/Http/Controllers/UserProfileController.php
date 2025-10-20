<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
public function index(Request $request){

$data=[
'user'=> new UserResource(User::where('id',$request->user()->id)->get()),
'order'=>Order::where('user_id',$request->user()->id)->get(),
];


return response()->json($data) ;
}

public function updateProfile(Request $request)  
    {  
        $user = $request->user();  

        $request->validate([  
            'name' => 'required|string|max:255',  
            'email' => 'required|email|unique:users,email,' . $user->id,  
        ]);  

        $user->update($request->only(['name', 'email']));  

        return response()->json([  
            'message' => 'Profile updated successfully.',  
            'name' => $user->name,
            'email'=>$user->email  
        ]);  
    }
  public function updatepassword(Request $request)  
    {  

   
        

 $admin=User::find($request->user()->id);
$request->validate([
    'current_password'=>['required'],
    'new_password'=>['required','min:10']
]);

if($request->current_password !== $admin->password ){
return response()->json(['error'=>'the password is incorrect']) ;    
}


$admin->update([
    'password'=> Hash::make($request->new_password)
]);

return response()->json(["message"=>"i am sajed"]);



        // $request->validate([  
        //     'current_password' => 'required|string',  
        //     'new_password' => ['required', Rules\Password::defaults()],  
        // ]);  

        // $admin = $request->user();  

        // if (!Hash::check($request->current_password, $admin->password)) {  
        //     return response()->json(['error' => 'Current password is incorrect.'], 422);  
        // }  

        // $admin->update(['password' => Hash::make($request->new_password)]);  

        // return response()->json(['message' => 'Password updated successfully.']);  
    }
    // Get admin preferences (e.g., theme, language)  
    public function getPreferences(Request $request)  
    {  
        return response()->json([  
            'preferences' => $request->user()->settings  
        ]);  
    }  

    // Update preferences  
    public function updatePreferences(Request $request)  
    {  
        $request->validate([  
            'theme' => 'nullable|string|in:light,dark',  
            'language' => 'nullable|string|in:en,es,fr',  
        ]);  

        $user = $request->user();  
        $user->settings = $request->all();  
        $user->save();  

        return response()->json([  
            'message' => 'Preferences updated.',  
            'preferences' => $user->settings  
        ]);  
}




}
