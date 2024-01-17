<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function allProductList(Request $request){

        return product::latest()->get();
      }
}
