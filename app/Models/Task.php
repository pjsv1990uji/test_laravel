<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable=["name", "description", "interaction", "ini_date","fin_date","frequency", "week_day", "next_date"];
    protected $dates = ['ini_date', 'fin_date', 'next_date'];

    /**
    * Filter Task model by a date range
    *
    * @return \App\Models\Task
    */
    public function scopeFilterDate($query, int $interaction, Carbon $initialDay, Carbon $finalDay, Carbon $today = null)
    {   
        $query = $query
            ->where('interaction', '>', $interaction)
            ->whereDate('next_date', '>=', $initialDay)
            ->whereDate('next_date', '<=', $finalDay);
            
        
        if (!is_null($today)) {
            $query = $query->whereDate('next_date', '=', $today);
        }

        return $query;
    }
}
