<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $modelId;
    public $name;
    public $role;

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            'modelId' => 'required',
            'name' => 'required',
            'role' => 'required',
        ];
    }

    public function mount()
    {
        // Resets the pagination after reload
        $this->resetPage();
    }

    public function updateShowModal(User $user)
    {
        $this->resetValidation();
        $this->setModelData($user);
        $this->modalFormVisible = true;
    }

    public function update()
    {
        $this->validate();
        User::find($this->modelId)->update($this->getModelData());
        $this->reset();
    }

    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function delete()
    {
        User::destroy($this->modelId);
        $this->reset();
    }

    public function getModelData(): array
    {
        return [
            'name' => $this->name,
            'role' => $this->role,
        ];
    }

    public function setModelData(User $model): void
    {
        $this->modelId = $model->id;
        $this->name = $model->name;
        $this->role = $model->role;
    }

    public function render()
    {
        return view('livewire.users', [
            'data' => User::paginate(5),
            'roles' => User::userRoleList(),
        ]);
    }
}
