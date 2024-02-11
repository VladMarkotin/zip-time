<?php

namespace App\View\Components;

use Illuminate\View\Component;

class WeekEnds extends Component
{

    public $personal;
    public $default;
    public $isWeekendTaken;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $personal, $default,$isWeekendTaken )
    {

        
        $this->personal = $personal;
        $this->default = $default;
        $this->isWeekendTaken=$isWeekendTaken;
    }
    
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.week-ends');
    }
}
