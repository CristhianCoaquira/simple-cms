<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;

    public $modelId = 0;
    public $title;
    public $slug;
    public $content;

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;

    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')->ignore($this->modelId)],
            'content' => 'required'
        ];
    }

    public function mount()
    {
        // Resets the pagination after reload
        $this->resetPage();
    }

    /**
     * Shows the modal form
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function create()
    {
        $this->validate();
        Page::create($this->getModelData());
        $this->reset();
    }

    public function updateShowModal(Page $page)
    {
        $this->resetValidation();
        $this->setModelData($page);
        $this->modalFormVisible = true;
    }

    public function update()
    {
        $this->validate();
        Page::find($this->modelId)->update($this->getModelData());
        $this->modalFormVisible = false;
        $this->reset();
    }

    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function delete()
    {
        Page::destroy($this->modelId);
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

    public function setModelData(Page $page)
    {
        $this->modelId = $page->id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
    }

    public function render()
    {
        return view('livewire.pages', [
            'data' => Page::paginate(5)
        ]);
    }
}
