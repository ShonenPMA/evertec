<?php

namespace App\View\Components\Web\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $class;
    public $type;
    public $name;
    public $placeholder;
    public $required;
    public $autofocus;
    public $id;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $class = 'w-full mb-2 px-1 py-2 border border-gray-400 placeholder-gray-800 rounded-md',
        $type = 'text',
        $name = '',
        $placeholder = '',
        $required = false,
        $autofocus = false,
        $id = '',
        $value=''
    )
    {
        $this->class = $class;
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->autofocus = $autofocus;
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.form.input');
    }
}
