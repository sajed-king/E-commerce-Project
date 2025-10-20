<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Http\Resources\OneProductResource;
use App\Http\Resources\ProductsResource;
use App\Http\Traits\HttpResponses;
use App\Models\Order;
use App\Models\Order_Items;
use App\Models\Product;
use App\Models\Review;
use Exception;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $lang = app()->getLocale(); // Gets 'en' or 'ar' from middleware  
    
      $product=DB::table('products')->select([
        "id",
        "name_{$lang} as name" ,
        "description_{$lang} as description",
        "image",
        "package_insert",
        "concentration",
        "price",
        "category_id",
        "need_prescription"
        
        
      ]);

         return ProductsResource::Collection($product->get());
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {


$request->validated($request->all());


$product=Product::create([
'name_en'=> $request->name_en,
'description_en'=> $request->description_en,
'concentration'=> $request->concentration,
'price'=>$request->price,
'amount'=>$request->amount,
'image' => $request->file('image')->store('images','public'),
'package_insert'=> $request->file('package_insert')->store('Package_Inserts','public'),
'need_prescription'=> $request->need_prescription,
'category_id'=>$request->category,
'company_id'=>$request->company


]);

return new OneProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lang = app()->getLocale(); // Gets 'en' or 'ar' from middleware  

       
        $product=Product::select([
            "id",
          "name_{$lang} as name" ,
          "description_{$lang} as description",
          "image",
          "amount",
          "package_insert",
          "concentration",
          "price",
          "need_prescription",
        ])->where("id",$id)
        ->with('category','company')->first();
    //      $product=DB::table('products')->select([
    //       "products.id",
    //       "name_{$lang} as name" ,
    //       "description_{$lang} as description",
    //       "image",
    //       "package_insert",
    //       "concentration",
    //       "price",
    //       "category_id",
    //       "need_prescription",
    //       "reviews.*"
          
    //     ])->join('reviews','products.id','=','reviews.product_id')->where("products.id",$id)->first();
        
    //  $product=Product::where("id",$id)->with('reviews')->first();
    
     return response()->json($product) ;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        


    }


    public function update(Request $request,Product $product)
    {
        

 
        $validatedData = $request->validate([
        'name_en' => ['string'],
        'description_en' => ['string'],
        'name_ar' => ['string'],
        'description_ar' => ['string'],
        'price' => ['numeric', 'between:0,9999999999'],
        'concentration'=>['numeric'],
        'amount' => ['numeric', 'between:0,9999999999'],
        'image' => ['nullable', 'file', 'mimes:jpeg,png'],
        'package_insert' => ['nullable', 'file', 'mimes:pdf'],
        'company_id'=>['numeric'],
        'category_id'=>['numeric']
    ]);

    // Handle file uploads
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = $imagePath;
    }

    if ($request->hasFile('package_insert')) {
         $packageInsertPath = $request->file('package_insert')->store('package_inserts', 'public');
        $validatedData['package_insert'] = $packageInsertPath;
    }

    // Update the product
    $product->update($validatedData);

    return response()->json($product);



        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        $product->delete();
        return $this->success('','The product has been deleted',200);


    }
    

    
}



