<?php
namespace App\Http\Traits;

trait HttpResponses{
    
protected function success($data,$message=null,$code=200){

return response()->json([
'status'=>'Request was succesful',
'message'=> $message,
'data'=> $data
],$code);

}


protected function error($data,$message,$code=400){

    return response()->json([
    'status'=>'Error has occured',
    'message'=> $message,
    'data'=> $data
    
],$code);
    
    }

}


    