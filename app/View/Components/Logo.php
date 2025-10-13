<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Logo extends Component
{
    public $variant;
    public $size;
    public $showText;

    /**
     * Create a new component instance.
     */
    public function __construct($variant = 'default', $size = 'h-8', $showText = true)
    {
        $this->variant = $variant;
        $this->size = $size;
        $this->showText = $showText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.logo');
    }
}
