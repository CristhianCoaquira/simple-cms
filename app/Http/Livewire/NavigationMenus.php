<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class NavigationMenus extends Component
{
    use WithPagination;

    public $modelId;
    public $label;
    public $slug;
    public $sequence = 1;
    public $type = 'SidebarNav';

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;

    public function rules()
    {
        return [
            'label' => 'required',
            'slug' => ['required', Rule::unique('navigation_menus', 'slug')->ignore($this->modelId)],
            'sequence' => 'required',
            'type' => 'required',
        ];
    }

    public function mount()
    {
        // Resets the pagination after reload
        $this->resetPage();
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function create()
    {
        $this->validate();
        NavigationMenu::create($this->getModelData());
        $this->reset();
    }

    public function updateShowModal(NavigationMenu $navigation_menu)
    {
        $this->resetValidation();
        $this->setModelData($navigation_menu);
        $this->modalFormVisible = true;
    }

    public function update()
    {
        $this->validate();
        NavigationMenu::find($this->modelId)->update($this->getModelData());
        $this->reset();
    }

    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function delete()
    {
        NavigationMenu::destroy($this->modelId);
        $this->reset();
    }

    public function getModelData()
    {
        return [
            'label' => $this->label,
            'slug' => $this->slug,
            'sequence' => $this->sequence,
            'type' => $this->type,
        ];
    }

    public function setModelData(NavigationMenu $navigation_menu)
    {
        $this->modelId = $navigation_menu->id;
        $this->label = $navigation_menu->label;
        $this->slug = $navigation_menu->slug;
        $this->sequence = $navigation_menu->sequence;
        $this->type = $navigation_menu->type;
    }

    public function render()
    {
        return view('livewire.navigation-menus', [
            'data' => NavigationMenu::paginate(5)
        ]);
    }
}
