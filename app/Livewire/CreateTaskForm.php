<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Carbon\Carbon;

class CreateTaskForm extends Component
{
    public $name;
    public $description;
    public $limit;
    public $initial_d;
    public $final_d;
    public $opt_freq = ['anual', 'mensual', 'diaria'];
    public $selected_opt_freq;

    public $success_message=null;

    protected $rules = [
        'name' => 'required|min:6',
        'description' => 'required',
        'limit' => 'required',
        'initial_d' => 'required|date|after_or_equal:today',
        'final_d' => 'required|date|after_or_equal:initial_d',
        'selected_opt_freq' => 'required',
    ];

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function save(){
        $this->validate();
       
        $exist_task = Task::where("name", $this->name)->exists();
        if($exist_task){
            $tarea = null;
            $this->addError('name', 'Ya existe una tarea con este nombre.');
            return;
        }else{

            $iniDate = Carbon::parse($this->initial_d);
            $finDate = Carbon::parse($this->final_d);
            $ini_weekDay = $iniDate->dayOfWeek;

            $tarea = Task::create([
                'name' => $this->name,
                'description' => $this->description,
                'ini_date' => $iniDate,
                'next_date' => $iniDate,
                'fin_date' => $finDate,
                'interaction' => $this->limit,
                'frequency' => $this->selected_opt_freq,
                'week_day' => $ini_weekDay,
            ]);
            $this->resetForm();
            sleep(1);

            $this->success_message = $tarea->name ." has been created!" .$ini_weekDay ."veamos";
        }


       
    }

    private function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->limit = '';
        $this->ini_date = null;
        $this->fin_date = null;
        $this->selected_opt_freq = null;
    }


    public function render()
    {
        return view('livewire.create-task-form');
    }
}
