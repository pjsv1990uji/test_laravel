<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class ControllerTask extends Controller
{
    public function getTasks(){
        return view('taskView');
    }
}
