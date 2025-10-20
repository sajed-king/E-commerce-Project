<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;  
use Illuminate\Auth\Events\PasswordReset;  
use Illuminate\Support\Str;  
use App\Notifications\CustomResetPasswordNotification;

class AuthController extends Controller
{
use HttpResponses; 

public function register(RegisterRequest $request){

    $request->validated($request->all());
    


    $user=User::create([

        "name"=> $request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'is_admin'=> 0
        
    ]);

    return $this->success([
'user'=>$user,
'token'=> $user->createToken("API Token of ". $user->name)->plainTextToken

    ],"You've been registered",200);
    
    }

    public function login(LoginController $request){
   $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]); //Verifying whether the user exists in DB if it is,let  him pass if not, ban him from logging in 
if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    return $this->error('',"The Credentials didn't match");
}

$user=User::where('email','=',$request->email)->first();

return $this->success([
'user'=> $user,
'token'=> $user->createToken('API Token of'. $user->name)->plainTextToken

],'You have logged in successfully',200);






    }

public function logout(Request $request){




Auth::user()->CurrentAccessToken()->delete();
return $this->success('','you have logged out');


}





  
    // app/Http/Controllers/Auth/ForgotPasswordController.php  

public function sendResetLinkEmail(Request $request)  
{  
    $request->validate(['email' => 'required|email']);  
    
    $user = User::where('email', $request->email)->first();  
    
    if($user){  
        $token = Password::createToken($user);
        $user->notify(new CustomResetPasswordNotification($token));  
        
        return response()->json(['message' => 'Reset link sent']);  
    }  
    
    return response()->json(['message' => 'User not found'], 404);  
}  

    public function resetPassword(Request $request)  
    {  
        $request->validate([  
            'token' => 'required',  
            'email' => 'required|email',  
            'password' => 'required|min:8|confirmed',  
        ]);  

        $status = Password::reset(  
            $request->only('email', 'password', 'password_confirmation', 'token'),  
            function ($user, $password) {  
                $user->forceFill([  
                    'password' => Hash::make($password),  
                    'remember_token' => Str::random(60),  
                ])->save();  

                 event(new PasswordReset($user));  
                
                // Optional: Revoke all tokens if needed  
                // $user->tokens()->delete();  
            }  
        );  

        return $status === Password::PASSWORD_RESET  
            ? response()->json(['status' => __($status)])  
            : response()->json(['email' => [__($status)]], 422);  
    }  
  
}
