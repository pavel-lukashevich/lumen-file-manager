<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        return response()->json(['categories' => Category::all()]);
    }
}
