<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test()
    {
        $data = [
            "id" => 1,
            "msg" => "hello from laravel"
        ];
        return $data;
    }
}
