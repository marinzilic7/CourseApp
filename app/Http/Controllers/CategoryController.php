<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategory(){
        $data = Category::all();
        return response()->json($data);
    }
}
