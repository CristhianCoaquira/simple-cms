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
                                    Label</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Url</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Sequence</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Type
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($data as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $item->label }}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <a href="{{ $item->slug }}" class="text-indigo-600 hover:text-indigo-900"
                                        target="_blank">
                                        {{ $item->slug }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $item->sequence }}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $item->type }}</td>
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
                                <td class="px-6 py-4 text-sm whitespace-nowrap" colspan="5">No Results Found</td>
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
            {{ __('Navigation Menu') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="label" value="{{ __('Label') }}" />
                <x-jet-input id="label" class="block w-full mt-1" type="text" required
                    wire:model.debounce.800ms='label' />
                <x-jet-input-error for="label" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <div class="flex mt-1 rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50">
                        http://localhost:8000/
                    </span>
                    <x-jet-input id="slug"
                        class="flex-1 block w-full transition duration-150 ease-in-out rounded-none form-input rounded-r-md sm:text-sm sm:leading-5"
                        type="text" required wire:model='slug' />
                </div>
                <x-jet-input-error for="slug" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="sequence" value="{{ __('Sequence') }}" />
                <x-jet-input id="sequence" class="block w-full mt-1" type="number" required wire:model='sequence' />
                <x-jet-input-error for="sequence" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <select id="type" wire:model='type'
                    class="block w-full px-4 py-3 pr-8 leading-tight text-gray-700 bg-gray-100 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="SidebarNav">SidebarNav</option>
                    <option value="TopNav">TopNav</option>
                </select>
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
            {{ __('Delete Navigation Menu') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete your page? Once your page is deleted, all of its resources and data will be permanently deleted.') }}
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