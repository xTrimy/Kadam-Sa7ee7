<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ __("You're logged in!") }}
                </div>

                <h1 class="text-3xl text-center my-4">{{ __("Patients by Day for each Hospital") }}</h1>
                <div class="w-full h-72 px-8">
                    @include('charts.PatientsByDay');
                </div>


            </div>
        </div>
    </div>
</x-app-layout>
