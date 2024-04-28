<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>User Information</h1>
                    <div class="profile-info">
                        <p>Name: {{ $user->name }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>Total Score: {{ $user->total_score }}</p>
                        <p>Overall Performance: {{ $user->overall_performance }}</p>
                        <p>Current Level: {{ $user->current_level }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>Level Wise Information</h1>
                    <div class="level-info">
                        <p>Name: {{ $user->name }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>Total Score: {{ $user->total_score }}</p>
                        <p>Overall Performance: {{ $user->overall_performance }}</p>
                        <p>Current Level: {{ $user->current_level }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
