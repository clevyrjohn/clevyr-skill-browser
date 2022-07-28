<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $with = ['skills'];

    protected $fillable = ['name'];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}