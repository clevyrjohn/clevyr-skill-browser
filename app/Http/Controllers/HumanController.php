<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Human;

class HumanController extends Controller
{
    public function show(Human $human)
    {
        return inertia('Human', [
            'human' => $human->load('skills','skills.skill'),
        ]);
    }
}
