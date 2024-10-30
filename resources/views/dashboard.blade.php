<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <p>{{ __("You're logged in!") }}</p>
                    <div class="flex flex-col space-y-4">
                        <a href="{{ route('todo-list.index') }}" class="btn btn-primary">
                            {{ __('Todo Lists') }}
                        </a>
                        <a href="{{ route('profile') }}" class="btn btn-success">
                            {{ __('Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>