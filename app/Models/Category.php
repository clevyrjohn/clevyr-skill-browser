<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function getCompanyTotalAttribute() {
        $skills = $this->skills()->get();

        $total = 0;
        foreach($skills as $skill) {
            $total += $skill['companyTotal'];
        }
        return $total;
    }

    public function getTopHumansAttribute() {

        // $skills = $this->skills()->get();

        // foreach($skills as $skill) {
        //     $humans = $skill->humans;
        //     // error_log(json_encode($humans, JSON_PRETTY_PRINT));
        //     // $rows = DB::table('human_skill')
        //     //     ->where('level', '>', 0)
        //     //     ->where('skill_id', '=', $skill->id)
        //     //     ->get(['human_id','level']);
        //     // error_log(json_encode($rows));

        // }

        return ["This guy", "that guy"];
    }
}
