<?php

namespace App\View\Components\Web\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $class;
    public $name;
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $class = 'w-full mb-2 px-1 py-2 border border-gray-400 placeholder-gray-800 rounded-md',
        $name = '',
        $id = ''
    ) {
        $this->class = $class;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.form.select');
    }
}
