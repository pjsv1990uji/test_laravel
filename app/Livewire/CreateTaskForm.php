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
    public $initialDate;
    public $finalDate;
    public $frequencyOptions = ['anual', 'mensual', 'diaria'];
    public $selectedFreOpt;

    public $success_message=null;

    protected $rules = [
        'name' => 'required|min:6',
        'description' => 'required',
        'limit' => 'required',
        'initialDate' => 'required|date|after_or_equal:today',
        'finalDate' => 'required|date|after_or_equal:initialDate',
        'selectedFreOpt' => 'required',
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

            $iniDate = Carbon::parse($this->initialDate);
            $finDate = Carbon::parse($this->finalDate);
            $ini_weekDay = $iniDate->dayOfWeek;

            $tarea = Task::create([
                'name' => $this->name,
                'description' => $this->description,
                'ini_date' => $iniDate,
                'next_date' => $iniDate,
                'fin_date' => $finDate,
                'interaction' => $this->limit,
                'frequency' => $this->selectedFreOpt,
                'week_day' => $ini_weekDay,
            ]);
            $this->resetForm();
            sleep(1);

            $this->success_message = $tarea->name ." has been created!";
        }


       
    }

    private function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->limit = '';
        $this->initialDate = '';
        $this->finalDate = '';
        $this->selectedFreOpt = null;
    }


    public function render()
    {
        return view('livewire.create-task-form');
    }
}
