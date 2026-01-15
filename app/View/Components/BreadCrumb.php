<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadCrumb extends Component
{
    public ?string $layer1;
    public ?string $layer2;
    public ?string $layer3;
    public ?string $layer1route;
    public ?string $layer2route;
    /**
     * Create a new component instance.
     */
    public function __construct(
        $layer1 = null,
        $layer2 = null,
        $layer3 = null,
        $layer1route = null,
        $layer2route = null,
    )
    {
        $this->layer1 = $layer1;
        $this->layer2 = $layer2;
        $this->layer3 = $layer3;
        $this->layer1route = $layer1route;
        $this->layer2route = $layer2route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bread-crumb');
    }
}
