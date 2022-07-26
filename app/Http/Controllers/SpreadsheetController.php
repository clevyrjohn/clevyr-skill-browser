<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PulkitJalan\Google\Facades\Google;
use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Category;
use App\Models\Skill;
use App\Models\Human;
use App\Models\HumanSkill;

class SpreadsheetController extends Controller
{
    public function import(Request $request)
    {
        $sheet = Sheets::spreadsheet(env('GOOGLE_SHEET_ID'))->sheet('Team Members by Skill')->all();

        return inertia('ImportSpreadsheet', [            
            'sheet' => $sheet,
        ]);
    }

    public function store(Request $request)
    {
        $categoryIndices = [];
        foreach($request->categories as $key=>$category) {
            if ($category != "") {                
                Category::firstOrCreate([
                    'name' => $category
                ]);               
                array_push($categoryIndices, $key); 
            }
        }

        foreach($request->skills as $key=>$skill) {
            if ($skill != "") {                
                $categoryIndexOnSpreadsheet = max(array_filter(
                    $categoryIndices, function($index) use ($key) {
                        return $index <= $key;
                }));
                $categoryId = array_search($categoryIndexOnSpreadsheet, $categoryIndices);
                Skill::firstOrCreate([
                    'name' => $skill,
                    'category_id' => $categoryId+1,
                ]);
            }
        }

        foreach($request->humans as $key=>$human) {            
            $db = Human::firstOrCreate([
                'name' => $human[0],
            ]);
            
            foreach($human as $key=>$skillLevel) {
                // error_log($skillLevel);                
                if ($key > 0) {
                    // error_log($key);
                    HumanSkill::firstOrCreate([
                        'human_id' => $db->id,
                        'skill_id' => $key,
                        'level' => $skillLevel,
                    ]);
                }
            }
        }
        return 'success! <a href="/">Back home</a>';
    }
}