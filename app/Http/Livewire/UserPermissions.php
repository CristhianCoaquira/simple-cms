<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class UserPermissions extends Component
{
    use WithPagination;

    public $modelId;
    public $role;
    public $routeName;

    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;


    /**
     * Put your custom properties here
     */

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            'role' => 'required',
            'routeName' => 'required',
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
        Gate::authorize('admin');
        UserPermission::create($this->getModelData());
        $this->reset();
    }

    public function updateShowModal(UserPermission $user_permission)
    {
        $this->resetValidation();
        $this->setModelData($user_permission);
        $this->modalFormVisible = true;
    }

    public function update()
    {
        $this->validate();
        Gate::authorize('admin');
        UserPermission::find($this->modelId)->update($this->getModelData());
        $this->reset();
    }

    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function delete()
    {
        UserPermission::destroy($this->modelId);
        $this->reset();
    }

    public function getModelData()
    {
        return [
            'role' => $this->role,
            'route_name' => $this->routeName,
        ];
    }

    public function setModelData(UserPermission $model)
    {
        $this->modelId = $model->id;
        $this->role = $model->role;
        $this->routeName = $model->route_name;
    }

    public function render()
    {
        return view('livewire.user-permissions', [
            'data' => UserPermission::paginate(5),
            'roles' => User::userRoleList(),
            'routes' => UserPermission::routeNameList(),
        ]);
    }
}
