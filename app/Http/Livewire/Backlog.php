<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Savedlogs;
use Illuminate\Support\Facades\Auth;

class Backlog extends Component
{
    public $title, $task_id, $content;

     public function rules()
     {
        return[
            'title' =>'required|string',
            'content'  =>'required|string'
        ];
     }

     public function resetInput()
     {
         $this->title = null;
         $this->content = null;
         $this->task_id = null;
     }

    public function storeBacklogInfo()
    {
        
        Savedlogs::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'task_id' => $this->task_id,
            'content' => $this->content,
           
        ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function updateBacklogInfo()
    {
        // $this->brand_id = $brand_id;

        // $brand = Brand::findOrfail($brand_id);
        // $this->name = $brand->name;
        // $this->slug = $brand->slug;
        // $this->status = $brand->status;
    }

    public function destroyBacklogInfo()
    {
        // Brand::find($this->brand_id)->delete();
        // $this->dispatchBrowserEvent('close-modal');
        // $this->resetInput();
    }

    public function render()
    {
        return view('livewire.backlog');
    }
}
