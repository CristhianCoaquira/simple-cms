<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;

class Frontpage extends Component
{
    public $title;
    public $content;

    public function mount($urlslug = null)
    {
        $this->retrieveContent($urlslug);
    }

    public function retrieveContent($slug)
    {
        if (empty($slug)) {
            $data = Page::where('is_default_home', true)->first();
        } else {
            $data = Page::where('slug', $slug)->first();

            if (!$data) {
                $data = Page::where('is_default_not_found', true)->first();
            }
        }
        $this->title = $data->title;
        $this->content = $data->content;
    }

    public function render()
    {
        return view('livewire.frontpage')->layout('layouts.frontend');
    }
}
