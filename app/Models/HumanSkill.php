<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HumanSkill extends Pivot
{
    protected $fillable = ['human_id','skill_id','level'];

    public function human()
    {
        return $this->belongsTo(Human::class);
    }
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
    public function scopeHasSkillLevel($q)
    {
        $q->where('level','>','0');
    }
}
