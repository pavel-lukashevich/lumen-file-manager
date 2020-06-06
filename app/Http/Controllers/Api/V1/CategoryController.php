<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class CategoryController extends Controller
{

    public function index()
    {
        return response()->json(['categories' => Category::all()]);
    }
}
