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
    return new HumanResource(Human::all()->append(['totalScore','categoryScores']));//->load(['skills','skills.skill']);
})->name('api.humans');

Route::get('/hc', function () {
    return new CategoryResource(Category::all()->append(['humanTotals']));//->load(['skills','skills.skill']);
})->name('api.hc');

Route::get('/skills', function () {
    return new SkillResource(Skill::all()->append(['companyTotal']));//->load('humans','humans.human'););
})->name('api.skills');