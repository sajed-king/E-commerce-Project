<?php

namespace App\Http\Controllers;

use App\Http\Traits\HttpResponses;
use App\Models\Address;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Collection;
class CheckoutProcessController extends Controller
{

    use HttpResponses;
//     public function Stripe_Secret_Key(){

//         return   new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        
        
//     }

//     public function shipping_information(Request $request){


// $request->validate([
// 'street_address'=> ['required'],
// 'city'=>['required','string'],
// 'state'=>['required','string'],
// 'country'=>['required'],


// ]);
    

// $data=Address::create([
// 'street_address'=> $request->street_address,
// 'city'=> $request->city,
// 'state'=>$request->state,
// 'country'=>$request->country,
// 'user_id'=>$request->auth()->user()->id,

// ]);


// return $this->success($data,'Success');

//     }
    
    
//          public function need_prescription(Product $product){
    
            
//             if($product->need_prescription === 1)
//             return $this->success("need prescription");
         
//         }
    
//         public function checkoutprocess(Request $request ){
           
    
//             $stripe= $this->Stripe_Secret_Key();
//             $products=Product::all(); 
//            $LineItems=[];
//            $total_price=0; 
//            foreach($products as $product){
    
                              
    
//     $total_price +=$product->price;
    
    
//             $LineItems[]= [
                
//                     'price_data' => [
//                       'currency' => 'usd',
//                       'product_data' => [
//                         'description'=> $product->description,
//                         'name' => $product->name,
//                       ],
//                       'unit_amount' => $product->price *100,
//                     ],
//                     'quantity' => $product->amount,
                  
//             ];
    
    
    
//            }
       
    
    
    
//             $checkout_session = $stripe->checkout->sessions->create([
//               'line_items' => $LineItems,
//               'mode' => 'payment',
//               'success_url' => "http://127.0.0.1:8000/checkoutprocess/success?session_id={CHECKOUT_SESSION_ID}",
//               'cancel_url' => "http://127.0.0.1:8000/checkoutprocess/cancel?session_id={CHECKOUT_SESSION_ID}",
            
//             ]);
            
//             header("HTTP/1.1 303 See Other");
//             header("Location: " . $checkout_session->url);
    
//             $order=new Order();
//             $order->status="unpaid";    
//             $order->total_price=$total_price; 
//             $order->user_id=1; 
//             $order->session_id=$checkout_session->id;
//             $order->save();
           
            
//     foreach( $LineItems as $LineItem){
//     $order_Item=new Order_items();
//     $product=Product::where('name',$LineItem['price_data']['product_data']['name'])->first();
//     $order_Item->product_id=$product->id;
//     //need to be modified
//     $order_Item->amount=$LineItem['quantity'];
//     $order_Item->price_order=$product->price;
//     $order_Item->order_id=$order->id;
//     $order_Item->save();
    
//     if($product->amount >= $LineItem['quantity']){
//         $product->amount -=1;
//         $product->save();
//     }else{
//         throw new \Exception("Insuffecient stock for product {$LineItem['price_data']['product_data']['name']}");
//     }
    
    
//     }
    
    
    
    
    
    
    
    
//             return redirect($checkout_session->url);
    
    
    
//         }
    
//     public function success_stripe(Request $request){
//         $stripe=$this->Stripe_Secret_Key();
    
//         $sessionId=$request->get('session_id');
//      try{
        
//         $session = $stripe->checkout->sessions->retrieve($sessionId, [  
//             'expand' => ['line_items'], // Expand the line_items array  
       
//         ]);
        
//         if(!$session){
     
//         throw new NotFoundHttpException;
     
//         } 
    
        
         
//         // $customer = $stripe->customers->retrieve($session->customer_details->name);
//      $order= Order::where('session_id',$session->id)->where('status','unpaid')->first();
     
//      if(!$order){
     
//          throw new NotFoundHttpException();
//      }
//      $order->status='paid';
//      $order->save();
    
    
//     //  return $this->success("Ok");
    
    
//         return view("success" ); 
    
//      }catch(\Exception $e){
//     throw new NotFoundHttpException();
    
    
//      }
     
       
//     }
    
    




    

// }



//     public function cancel($sessionId){
    
//         $order=Order::where('session_id',$sessionId);
//         $order->delete();
    
//         return "Failed";
//     }
    
public function check(Request $request){

$lang = app()->getLocale();
$products=new Collection();
$total_price=0;
$counter=count($request->items);
for($i=0;$i<$counter;$i++){

$products->push(Product::where("name_{$lang}",$request->items[$i]['name'])->first());
$total_price +=($products->get($i)->price?? 0) * $request->items[$i]['quantity'];


}
$products=$products->filter(function($product){
    return !is_null($product);
});


    
   
    

    $order=new Order();
    $order->status="unpaid";    
    $order->total_price=$total_price; 
    $order->user_id=auth()->user()->id; 
    $order->session_id=uniqid('ORD_');
    $order->save();
    
    
for( $i=0;$i<$counter;$i++){
$order_Item=new Order_items();
 $product=Product::where("name_{$lang}",$products->get($i)->name_en)->first();
 $order_Item->product_id=$product->id;
//need to be modified

$order_Item->amount=$request->items[$i]['quantity'];
$order_Item->price_order=$product->price;
$order_Item->order_id=$order->id;
$order_Item->save();

if($product->amount >= $request->items[$i]['quantity']){
$product->amount -=$request->items[$i]['quantity'];
$product->save();
}else{
throw new \Exception("Insuffecient stock for product {$request->items[$i]['name']}");
}


}

return response()->json([
    'order_id' => $order->id,
    'order_number' => $order->session_id,
    'order_items'=> Order_items::where('order_id',$order->id)->get(),
    'price' => $order->total_price
]);


}
    
public function paymentprocess(Request $request,$id)
    {
        
            $order = Order::where('id',$id)->first();
            if($order->status !='paid'){

    $request->validate([  
        'card_number' => 'required|string',  
        'expiration_date' => 'required|string',  
        'cvv' => 'required|string',
        'street_address'=>'required|string',
        'city'=>'required|string',
        'phone_number'=>'required|string'  
    ]);  


    // Process payment logic here
    // In production, implement actual payment processing
    // For demo purposes, assume successful payment
    
    $address=Address::create([
        'street_address'=> $request->street_address,
        'city'=> $request->city,
        'phone_number'=> $request->phone_number,
        'user_id'=> $request->user()->id
    ]            
);

    // Update order status
    $order->update([
        'status' => 'paid', 
        'address_id'=> $address->id
    ]);

    // Create payment record
    
    return $this->success(['order_status' => $order->status],'Payment processed successfully');

}else{
 return $this->success('','Order has Already been Paid');

}
            // Validate payment details
    
    
    }

}
