<?php
 namespace App\Http\Traits;

use App\Models\Order_items;

trait Total_Revenue
{

    public function total_revenue(){
        $total_revenue=0; 
        $order_items=Order_items::select('price_order','amount')->get();


        foreach($order_items as $order_item){
            $total_revenue += $order_item->price_order*$order_item->amount;
        }
        
return $total_revenue;


    } 
    
}
  