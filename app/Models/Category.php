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
            ->where('skills.category_id','=',$this->id)
            ->leftJoin('skills','human_skill.skill_id','=','skills.id')
            ->sum('human_skill.level');
    }

    public function getHumanTotalsAttribute() {

        $categoryHumanTotals = DB::table('human_skill')
                    ->select(
                        'human_skill.level',
                        'human_skill.skill_id',
                        'skill.category_id'
                    )
                    ->where('skills.category_id','=',$this->id)
                    ->leftJoin('skills','human_skill.skill_id','=','skills.id')
                    ->sum('human_skill.level');

        // $categoryHumanTotals = DB::table('humans')
        //         ->select(
        //             'humans.name',
        //             'humans.id',
        //             'human_skill.human_id',
        //         )
        //         ->leftJoin('human_skill','humans.id','=','human_skill.human_id')
        //         ->get();

        return $categoryHumanTotals;
    }
}
