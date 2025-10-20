<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
public function coupon_user(){

    return $this->hasMany(Coupon_User::class);
    }


public function isValidForUser(User $user,$coupon_id)  
{  

    

     
        // Check if coupon is active  
        if (!$this->is_active) {  
            return false;  
        }  
    
        // Validate date range  
        $currentDate = now();  
        if(!($currentDate >= $this->valid_from && $currentDate < $this->valid_to)) {  
            return false;  
        }  
    
        $total_usage=Coupon_User::where('coupon_id',$coupon_id)->count() ?? 0;
        // Check total usage limit  
        if ($this->usage_limit !== null && $total_usage >= $this->usage_limit) {  
            return false;  
        }  
    
        // // Check per-user limit  
        if ($this->per_user_limit !== null) {  
             $userCoupon = Coupon_User::select('times_used')->where('user_id', $user->id)->where('coupon_id',$coupon_id)->first() ?? 0;
            


                if ($userCoupon->times_used >= $this->per_user_limit) {  
                    return false;  
                }  
        }  
    

        return true;  
    }  

}  



