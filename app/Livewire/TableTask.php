<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Task;

use App\Enums\frequencyType;

use Carbon\Carbon;

class TableTask extends Component
{
    use WithPagination;
    public $searchInputWeek = '';
    public $searchInputDay = '';
    public $registerTasksCompleted = [];

    public $sortColumnBy = "";
    public $flagAsc = true;

    public $messageErrors = [];

    /**
    * Resets the table to the first page
    */
    public function searchTableDaily()
    {
        $this->resetPage();
    }

    /**
    * Resets the table to the first page
    */
    public function searchTableWeek()
    {
        $this->resetPage();
    }

    /**
    * Sort table by column
    *
    * @param string $field (column name)
    */
    public function sortBy($field)
    {
        if ($this->sortColumnBy === $field) {
            $this->flagAsc = !$this->flagAsc;
        } else {
            $this->flagAsc = true;
        }

        $this->sortColumnBy = $field;
    }

    /**
    * Calculate the new date and register the task as marked
    *
    * @param int $id_task (task identifier)
    */
    public function taskCompleted($id_task)
    {   
        $processCompleted=true;
        $tarea = Task::find($id_task);

        if (!$tarea) {
            return;
        }

        $today = Carbon::today();
        if($tarea->updated_at != $today){
            $valueData = $tarea->frequency->value;
            if(frequencyType::fromCase($valueData)){
                if($valueData == frequencyType::diaria->value){
                    if($today->dayOfWeek == Carbon::FRIDAY) {
                        $tarea->next_date = $today->next(Carbon::MONDAY);
                    }else{
                        $tarea->next_date = today()->addDay();
                    }
                }elseif($valueData == frequencyType::mensual->value){
                    $final_day_after_month = $today->copy()->addMonth()->endOfWeek(Carbon::SUNDAY);
                    $initial_day_after_month = $final_day_after_month->startOfWeek();
                    $day_after_month_weekday = $initial_day_after_month->copy()->addDays($today->dayOfWeek-1);
                    $tarea->next_date = $day_after_month_weekday;
                }elseif($valueData == frequencyType::anual->value){
                    $nextYear = $today->copy()->addYear();
                    if($nextYear->dayOfWeek == Carbon::FRIDAY) {
                        $tarea->next_date = $nextYear->next(Carbon::MONDAY);
                    }else{
                        $tarea->next_date = $nextYear;
                    }
                }
                else{                    
                    $processCompleted = false;
                }
                if($processCompleted){
                    $tarea->interaction-=1;
                    $tarea->save();
                    $this->registerTasksCompleted[$id_task] = true;
                }
                else{
                    $this->messageErrors[$id_task] = 'Se produjo un error al actualizar la nueva fecha.';
                    $this->registerTasksCompleted[$id_task] = false;
                }
                
            }else {
                $this->messageErrors[$id_task] = 'No se encuentra el tipo de periodicidad de la tarea';
            }
        }
    }
    
    public function render()
    {   
        $now = Carbon::now();

        $finalDayWk = $now->copy()->endOfWeek(Carbon::SUNDAY);
        $initialDayWk = $now->startOfWeek();

        $today = Carbon::today();

        
        $tasksNow = Task::FilterDate(
            0, 
            $initialDayWk,
            $finalDayWk,
            $today
        );

        $excludeIds = collect([
            $tasksNow->pluck('id')->all()
        ])->flatten()->all();
        
        $tasksThisWk = Task::FilterDate(
            0,
            $initialDayWk,
            $finalDayWk
        );

        $tasksNow = $tasksNow->when($this->searchInputDay, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                                        $query->where('name', 'like', '%' . $search . '%')
                                        ->orWhere('description', 'like', '%' . $search . '%');
            });
        })
        ->when($this->sortColumnBy, function ($query) {
            $query->orderBy($this->sortColumnBy, $this->flagAsc ? 'asc' : 'desc');
        })
        ->paginate(5, pageName: 'task-today');

        $tasksThisWk = $tasksThisWk->whereNotIn('id', $excludeIds)
            ->when($this->searchInputWeek, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                                        $query->where('name', 'like', '%' . $search . '%')
                                        ->orWhere('description', 'like', '%' . $search . '%');
            });
        })->paginate(5, ['*'], 'task-week');
        
        return view('livewire.table-task', array('allTaskDay'=>$tasksNow, 'allTaskWeek'=>$tasksThisWk));
    }
}
