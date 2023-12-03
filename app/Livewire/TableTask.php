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

    public function search_day()
    {
        $this->resetPage();
    }

    public function search_wk()
    {
        $this->resetPage();
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
            session()->flash('success', 'Tarea completada con éxito');
        }
    }
    
    public function render()
    {   
        
        $perPage = 5;
        $page = request()->get('page', 1);

        $now = Carbon::now();

        $final_day_wk = $now->copy()->endOfWeek(Carbon::SUNDAY);
        $initial_day_wk = $now->startOfWeek();

        $today = Carbon::today();

        echo 'Now: ' . $today . "\n";
        echo 'Inicio: ' . $initial_day_wk . "\n";
        echo 'Final: ' . $final_day_wk;


        $tasks_now = Task::where('interaction', '>', 0)
            ->whereDate('next_date', '>=', $initial_day_wk)
            ->whereDate('next_date', '<=', $final_day_wk)
            ->whereDate('next_date', '=', $today)->paginate(20);;

        $excludeIds = collect([
                $tasks_now->pluck('id')->all()
            ])->flatten()->all();

        $query_this_wk = Task::where('interaction', '>', 0)
            ->whereDate('next_date', '>=', $initial_day_wk)
            ->whereDate('next_date', '<=', $final_day_wk)
            ->whereNotIn('id', $excludeIds)->paginate(20);
        
        $now = Carbon::create('2023', '12', '1');
        $final_day_after_month = $now->copy()->addMonth()->endOfWeek(Carbon::SUNDAY);
        $initial_day_after_month = $final_day_after_month->startOfWeek();
        $day_after_month_weekday = $initial_day_after_month->copy()->addDays($now->dayOfWeek-1);

        $final_day_after_year = $now->copy()->addYear()->endOfWeek(Carbon::SUNDAY);
        $initial_day_after_year = $final_day_after_year->startOfWeek();


        echo '\nexper: ' . $now . "\n";
        echo 'weekday: ' . $now->dayOfWeek . "\n";
        echo 'initial_day_after_month: ' . $initial_day_after_month . "\n";
        echo 'day_after_month_weekday: ' . $day_after_month_weekday . "\n";


        return view('livewire.table-task', array('all_tasks_day'=>$tasks_now, 'all_tasks_wk'=>$query_this_wk));
    }
}
