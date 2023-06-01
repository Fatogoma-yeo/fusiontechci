@extends('layouts.base')
@section('content')
<div class="">
    <div class="rounded-md shadow-lg py-2 w-full">
        <div class="p-2">
            <a href="{{ route('procurements.create') }}" class="inline-flex justify-center py-2 px-4 border-2 shadow-sm text-md font-medium rounded-full text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full shadow-md rounded-lg text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-gray-500 dark:text-gray-100">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Nom
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Fournisseur
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Status de paiement
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Date de facturation
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Valeur de vente
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Valeur d'achat
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Auteur
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Crée le
                        </th>
                        <th scope="col" class="px-2 py-3 pr-4 text-right">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                @forelse($procurements as $procurement)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $procurement->name }}
                        </th>
                        <td class="px-2 py-4">
                          @foreach($providers as $provider)
                            @if($provider->id == $procurement->provider_id)
                              {{ $provider->name }}
                            @endif
                          @endforeach
                        </td>
                        <td class="px-2 py-4">
                            @if ($procurement->payment_status == 'paid')
                                {{ __('payé') }}
                            @else
                                {{ __('impayé') }}
                            @endif
                        </td>
                        <td class="px-2 py-4">
                            {{ $procurement->invoice_date }}
                        </td>
                        <td class="px-2 py-4">
                            @currency($procurement->value)
                        </td>
                        <td class="px-2 py-4">
                            @currency($procurement->cost)
                        </td>
                        <td class="px-2 py-4 text-gray-900">
                            @foreach ($userDetails as $user)
                                @if($user->id == $procurement->author_id)
                                    <span class="font-semibold px-2 py-2 bg-green-0 rounded-full">{{ $user->name }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-2 py-4">
                            {{ $procurement->created_at }}
                        </td>
                        <td class="flex px-2 py-2 justify-end">
                          @if($procurement->payment_status == 'unpaid')
                            <a onclick="paidFunction('{{ $procurement->id }}')" class="inline-flex justify-center py-1 px-1 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                            </a>
                          @endif
                            <a href="{{ route('procurements.show', $procurement->id) }}" class="inline-flex justify-center py-1 px-1 mx-2 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </a>
                            <a href="{{ route('procurements.edit', $procurement->id) }}" class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <form class="inline-block px-2 hidden" method="POST" action="{{ route('procurements.destroy', $procurement->id) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-2 py-4 text-center">Aucun approvisionnement pour l'instant</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="m-2">
            {{ $procurements->links() }}
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script type="text/javascript">
  function paidFunction(id) {
    $.ajax({
      type: "get",
      url: "{{ route('paid.procured') }}",
      data: {"procurement_id": id},
      success: function (response) {
        window.location.reload();
      }
    });
  }
</script>
@endpush
