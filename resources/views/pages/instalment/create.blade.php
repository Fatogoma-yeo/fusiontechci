@extends('layouts.base')
@section('content')

<div class="py-2 flex justify-between">
    <label for="title" class="font-bold my-2 text-primary text-white">
        <h1 class="text-2xl font-bold">Nouvel Versements</h1>
        <h3>Faire un nouvel versement</h3>
    </label>
    <div for="title" class="text-sm my-2 text-primary">
        <a href="{{ route('instalments.index') }}" class="rounded-full border ns-inset-button error hover:bg-gray-200 hover:text-gray-900 text-white  px-1 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ __( 'Retour' ) }}
        </a>
    </div>
</div>
<div>
    <form method="POST" action="{{ route('instalments.store') }}">
        @csrf
        <div  class="">
            <div class="flex justify-end py-4">
                <button class="inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded font-semibold text-sm text-white tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Sauvegarder') }}
                </button>
            </div>
            <div class="bg-white rounded-md shadow-lg px-4 w-full">
                <div>
                    <div class="grid md:grid-cols-2 gap-4 pb-8">
                        <!-- Instalment Type -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="instalment_type" :value="__('Type de Versement')" />
                            <select name="instalment_type" id="instalment_type" class="mt-1 block w-full py-2 px-3 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value=""></option>
                                <option value="Bancaire">Bancaire</option>
                                <option value="Orange Money">Orange Money</option>
                                <option value="Moov Money">Moov Money</option>
                                <option value="MTN Money">MTN Money</option>
                            </select>
                        </div>
                        <!-- Instalment Number -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="instalment_number" :value="__('N° de Bordereau / MoMo')" />
                            <x-text-input id="instalment_number" class="block mt-1 w-full" type="number" name="instalment_number" :value="old('instalment_number')"  required/>
                        </div>
                        <!-- Instalment Amount -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="instalment_amount" :value="__('Montant du Versement')" />
                            <x-text-input id="instalment_amount" class="block mt-1 w-full" type="number" name="instalment_amount" :value="old('instalment_amount')"  required/>
                        </div>
                        <!-- Instalment date -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="instalment_date" :value="__('Date de Versement')" />
                            <x-text-input id="instalment_date" class="block mt-1 w-full" type="date" name="instalment_date" :value="old('instalment_date')"  required/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
