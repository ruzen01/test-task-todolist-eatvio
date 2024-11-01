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
            <!-- Ссылка на Todo-листы всегда видна --> 
            <a href="{{ route('todo-list.index') }}" wire:navigate>{{ __('Todolists') }}</a>   

            <!-- Ссылка на профиль видна только авторизованным пользователям --> 
            @auth 
                <a href="{{ route('profile') }}" wire:navigate>{{ __('Profile') }}</a> 
            @endauth 
        </div>   

        <!-- Имя пользователя и кнопка выхода видны только авторизованным пользователям и размещены справа -->
        <div class="ml-auto flex items-center space-x-4">
            @auth 
                <span class="text-gray-700">{{ Auth::user()->name }}</span> <!-- Имя пользователя -->
                <button wire:click="logout" class="text-gray-500">{{ __('Log Out') }}</button>   
            @else 
                <!-- Ссылка на вход для неавторизованных пользователей --> 
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300">{{ __('Log in') }}</a> 
                <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-300 ml-4">{{ __('Register') }}</a> 
            @endauth 
        </div>
    </div>   
</nav>