<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Task;

use Carbon\Carbon;

class TableTask extends Component
{
    use WithPagination;
    public $query_wk = '';
    public $query_day = '';
    public $tareaCompletada_regs = [];

    public $sort_by_val = "";
    public $asc_flag = true;

    public function search_day()
    {
        $this->resetPage();
    }

    public function search_wk()
    {
        $this->resetPage();
    }

    public function SortBy($field)
    {
        if ($this->sort_by_val === $field) {
            $this->asc_flag = !$this->asc_flag;
        } else {
            $this->asc_flag = true;
        }

        $this->sort_by_val = $field;
    }

    public function TareaCompletada($id_task)
    {   
        $tarea = Task::find($id_task);

        if (!$tarea) {
            return;
        }

        $today = Carbon::today();
        if($tarea->updated_at != $today){
            if($tarea->frequency == 'diaria'){
                $tarea->next_date = today()->addDay();
            }elseif($tarea->frecuency == 'mensual'){
                $final_day_after_month = $today->copy()->addMonth()->endOfWeek(Carbon::SUNDAY);
                $initial_day_after_month = $final_day_after_month->startOfWeek();
                $day_after_month_weekday = $initial_day_after_month->copy()->addDays($today->dayOfWeek-1);
                $tarea->next_date = $day_after_month_weekday;
            }else{
                $tarea->next_date = $today->copy()->addYear();
            }
            
            $tarea->interaction-=1;
            $tarea->save();
            $this->tareaCompletada_regs[$id_task] = true;
            session()->flash('success', 'Tarea completada con éxito');
        }
    }
    
    public function render()
    {   
        $now = Carbon::now();

        $final_day_wk = $now->copy()->endOfWeek(Carbon::SUNDAY);
        $initial_day_wk = $now->startOfWeek();

        $today = Carbon::today();


        $tasks_now = Task::where('interaction', '>', 0)
            ->whereDate('next_date', '>=', $initial_day_wk)
            ->whereDate('next_date', '<=', $final_day_wk)
            ->whereDate('next_date', '=', $today)
            ->when($this->query_day, function ($query, $query_day) {
                return $query->where(function ($query) use ($query_day) {
                                            $query->where('name', 'like', '%' . $query_day . '%')
                                            ->orWhere('description', 'like', '%' . $query_day . '%');
                });
            })
            ->when($this->sort_by_val, function ($query) {
                $query->orderBy($this->sort_by_val, $this->asc_flag ? 'asc' : 'desc');
            })
            ->paginate(5, pageName: 'task-today');
        
        $excludeIds = collect([
                $tasks_now->pluck('id')->all()
            ])->flatten()->all();

        $query_this_wk = Task::where('interaction', '>', 0)
            ->whereDate('next_date', '>=', $initial_day_wk)
            ->whereDate('next_date', '<=', $final_day_wk)
            ->whereNotIn('id', $excludeIds)
            ->when($this->query_wk, function ($query, $query_wk) {
                return $query->where(function ($query) use ($query_wk) {
                                            $query->where('name', 'like', '%' . $query_wk . '%')
                                            ->orWhere('description', 'like', '%' . $query_wk . '%');
                });
            })->paginate(5, ['*'], 'task-week');

        return view('livewire.table-task', array('all_tasks_day'=>$tasks_now, 'all_tasks_wk'=>$query_this_wk));
    }
}
