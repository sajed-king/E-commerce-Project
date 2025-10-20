<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    
public function store(Request $request){


$request->validate([
'description'=> ["required","string"],
]);

$review=Review::create([
    'description' => $request->description,
    'user_id'=> $request->user()->id,
    'product_id'=> $request->product_id
]);

$review=[
    'description' => $request->description,
    'user_id'=> $request->user()->id,
    'user_name'=>$request->user()->name,
    'product_id'=> $request->product_id


];
return response()->json($review);

}

public function update(Request $request,Review $review){

$this->authorize('update', $review);

$request->validate([
    'description'=> ['required','string'],
        
]);

$review->update($request->only('description'));


return response()->json($review);




}


public function destroy(Review $review){

    $this->authorize('update', $review);

    $review->delete();
return response()->json("your review has been successfully deleted");


}



}


