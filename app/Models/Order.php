<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }


public function scopeFilter($query,array $filters){

$query->when($filters['user'] ?? false,function($query,$user){
$query->whereHas('user',function($query) use($user){

    $query->where('name',$user);
});
});


$query->when($filters['total_price'] ?? false,function($query,$total_price){
$query->where('total_price','>=',$total_price);
});
    

}
    public function order_items(){

        return $this->hasMany(Order_items::class);
        
        }

public function address(){
    
    return $this->belongsTo(Address::class);
        }       


}
