<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Savedlogs;
use App\Models\SavedTask;
use Illuminate\Support\Facades\Auth;

class Backlog extends Component
{
    public $title, $task_id, $content, $backlog_id;

    public function rules()
    {
        return [
            'title' => 'required|string|max:80',
            'content' => 'required|string',
        ];
    }

    public function resetInput()
    {
        $this->title = null;
        $this->content = null;
        $this->task_id = null;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function storeBacklogInfo()
    {
        $validatedData = $this->validate();
        Savedlogs::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'saved_task_id' => $this->task_id,
            'content' => $this->content,
        ]);
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editBacklogInfo($backlog_id)
    {
        $this->backlog_id = $backlog_id;

        $backlog = Savedlogs::findOrfail($backlog_id);
        $this->title = $backlog->title;
        $this->task_id = $backlog->saved_task_id;
        $this->content = $backlog->content;
    }

    public function updateBacklogInfo()
    {
        $validatedData = $this->validate();
        Savedlogs::findOrFail($this->backlog_id)->update([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'saved_task_id' => $this->task_id,
            'content' => $this->content,
        ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteBacklogInfo($backlog_id)
    {
        $this->backlog_id = $backlog_id;
    }

    public function destroyBacklogInfo()
    {
        Savedlogs::find($this->backlog_id)->delete();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $backlogs = Savedlogs::where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get();
        $tasks = SavedTask::where('user_id', Auth::id())->get();
        return view('livewire.backlog', compact('tasks', 'backlogs'));
    }
}
