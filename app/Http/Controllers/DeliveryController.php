<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrdersResource;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function delivery(){

     return  OrdersResource::collection(Order::where('status','paid')->with('Address')->get());   

    
    }







    }
