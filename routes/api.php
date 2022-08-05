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

function hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity) > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}

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

Route::get('/humanstable', function () {
    $categories = Category::all()->append(['humanTotals'])->toArray();//,0,2);//->load(['skills','skills.skill']);
    $humans = Human::all()->append(['totalScore'])->toArray();//,0,2);//->load(['skills','skills.skill']);
    // return $humans;
    return new HumanResource([
        'labels' => array_map(
            function($human) { return $human['name']; },
            $humans
        ),
        'datasets' => array_map(
            function($category) { 
                return [
                    'label' => $category['name'],
                    'data' => array_map(
                        function ($humanTotal) {
                            return $humanTotal->total_score;
                        },
                        $category['humanTotals']
                    ),
                    'backgroundColor' => hex2rgba($category['color'], 0.7),
                ];
            },
            $categories
        ),
    ]);
    // return [
    //     'categories' => $categories,
    //     'humans' => $humans,
    // ];
})->name('api.humanstable');

Route::get('/skills', function () {
    return new SkillResource(Skill::all()->append(['companyTotal']));//->load('humans','humans.human'););
})->name('api.skills');

