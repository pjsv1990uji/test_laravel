<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable=["name", "description", "interaction", "ini_date","fin_date","frequency", "week_day", "next_date"];
    protected $dates = ['ini_date', 'fin_date', 'next_date'];
}
