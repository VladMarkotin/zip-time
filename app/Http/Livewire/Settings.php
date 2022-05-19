<?php
namespace App\Http\Livewire;


use Livewire\Component;
use  App\Models\SavedTask;
use Auth;
use Livewire\WithPagination;

class Settings extends Component
{
    use WithPagination;

    private $savedTasks = [];

    public function render(SavedTask $savedTask)
    {
        $this->savedTasks = $savedTask->where('user_id', Auth::id())
            ->paginate(5);
            //->toArray();
        //dd($this->savedTasks);
        return view('livewire.settings', [
            "savedTasks" => $this->savedTasks
        ]);
    }

    public function destroy(SavedTask $savedTask)
    {
        if($savedTask){
           $savedTask->delete(); 
        }
        /*if($id){
            $sT = SavedTask::where('id', $id)->where('user_id', Auth::id());
            ($sT) ? $sT->delete() : '';
        }*/
    }

    public function edit($id)
    {
        if($id){
            $sT = SavedTask::where('id', $id)->where('user_id', Auth::id());
            
        }
    }
}
