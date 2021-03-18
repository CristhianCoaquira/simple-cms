<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;

    public function mount($urlslug)
    {
        $this->retrieveContent($urlslug);
    }

    public function retrieveContent($slug)
    {
        $data = Page::where('slug', $slug)->first();
        $this->title = $data->title;
        $this->content = $data->content;
    }

    public function render()
    {
        return view('livewire.frontpage')->layout('layouts.frontend');
    }
}
