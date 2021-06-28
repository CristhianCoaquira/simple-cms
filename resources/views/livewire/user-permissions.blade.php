<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click='createShowModal'>
            {{ __('Create') }}
        </x-jet-button>
    </div>
    {{-- The Data Table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Role</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Route Name</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($data as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $item->role }}</td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $item->route_name }}</td>
                                    <td>
                                        <x-jet-button wire:click='updateShowModal({{ $item->id }})'>
                                            {{ __('Update') }}
                                        </x-jet-button>
                                        <x-jet-danger-button wire:click='deleteShowModal({{ $item->id }})'>
                                            {{ __('Delete') }}
                                        </x-jet-danger-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap" colspan="2">No Results Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    {{ $data->links() }}
    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Save User Permission') }}
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label for="role" value="{{ __('Role') }}" />
                <select wire:model='role' class="block w-full mt-1 bg-gray-100 border appearance-none ">
                    <option value="">-- Select a Role --</option>
                    @foreach ($roles as $role_id => $role_name)
                        <option value="{{ $role_id }}">{{ $role_name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="role" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-jet-label for="routeName" value="{{ __('Route Name') }}" />
                <select wire:model='routeName' class="block w-full mt-1 bg-gray-100 border appearance-none ">
                    <option value="">-- Select a Route Name --</option>
                    @foreach ($routes as $routes_id => $routes_name)
                        <option value="{{ $routes_name }}">{{ $routes_name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="routeName" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            @if ($modelId)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
    {{-- Delete Navigation Menu Confirmation Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete? Once is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
