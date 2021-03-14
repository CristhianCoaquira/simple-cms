<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pages extends Component
{
    public $title;
    public $slug;
    public $content;

    public $modalFormVisible = false;
    
    /**
     * Shows the modal form
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modalFormVisible = true;
    }

    public function create()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pages');
    }
}
