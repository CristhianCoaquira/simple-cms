<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pages extends Component
{
    public $title;
    public $slug;
    public $content;

    public $modalFormVisible = false;

    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')],
            'content' => 'required'
        ];
    }

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
        $this->validate();
        Page::create($this->getModelData());
        $this->reset();
    }

    public function updatedTitle($value)
    {
        $this->slug = strtolower(str_replace(' ', '-', $value));
    }

    public function getModelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ];
    }

    public function render()
    {
        return view('livewire.pages');
    }
}
