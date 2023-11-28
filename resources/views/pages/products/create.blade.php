@extends('layouts.base')
@section('content')

<div class="py-2 flex justify-between">
    <label for="title" class="font-bold my-2 text-primary text-white">
        <h1 class="text-2xl font-bold">Créer un nouveau Produit</h1>
        <h3>Créez un nouveau produit et enregistrez-le.</h3>
    </label>
    <div for="title" class="text-sm my-2 text-primary">
        <a href="{{ route('products.index') }}" class="rounded-full border ns-inset-button error hover:bg-gray-200 hover:text-gray-900 text-white flex px-1 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="px-1">{{ __( 'Go Back' ) }}</span>
        </a>
    </div>
</div>
<div class="relative overflow-x-auto">
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" id="createForm">
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
            <div class="grid md:grid-cols-3 gap-6 pb-8">
                <!-- Media -->
                <div class="mt-4">
                    <x-input-label for="media" :value="__('Image')" />
                    <div class="w-full">
                        <x-media-input />
                    </div>
                </div>
                <!-- Displays on pos -->
                <div class="mt-4 w-full sm:px-6">
                    <x-input-label for="status" :value="__('Status du produit')" />
                    <div class="flex border-transparent rounded-lg bg-white shadow-lg w-full mt-1">
                        <div class="flex items-center justify-center w-full">
                          <input type="radio" name="status" id="active" checked value="1" class="hidden"/>
                          <label for="active" class="radio w-full text-center text-lg py-2 px-4 rounded-l-lg cursor-pointer hover:opacity-75">En soldes</label>
                        </div>
                        <div class="flex items-center justify-center w-full">
                          <input type="radio" name="status" id="inactive" value="0" class="hidden"/>
                          <label for="inactive" class="radio w-full text-center text-lg py-2 px-4 rounded-r-lg cursor-pointer hover:opacity-75">Cachée</label>
                        </div>
                    </div>
                </div>
                <!-- Parent -->
                <div class="mt-4">
                    <x-input-label for="category_id" :value="__('Catégorie')"/>
                    <select name="category_id" id="category_id" class="mt-1 block w-full py-2 px-3 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value=""></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id}}" name="category_id">{{ $category->name }}</option>
                            @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
