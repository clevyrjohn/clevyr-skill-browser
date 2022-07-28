<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Skill;

class SkillController extends Controller
{
    public function show(Skill $skill)
    {
        return inertia('Skill', [
            'skill' => $skill->load('humans', 'humans.human'),
        ]);
    }
}
