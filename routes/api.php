<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Models\Human;
use App\Http\Resources\HumanResource;
use App\Models\Skill;
use App\Http\Resources\SkillResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories', function () {
    return new CategoryResource(Category::all()->append(['companyTotal']));
})->name('api.categories');

Route::get('/humans', function () {
    return new HumanResource(Human::all()->append(['totalScore', 'categoryScores']));
})->name('api.humans');

Route::get('/hc', function () {
    return new CategoryResource(Category::all()->append(['humanTotals']));
})->name('api.hc');

Route::get('/humanstable', function () {
    $categories = Category::all()->append(['humanTotals'])->toArray();
    $humans = Human::all()->append(['totalScore', 'categoryScores'])->toArray();
    return new HumanResource([
        'categories' => array_map(
            function ($category) {
                return [
                    'label' => $category['name'],
                    'backgroundColor' => hex2rgba($category['color'], 0.7),
                ];
            },
            $categories
        ),
        'humans' => array_map(
            function ($human) use ($categories) {
                $categoryScores = [];

                foreach ($human['categoryScores'] as $categoryScore) {
                    $categoryScores[$categoryScore['name']] = $categoryScore['total'];
                }

                $row = [
                    'name' => $human['name'],
                    'id' => $human['id'],
                    'totalScore' => $human['totalScore'],
                ];

                return array_merge($row, $categoryScores);
            },
            $humans
        ),
    ]);
})->name('api.humanstable');

Route::get('/skills', function () {
    $skills = array_map(
        function ($skill) {
            return [
                'id' => $skill['id'],
                'name' => $skill['name'],
                'companyTotal' => $skill['companyTotal'],
                'category' => $skill['category']['name'],
            ];
        },
        Skill::all()->load('category')->append(['companyTotal'])->toArray()
    );

    return new SkillResource([
        'skills' => $skills,
    ]);
})->name('api.skills');
