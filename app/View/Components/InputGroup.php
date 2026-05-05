<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputGroup extends Component
{
    /**
     * Create a new component instance.
     */

    public $name;
    public $label;
    public $icon;
    public $type;
    public $value;

    public function __construct($name, $label, $icon, $type = null, $value = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->icon = $icon;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-group');
    }
}
