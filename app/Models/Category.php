<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color'];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function getCompanyTotalAttribute()
    {
        return DB::table('human_skill')
            ->select(
                'human_skill.level',
                'human_skill.skill_id',
                'skill.category_id'
            )
            ->where('skills.category_id', '=', $this->id)
            ->leftJoin('skills', 'human_skill.skill_id', '=', 'skills.id')
            ->sum('human_skill.level');
    }

    public function getHumanTotalsAttribute()
    {
        $categoryHumanTotals = DB::select(
            "SELECT
            skills.category_id,
            sum(human_skill.level) as total_score,
            human_skill.human_id,
            humans.name
            FROM skills
            FULL OUTER JOIN human_skill
                ON skills.id = human_skill.skill_id
            FULL OUTER JOIN humans
                ON human_skill.human_id = humans.id
            WHERE skills.category_id = {$this->id}
            GROUP BY skills.category_id, human_skill.human_id, humans.name
            ORDER BY human_skill.human_id
            "
        );

        return $categoryHumanTotals;
    }
}
