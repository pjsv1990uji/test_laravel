<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Validation\Rules\Enum;

use App\Enums\frequencyType;

use Carbon\Carbon;


class CreateTaskForm extends Component
{
    public $name;
    public $description;
    public $limit;
    public $initialDate;
    public $finalDate;
    public $frequencyOptions = [];
    public $selectedFreOpt;

    public $success_message=null;

    protected $messages = [
        'name.required' => 'Nombre es obligatorio.',
        'name.min' => 'Nombre debe tener al menos :min caracteres.',
        'description.required' => 'Descripción es obligatorio.',
        'limit.required' => 'Debe colocar un numero mayor a 0.',
        'initialDate.required' => 'El campo de fecha inicial es obligatorio.',
        'initialDate.date' => 'El campo de fecha inicial debe ser una fecha válida.',
        'initialDate.after_or_equal' => 'El campo de fecha inicial debe ser igual o posterior a hoy.',
        'finalDate.required' => 'El campo de fecha final es obligatorio.',
        'finalDate.date' => 'El campo de fecha final debe ser una fecha válida.',
        'finalDate.after_or_equal' => 'El campo de fecha final debe ser igual o posterior a la fecha inicial.',
        'selectedFreOpt.required' => 'Seleccione una opcion valida para la frecuencia de la respectiva tarea.',
        'selectedFreOpt' => 'Seleccione una opcion valida para la frecuencia de la respectiva tarea.',
    ];

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

    public function mount()
    {
        foreach (frequencyType::cases() as $value) {
            $this->frequencyOptions[$value->name] = $value->value;
        }
    }

    public function save(){
        $this->validate(['name' => 'required|min:6',
        'description' => 'required',
        'limit' => 'required',
        'initialDate' => 'required|date|after_or_equal:today',
        'finalDate' => 'required|date|after_or_equal:initialDate',
        'selectedFreOpt' => [new Enum(frequencyType::class)],]);
       
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
