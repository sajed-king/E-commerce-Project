<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
protected $guarded=[];


public function scopeFilter($query,array $filters){
    



    // Check if both 'search' and 'category' filters are provided
    // $query->when(
    //     isset($filters['search']) && isset($filters['category']),
    //     function ($query) use ($filters) {
    //         $search = $filters['search'];
    //         $category = $filters['category'];

    //         // Apply the combined query logic
    //         $query->where(function ($query) use ($search) {
    //             $query->where('name', 'like', '%' . $search . '%')
    //                   ->orWhere('description', 'like', '%' . $search . '%');
    //         })->whereHas('category', function ($query) use ($category) {
    //             $query->where('name', $category);
    //         });
    //     }
    // );




// search name for name and description 
// $query->when($filters['search'] ?? false,function($query,$search){

//     $query->where('name','like','%'.$search.'%')
//  ->Orwhere('description','like','%'.$search.'%');
// });


// // search name for name and description
// $query->when($filters['category'] ?? false,function($query,$category){
//     $query->whereHas('category',fn($query)=>$query->where('name','like',$category)); 

// });

// $query->when($filters['price'] ?? false,function($query,$price){
//     $query->where('price','<=',$price); 

// });



}


// public function orders(){
//     return $this->hasMany(Order::class);
    
// }

public function category(){

return $this->belongsTo(Category::class);

}

public function company(){

return $this->belongsTo(Company::class);

}

public function order_items(){

    return $this->hasMany(Order_Items::class);
    
    }
    
public function reviews(){

return $this->hasMany(Review::class);
}


}
