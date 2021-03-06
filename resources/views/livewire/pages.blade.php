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
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Link</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Content</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($data as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    {{ $item->title }}
                                    {!! $item->is_default_home ? '<span class="text-green-400">[Default Home
                                        Page]</span>' : '' !!}
                                    {!! $item->is_default_not_found ? '<span class="text-red-400">[Default Not Found
                                        Page]</span>' : '' !!}
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <a href="{{ URL::to('/' . $item->slug) }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        {{ $item->slug }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">{!! $item->content_limit !!}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
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
                                <td class="px-6 py-4 text-sm whitespace-nowrap" colspan="4">No Results Found</td>
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
            {{ __('Save Page') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" class="block w-full mt-1" type="text" required
                    wire:model.debounce.800ms='title' />
                <x-jet-input-error for="title" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-jet-label for="slug" value="{{ __('Slug') }}" />
                <div class="flex mt-1 rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50">
                        http://localhost:8000/
                    </span>
                    <input wire:model="slug"
                        class="flex-1 block w-full transition duration-150 ease-in-out rounded-none form-input rounded-r-md sm:text-sm sm:leading-5"
                        placeholder="url-slug">
                </div>
                <x-jet-input-error for="slug" class="mt-2" />
            </div>
            <div class="mt-4">
                <label class="flex items-center">
                    <x-jet-checkbox wire:model="isSetToDefaultHomePage" />
                    <span class="ml-2 text-sm text-gray-600">Set as the default home page</span>
                </label>
            </div>
            <div class="mt-4">
                <label class="flex items-center">
                    <x-jet-checkbox wire:model="isSetToDefaultNotFoundPage" />
                    <span class="ml-2 text-sm text-red-600">Set as the default 404 error page</span>
                </label>
            </div>
            <div class="mt-4">
                <x-jet-label for="content" value="{{ __('Content') }}" />
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                            <trix-editor class="trix-content" x-ref="trix" wire:model.debounce.100000ms="content"
                                wire:key='trix-content-unique-key'>
                            </trix-editor>
                        </div>
                    </div>
                </div>
                <x-jet-input-error for="content" class="mt-2" />
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
    {{-- Delete Page Confirmation Modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Page') }}
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