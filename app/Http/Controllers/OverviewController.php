<?php

namespace App\Http\Controllers;

use App\Http\Traits\HttpResponses;
use App\Models\Order_items;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\Total_Revenue;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OverviewController extends Controller
{
    use HttpResponses,Total_Revenue;

    public function index(){
$total_sales=0;


$new_users = User::whereMonth('created_at',now()->month)->count();
 
$order_items=Order_items::select('amount','price_order','created_at')->get();  
$total_products=Product::count();
$total_sales_per_month=[];
// $category_percentage=Category::select('categories.name',DB::raw("count(products.id) as value"))
// ->leftJoin('products','categories.id','products.category_id')->groupBy('categories.name')->get();
$category_percentage=Category::select('categories.name',DB::raw('count(products.name_en) as value'))
->leftjoin('products','products.category_id','categories.id')
->groupBy('categories.name')->get();    
$total_sales=$this->total_revenue();



for($i=1;$i<=12;$i++){
    $money=0;
foreach($order_items as $order_item){
    $year= $order_item->created_at->year ;
    $month=$order_item->created_at->month ;

     
    if($year == now()->format('Y') && $month == $i)
         {$money+=$order_item->amount*$order_item->price_order;} 
        
         


}
 $total_sales_per_month[]=[
            'month' => Carbon::create()->month($i)->format("M"),
            'sales'=> $money
         ];   

}




$data=[
'total_sales'=>$total_sales,
'total_sales_per_month'=> $total_sales_per_month,
'new_users'=>$new_users,
'total_products'=>$total_products,
'category_percentage'=>$category_percentage,

];


return $this->success($data,"Ok");




    }


public function sales(){



 $avg_order_value= Order::SelectRaw("SUM(total_price) as money")->first()->money;
$order_number=Order::count();
$sales_by_category=Category::select('categories.name',DB::raw("count(order_items.product_id) as value"))
->leftJoin('products','categories.id','products.category_id')
->leftJoin('order_items','products.id','order_items.product_id')->groupBy('categories.name')->get();
$this_month=Order::where('status','paid')->where('created_at','>=', Carbon::now()->subDays(30))->sum('total_price');
$last_month= Order::where('status','paid')->whereBetween('created_at',[Carbon::now()->subDays(60),Carbon::now()->subDays(30)] )->sum('total_price');
$sales_growth= $last_month ? ($this_month - $last_month)/$last_month : $this_month; 

$daily_sales_trend = [];
$order_items = Order_items::all(); // Fetch all order items

for ($i = 1; $i <= 7; $i++) {
    $money = 0; // Reset $money for each day

    foreach ($order_items as $order_item) {
        $day = $order_item->created_at->dayOfWeekIso; // ISO day (1=Monday, 7=Sunday)

        if ($day == $i) {
            $money += $order_item->price_order * $order_item->amount;
        
        }
    }

    // Map day number to day name (ISO: 1=Monday, 7=Sunday)
    $dayName = Carbon::now()->startOfWeek()->addDays($i - 1)->format('D');

    $daily_sales_trend[] = [
        'day' => $dayName,
        'sales' => $money,
    ];
}

// Output the result






    $data=[
        "Total_Revenue" => $this->total_revenue(),
        "Avg_Order_Value"=> ($avg_order_value /$order_number),
        "sales_by_category"=> $sales_by_category,
        'sales_growth'=> $sales_growth ,
        "daily_sales_trend" => $daily_sales_trend

    ];
    return $data;
}


}