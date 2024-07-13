<x-app-layout>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 bg-gray-100 dark:bg-gray-900">
    <h1 class=" text-white text-lg font-bold">Create new support ticket</h1>
    <div class="w-full sm:max-w-xl mt-6 px-6 py-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mt-4">
            <x-input-label for="email" :value="__('Title')" />
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="title" required autofocus autocomplete="title" />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Description')" />
            <textarea id="email" name="description"></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>


        <x-primary-button class="ml-3 px-2">
                {{ __('Submit') }}
            </x-primary-button>
    </form>
    </div>
</div>
</x-app-layout>
