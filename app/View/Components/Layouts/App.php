<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;

class App extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $theme = 'light'
    ) {}

    public function render(): View
    {
        return view('layouts.app');
    }
} 