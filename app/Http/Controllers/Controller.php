<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($status, $message, $data = null)
    {
        $array =[
            'status' => $status,
            'message' => $message
        ];

        if($data != null){
            $array['data'] = $data;
        }

        return response()->json($array, $status);
    }
}
