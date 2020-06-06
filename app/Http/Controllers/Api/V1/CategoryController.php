<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        if (Auth::user()) {
            $categories = $categories->makeVisible(['id']);
        }
        return response()->json($categories);
    }
}
