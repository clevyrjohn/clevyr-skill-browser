<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $category = $category->load('skills');

        foreach ($category->skills as $skill) {            
            $skill['level'] = DB::table('human_skill')->where('skill_id', '=', $skill->id)->sum('level');
        }

        return inertia('Category', [
            'category' => $category,
        ]);
    }
}
