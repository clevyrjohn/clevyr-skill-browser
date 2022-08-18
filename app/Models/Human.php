<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Human extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function skills()
    {
        return $this->hasMany(HumanSkill::class, 'human_id', 'id');
    }

    public function getTotalScoreAttribute()
    {
        return DB::table('human_skill')->where('human_id', '=', $this->id)->sum('level');
    }

    public function getCategoryScoreAttribute($categoryId = 1)
    {
        return DB::table('human_skill')
            ->select(
                'skills.name',
                'skills.category_id',
                'human_skill.skill_id',
                'human_skill.level'
            )
            ->where('skills.category_id', '=', $categoryId)
            ->where('human_skill.human_id', '=', $this->id)
            ->where('human_skill.level', '>', '0')
            ->leftJoin('skills', 'human_skill.skill_id', '=', 'skills.id')
            ->sum('human_skill.level');
    }

    public function getCategoryScoresAttribute()
    {
        $categories = Category::all()->toArray();

        $categoryScores = [];

        $categoryScores = array_map(
            function ($category) {
                return [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'color' => $category['color'],
                    'total' => $this->getCategoryScoreAttribute($category['id'])
                ];
            },
            $categories
        );

        return $categoryScores;
    }
}
