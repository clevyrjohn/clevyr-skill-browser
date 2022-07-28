<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    protected $appends = ['companyTotal'];

    /**
     * 
     * Relations
     * 
     */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function humans()
    {
        return $this->hasMany(HumanSkill::class);
    }

    /**
     * 
     * Functions
     * 
     */

    public function getCompanyTotalAttribute() {
        return DB::table('human_skill')->where('skill_id', '=', $this->id)->sum('level');
    }

    public function getTopHumansAttribute() {
        return ['empty', 'list'];
    }
}
