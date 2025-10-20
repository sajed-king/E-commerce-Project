<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrdersResource;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Total_Revenue;
use App\Http\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;  

class Admin_OrdersController extends Controller
{
    
use HttpResponses,Total_Revenue;


public function orders(){

$orders= Order::SelectRaw('orders.*,users.name')->orderBy('created_at','desc')->filter(request(['user','total_price']))
->leftjoin('users','users.id','orders.user_id')->get();

// $orders=Order::orderBy('created_at','desc')
// ->filter(request(['user','total_price']))->get();

$completed_orders=Order::where('status','paid')->count();
$num_of_orders=$orders->count();
$total_revenue=$this->total_revenue();
$pending_orders=$num_of_orders-$completed_orders;


 $Daily_orders = Order::selectRaw('DATE_FORMAT(created_at, "%c-%d") AS date, COUNT(*) as count')  
    ->where('created_at', '>=', Carbon::now()->subDays(7))  
    ->groupBy('date')  
    ->get();  
 $order_status_distribution=Order::selectRaw('status,count(*) as number')->groupby('status')->get();

 $data=[
'orders'=>$orders,
'num_of_orders'=>$num_of_orders,
'completed_orders'=>$completed_orders,
'pending_orders'=>$pending_orders,
'total_revenue'=>$total_revenue,
'daily_orders'=>$Daily_orders,
'order_status_distribution'=>$order_status_distribution,
];

return  $this->success($data,"OK");  

}







public function order_items(Order $order){
    return  $this->success(Order_items::where('order_id',$order->id)->get(),'OK');
        
    
    } 

    
}
