@extends('layouts.base')
@section('content')

<div class="py-2 flex justify-between">
    <label for="title" class="font-bold my-2 text-primary text-white">
        <h1 class="text-2xl font-bold">Modifier la Catégorie</h1>
        <h3>Modifiez la catégorie et enregistrez-la.</h3>
    </label>
    <div for="title" class="text-sm my-2 text-primary">
        <a href="{{ route('categories.index') }}" class="rounded-full border ns-inset-button error hover:bg-gray-200 hover:text-gray-900 text-white  px-1 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ __( 'Retour' ) }}
        </a>
    </div>
</div>
<div class="relative overflow-x-auto">
    <form method="POST" action="{{ route('categories.update', $category->id) }}" id="editForm">
        @method('PUT')
        @csrf

        <div class="py-4">
            <!-- Name -->
            <x-label for="name" :value="__('Nom')" />
            <div class="flex justify-between rounded-md border-2 bg-indigo-600 border-indigo-600">
                <x-input id="name" class="block w-full" type="text" name="name" :value="$category->name" required autofocus />
                <x-button>
                    {{ __('Sauvegarder') }}
                </x-button>
            </div>
        </div>

        <div class="bg-green-0 w-max rounded-md py-2 px-4">
            <x-input-label :value="__('Information Générale')" />
        </div>
        <div class="bg-white rounded-md shadow-lg px-4 w-full">
            <div class="grid grid-cols-3 gap-6 pb-8">
                <!-- Media -->
                <div class="mt-4">
                    <x-input-label for="media_id" :value="__('Image')" />
                    <div class="w-full">
                        <label for="fileInput" type="button" class="block w-full cursor-pointer inine-flex justify-between items-center focus:outline-none border py-2 px-4 rounded-lg shadow-sm text-left text-gray-600 bg-white hover:bg-gray-100 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-flex flex-shrink-0 w-6 h-6 -mt-1 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>						
                            Choisir l'Image
                        </label>
                        <div class="w-full text-gray-500 text-xs mt-1">Cliquer pour ajouter l'image de la catégorie</div>
                        <x-text-input name="media_id" id="fileInput" accept="image/*" class="hidden" type="file" />	
                    </div>
                </div>
                <!-- Displays on pos -->
                <div x-data ="{ checked: 2, activeClasses:'shadow rounded-lg bg-indigo-600 text-white', inactiveClasses:'focus:bg-white', active:1, inactive:0, textColor:'text-white', textInColor:'text-gray-900' }" class="mt-4 sm:px-6">
                    <x-input-label for="displays_on_pos" :value="__('Afficher sur la page de vente')" />
                    <div class="flex border-transparent rounded-lg bg-white shadow-lg w-full mt-1">
                        <label class="inline-flex items-center justify-center w-full py-2" @click=" checked = 1 " :class="checked === 1 ? activeClasses : inactiveClasses">
                            <input type="radio" name="displays_on_pos" :value="checked ===1 ? active : inactive" class="w-5 h-5 text-red-600 hidden"/>
                            <span class="ml-2 text-xl" :class="checked === 1 ? textColor : textInColor">
                                Non
                            </span>
                        </label>
                        <label class="inline-flex items-center justify-center w-full py-2" @click=" checked = 2 " :class="checked === 2 ? activeClasses : inactiveClasses">
                            <input type="radio" name="displays_on_pos" :value="checked ===2 ? active : inactive" class="w-5 h-5 text-red-600 hidden" checked/>
                            <span class="ml-2 text-xl" :class="checked === 2 ? textColor : textInColor">
                                Oui
                            </span>
                        </label>
                    </div>
                </div>
                <!-- Parent -->
                <div class="mt-4">
                    <x-input-label for="parent_id" :value="__('Parent')" />
                    <select name="parent_id" id="parent_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm" >
                        <option value=""></option>
                        
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection