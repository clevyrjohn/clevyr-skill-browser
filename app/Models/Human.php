<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Human extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // protected $appends = ['totalScore'];

    public function skills()
    {
        return $this->hasMany(HumanSkill::class, 'human_id', 'id');
    }

    public function getTotalScoreAttribute() {
        return DB::table('human_skill')->where('human_id', '=', $this->id)->sum('level');
    }

    // public function getCategoryScoresAttribute() {
    //     $categories = Category::all();

    //     $categoryScores = [];

    //     return $categoryScores;
    // }
}
