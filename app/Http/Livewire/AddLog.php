<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Savedlogs;
use App\Models\SavedTask;
use Illuminate\Support\Facades\Auth;

class AddLog extends Component
{

    public $title, $task_id, $content;

    public function rules()
    {
        return [
            'title' => 'required|string|max:80',
            'content' => 'required|string',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function storeBacklogInfo()
    {
        $this->validate();
        Savedlogs::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'saved_task_id' => $this->task_id,
            'content' => $this->content,
        ]);
        $this->reset(['title', 'content', 'task_id']);
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('message', [
            'text' => 'Log Added Successfully',
        ]);
    }



    public function render()
    {
        $tasks = SavedTask::where('user_id', Auth::id())->get();
        return view('livewire.add-log', compact('tasks'));
    }
}
