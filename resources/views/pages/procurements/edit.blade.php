@extends('layouts.base')
@section('content')

<div class="py-2 flex justify-between">
    <label for="title" class="font-bold my-2 text-primary text-white">
        <h1 class="text-2xl font-bold">Nouvel Achats</h1>
        <h3>Faire un nouvel achat</h3>
    </label>
    <div for="title" class="text-sm my-2 text-primary">
        <a href="{{ route('procurements.index') }}" class="rounded-full border ns-inset-button error hover:bg-gray-200 hover:text-gray-900 text-white flex px-1 py-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="px-1">{{ __( 'Go Back' ) }}</span>
        </a>
    </div>
</div>
<div class="">
    <form method="POST" action="{{ route('procurements.update', $procurement->id) }}" id="editForm">
      @method('PUT')
        @csrf
        <div  class="">
            <div class="py-4">
                <!-- Name -->
                <x-label for="name" :value="__('Nom d\'approvisionnement')" />
                <div class="flex justify-between rounded-md border-2 bg-indigo-600 border-indigo-600">
                    <x-input id="name" class="block w-full" type="text" name="name" :value="$procurement->name" required autofocus />
                    <x-button>
                        {{ __('Save') }}
                    </x-button>
                </div>
            </div>

            <ul class="pt-2 px-2">
                <li  class="">
                    <a class="inline-block cursor-pointer text-white bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-md font-medium text-center border-transparent border-b-2" >Détails</a>
                </li>
            </ul>
            <div class="bg-white rounded-md shadow-lg px-4 w-full">
                <div class="">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 pb-8">
                        <!-- Invoice Number -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="invoice_number" :value="__('N° Facture')" />

                            <x-text-input id="invoice_number" class="block mt-1 w-full" type="text" name="invoice_number" :value="$procurement->invoice_number"  />
                        </div>
                        <!-- Status payment -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="status_payment" :value="__('Status de paiement')" />
                            <select name="status_payment" id="status_payment" class="mt-1 block w-full py-2 px-3 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                                <option @selected($procurement->payment_status == 'unpaid') value="unpaid">Impayé</option>
                                <option @selected($procurement->payment_status == 'paid') value="paid">Payé</option>
                            </select>
                        </div>
                        <!-- Provider -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="porvider_id" :value="__('Founisseur')" required/>
                            <select name="provider_id" id="provider_id" class="mt-1 block w-full py-2 px-3 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                                @foreach($providers as $provider)
                                    <option @selected($provider->id == $procurement->provider_id) value="{{ $provider->id}}" name="provider_id">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
