<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class ControllerTask extends Controller
{
    //
    public function get_tasks(){
        return view('taskView');
    }
}
