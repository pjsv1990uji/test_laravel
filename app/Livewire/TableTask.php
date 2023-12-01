<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Task;

class TableTask extends Component
{
    use WithPagination;
    public $query = '';

    public function search()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $all_tasks = Task::where(
            function($query){
                $query->where('name', 'like', '%'.$this->query.'%')
                    ->orWhere("description", "like", '%'.$this->query.'%');}
        )->paginate(5);
        return view('livewire.table-task', array('all_tasks'=>$all_tasks));
    }
}
