<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};
?>

<nav class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4 py-2 flex justify-between">
        <div class="flex space-x-4">
            <a href="{{ route('todo-list.index') }}" wire:navigate>{{ __('Todolists') }}</a>
            <a href="{{ route('profile') }}" wire:navigate>{{ __('Profile') }}</a>
        </div>
        <button wire:click="logout" class="text-gray-500">{{ __('Log Out') }}</button>
    </div>
</nav>