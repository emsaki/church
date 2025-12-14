<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AdminLayout extends Component
{
    public function __construct(public ?string $title = null) {}

    public function render(): View|Closure|string
    {
        return view('components.admin-layout');
    }
}