<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class StatCard extends Component
{
    public string $label;
    public int|string $value;
    public string $color;

    public function __construct($label, $value, $color = 'blue')
    {
        $this->label = $label;
        $this->value = $value;
        $this->color = $color;
    }

    public function render(): View
    {
        return view('components.stat-card');
    }
}