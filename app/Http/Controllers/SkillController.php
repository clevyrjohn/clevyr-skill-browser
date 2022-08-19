<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Skill;

class SkillController extends Controller
{
    public function show(Skill $skill)
    {
        $skill = $skill->load([
                'humans' => function ($query) {
                    $query->where('level','>','0');
                },
                'humans.human',
                'category'
            ]);

        return inertia('Skill', [
            'skill' => $skill,
        ]);
    }
}
