<?php

namespace App\Http\Controllers;

use App\Http\Traits\HttpResponses;
use App\Http\Traits\Total_Revenue;
use App\Models\Order_items;
use App\Models\Product;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin_ProductsController extends Controller
{
    use HttpResponses,Total_Revenue;
    public function index(){
 $total_revenue=$this->total_revenue();
 $products=Product::select("products.*","categories.name as category_name" )
 ->leftJoin('categories','categories.id','products.category_id')->get();
 $total_products=$products->count();
 $low_stock=$products->filter(function($product){
return $product->amount <=5; 
 })->count();



 $top_selling = Order_items::selectRaw('products.name_en, COUNT(order_items.id) as number')  
->rightJoin('products', 'order_items.product_id', '=', 'products.id')  
->groupBy('products.name_en')  
->orderBy('number', 'desc')  
->first();                   

$data=[
   
    "total_products"=>$total_products,
    "top_selling"=>$top_selling,
    "low_stock"=>$low_stock,
   "total_revenue"=>$total_revenue,
    "products"=> $products,
];

return $this->success($data,"OK");

    }






}
