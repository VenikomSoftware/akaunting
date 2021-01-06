<?php

namespace App\View\Components\Documents\Form;

use App\Abstracts\View\Components\DocumentTemplate as Component;

class LineItem extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.documents.template.line-item');
    }
}
