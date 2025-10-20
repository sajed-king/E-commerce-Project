<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Admin_SettingsController extends Controller
{
    
    // Get admin profile  
    public function getProfile(Request $request)  
    {  
        return response()->json([  
            'admin' => $request->user()  
        ]);  
    }  

    // Update profile (name, email)  
    public function updateProfile(Request $request)  
    {  
        $admin = $request->user();  

        $request->validate([  
            'name' => 'required|string|max:255',  
            'email' => 'required|email|unique:users,email,' . $admin->id,  
        ]);  

        $admin->update($request->only(['name', 'email']));  

        return response()->json([  
            'message' => 'Profile updated successfully.',  
            'admin' => $admin  
        ]);  
    }  

    // Update password  
    public function updatepassword(Request $request)  
    {  

        
 $admin=User::find($request->user()->id);

$request->validate([
    'current_password'=>['required'],
    'new_password'=>['required','min:10']
]);

if(!Hash::check($request->current_password,$admin->password) ){
        return response()->json(['error' => 'Current password is incorrect.'], 422);  
}


$admin->update([
    'password'=> Hash::make($request->new_password)
]);

return response()->json(["message"=>"password updated successfully"]);



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

        $admin = $request->user();  
        $admin->settings = $request->all();  
        $admin->save();  

        return response()->json([  
            'message' => 'Preferences updated.',  
            'preferences' => $admin->settings  
        ]);  
    }  
}  

