<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Timezone extends Component
{
    public  $timezones;
    public  $currentTz;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($timezones, $currentTz)
    {
        $this->timezones = $timezones;
        $this->currentTz = $currentTz;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.timezone');
    }
}
