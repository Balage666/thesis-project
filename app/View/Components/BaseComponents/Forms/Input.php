<?php

namespace App\View\Components\BaseComponents\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{

    public $id;

    public $name;

    public $type;

    public $value;

    public $label;

    public $placeholder;

    public $isRequired;

    public $forError;


    /**
     * Create a new component instance.
     */
    public function __construct($id, $name, $type = 'text', $value = null, $label = null, $placeholder = null, $isRequired = true, $forError="Error occured!")
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->isRequired = $isRequired;
        $this->forError = $forError;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.base-components.forms.input');
    }
}
