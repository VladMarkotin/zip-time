<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SavedTasks extends Component
{
    public $savedTasks;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($savedTasks)
    {
       $this->savedTasks=$savedTasks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.saved-tasks');
    }
}
