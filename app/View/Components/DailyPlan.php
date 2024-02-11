<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DailyPlan extends Component
{
    public $isDayPlanCompleted;
    public $personal;
    public $default;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $personal, $default, $isDayPlanCompleted)
    {

        $this->isDayPlanCompleted = $isDayPlanCompleted;
        $this->personal = $personal;
        $this->default = $default;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.daily-plan');
    }
}
