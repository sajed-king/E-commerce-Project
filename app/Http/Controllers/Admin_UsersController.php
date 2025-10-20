<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_items;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin_UsersController extends Controller
{
    public function index(){


        $year = now()->year; // Current year  
// needs adjustment
$users_growth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as user_count')  
    ->whereYear('created_at', $year) // Filter by the current year  
    ->groupBy('month')  
    ->orderBy('month')  
    ->get();    

    
$new_users_today=User::selectRaw('Count(*) as number')->where(DB::raw('DAY(created_at)'),now()->day)->get();    
$total_users=User::count();
$users=User::get();


$data=[
'users'=>$users,
'new_users_today'=>$new_users_today,
'active_users'=>10,
'churn_users'=>10,
'total_users'=>$total_users,
'users_growth'=>$users_growth


         ];


         
         return $data;


        }


public function order_details($id){
 
//  return Order::selectraw('orders.*,products.name,order_items.amount,order_items.price_order')
// ->leftjoin('order_items','order_items.order_id','orders.id')
// ->leftjoin('products','products.id','order_items.product_id')->get();
$data=[
 "order"=> Order::find($id),    
 "order_items"=>  Order_items::selectraw("products.name_en,order_items.amount,order_items.price_order")
 ->leftjoin('products','order_items.product_id','products.id')->where('order_id',$id)->get(), 
];

return $data;

}


    
    
}
