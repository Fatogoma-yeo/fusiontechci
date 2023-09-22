@extends('layouts.base')
@section('content')

<div class="py-2 flex justify-between">
    <label for="title" class="font-bold my-2 text-primary text-white">
        <h1 class="text-2xl font-bold">Créer une nouvelle Dépense</h1>
        <h3>Créez une nouvelle dépense et enregistrez-la.</h3>
    </label>
    <div for="title" class="text-sm my-2 text-primary">
        <a href="{{ route('expenses.index') }}" class="rounded-full border ns-inset-button error hover:bg-gray-200 hover:text-gray-900 text-white flex px-1 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="px-1">{{ __( 'Go Back' ) }}</span>
        </a>
    </div>
</div>
<div class="">
    <form method="POST" action="{{ route('expenses.store') }}" id="createForm">
        @csrf

        <div class="py-4">
            <!-- Name -->
            <x-label for="name" :value="__('Nom')" />
            <div class="flex justify-between rounded-md border-2 bg-indigo-600 border-indigo-600">
                <x-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-button>
                    {{ __('Sauvegarder') }}
                </x-button>
            </div>
        </div>

        <div class="bg-green-0 w-max rounded-md py-2 px-4">
            <x-input-label :value="__('Information Générale')" />
        </div>
        <div class="bg-white rounded-md shadow-lg px-4 w-full">
            <div class="grid md:grid-cols-2 gap-4 pb-8">
                <!-- Categories -->
                <div class="col-span-1 mt-4">
                    <x-input-label for="category_id" :value="__('Expense Category')" />
                    <select name="category_id" id="category_id" class="mt-1 block w-full py-2 px-3 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                        <option value=""></option>
                        @foreach($categories as $category)
                          @if($category->name != "Compte des achats")
                            <option value="{{ $category->id}}" name="category_id">{{ $category->name }}</option>
                          @endif
                        @endforeach
                    </select>
                    <h6 class="text-xs mt-1">{{ __('Assign the expense to a category') }}</h6>
                </div>
                <!-- Coût de depenses -->
                <div class="col-span-1 mt-4">
                    <x-input-label for="value" :value="__('Value')" />
                    <x-text-input id="value" class="block mt-1 w-full" type="number" name="value" :value="old('value')"  />
                    <h6 class="text-xs mt-1">{{ __('Is the value or the cost of the expense.') }}</h6>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
