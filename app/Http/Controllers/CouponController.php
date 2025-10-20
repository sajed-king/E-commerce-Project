<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Coupon_User;
use App\Models\Order;
use Illuminate\Http\Request;

class CouponController extends Controller
{

public function apply(Request $request){

$request->validate([
    'code'=> ['required','string'],
    'order_amount'=>['required','numeric']
]);

 $coupon = Coupon::where('code', $request->code)->first();
    // return $coupon->isValidForUser($request->user(),$coupon->id);


if(!$coupon || !$coupon->isValidForUser($request->user(),$coupon->id)) {  
    return response()->json(['message'=> 'code is invalid']);  
}  

// if ($coupon->min_order && $request->orderAmount < $coupon->min_order) {  
//     return ['success' => false, 'message' => 'Minimum order amount not met'];  
// }  

$discount = $this->calculateDiscount($coupon, $request->order_amount,$request->session_id);  

return  response()->json([
    'success' => true,  
    'discount' => $discount,  
    'coupon' => $coupon->only('code', 'type', 'value')]
  );      
    

}    

protected function calculateDiscount(Coupon $coupon, float $amount,$session_id)  
{
    
    if($coupon->type === 'fixed'){
     
    return min($coupon->value, $amount);

    }else{
    return  round($amount * ($coupon->value / 100), 2);
    }
        
           
        
        
        
        
}  

}
