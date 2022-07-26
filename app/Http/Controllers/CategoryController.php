<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        return inertia('Category', [
            'category' => $category->load('skills'),
        ]);
    }
}
