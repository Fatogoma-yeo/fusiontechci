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
<div x-data="{ openTab: 1, activeClasses:'shadow bg-white text-gray-800', inactiveClasses:'focus:bg-gray-500 text-white' }" class="" x-cloak>
    <form method="POST" action="{{ route('procurements.store') }}" id="createForm">
        @csrf
        <div  class="">
            <div class="py-4">
                <!-- Name -->
                <x-label for="name" :value="__('Nom d\'approvisionnement')" />
                <div class="flex justify-between rounded-md border-2 bg-indigo-600 border-indigo-600">
                    <x-input id="name" class="block w-full" type="text" name="name" id="name" :value="old('name')" required autofocus />
                    <x-button>
                        {{ __('Sauvegarder') }}
                    </x-button>
                </div>
            </div>

            <ul class="pt-2 px-2">
                <li  class="" @click=" openTab = 1 ">
                    <a  :class="openTab === 1 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-md font-medium text-center border-transparent border-b-2" >Détails</a>
                </li>
                <li  class="" @click=" openTab = 2 ">
                    <a :class="openTab === 2 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-4 px-4 text-md font-medium text-center border-transparent border-b-2">Produits</a>
                </li>
            </ul>
            <div class="bg-white rounded-md shadow-lg px-4 w-full">
                <div  x-show="openTab === 1" class="">
                    <div class="grid md:grid-cols-3 gap-4 pb-8">
                        <!-- Invoice Number -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="invoice_number" :value="__('N° Facture')" />

                            <x-text-input id="invoice_number" class="block mt-1 w-full" type="text" name="invoice_number" :value="old('invoice_number')"  />
                        </div>
                        <!-- Invoice date -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="invoice_date" :value="__('Date de facturation')" />

                            <x-text-input id="invoice_date" class="block mt-1 w-full" type="date" name="invoice_date" :value="old('invoice_date')"  />
                        </div>
                        <!-- Status payment -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="status_payment" :value="__('Status de paiement')" />
                            <select name="status_payment" id="status_payment" class="mt-1 block w-full py-2 px-3 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                                <option value=""></option>
                                <option value="">Choisis une option</option>
                                <option value="unpaid">Impayé</option>
                                <option value="paid">Payé</option>
                            </select>
                        </div>
                        <!-- Provider -->
                        <div class="col-span-1 mt-4">
                            <x-input-label for="porvider_id" :value="__('Founisseur')" required/>
                            <select name="provider_id" id="provider_id" class="mt-1 block w-full py-2 px-3 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" onblur="procurmentNameGeneretor(this)">
                                <option value=""></option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id}}">{{ $provider->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div  x-show="openTab === 2" class="">
                    <div class="grid grid-cols-1 gap-4 pb-8">
                        <div class="col-span-1 mt-4">
                            <x-text-input id="search" class="mt-1 w-full" type="text" placeholder="Saisissez le nom du produit." />
                            <div class="product_list"></div>
                        </div>
                        <div class="col-span-1 mt-2 relative overflow-x-auto">
                            <table class="w-full rounded-lg">
                                <thead class="p-4 text-lg">
                                    <tr class="bg-teal-400 shadow-lg text-white mx-2 px-2">
                                    <th class="border-2">Nom</th>
                                    <th class="border-2">Prix unitaire</th>
                                    <th class="border-2">Prix gros</th>
                                    <th class="border-2">Prix d'achat</th>
                                    <th class="border-2">Quantité</th>
                                    <th class="border-2">Prix total</th>
                                    </tr>
                                </thead>
                                <tbody class="text-md">
                                    <tbody id="productSelect" class="myTable"></tbody>
                                    <tr class="border-b-2 border-gray-400 px-2 py-2">
                                        <td class="border-l-2 border-gray-400">
                                           <p class="ml-2"></p>
                                        </td>
                                        <td></td>
                                        <td>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td class="border-l-2 border-r-2 border-gray-400">
                                            <input class="hidden" name="value" id="value" required/>
                                            <input class="hidden" name="cost" id="cost" required/>
                                            <p class="m-2 uppercase" id="Total">0 f cfa</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('javascript')
<script type="text/javascript">
    function procurmentNameGeneretor() {
      var id = document.querySelector('#provider_id').value;
      $.ajax({
          type: "get",
          url:"{{ route('procurements.create') }}",
          data: {"provider_id": id},
          success:function (response) {
            var name = response.provider_name;
            var matches = name+'-'+"CMD"+Math.floor(Math.random() * 100);
            document.getElementById('name').value = matches;
          }
      });
    }
</script>
@endpush
