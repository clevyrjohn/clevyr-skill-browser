<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SpreadsheetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HumanController;
use App\Http\Controllers\SkillController;
use App\Models\Category;
use App\Models\Human;
use App\Models\Skill;
use App\Models\HumanSkill;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/import', [SpreadsheetController::class, 'import']);
Route::post('/import', [SpreadsheetController::class, 'store']);

Route::get('/c/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/h/{human}', [HumanController::class, 'show'])->name('human.show');
Route::get('/s/{skill}', [SkillController::class, 'show'])->name('skill.show');
