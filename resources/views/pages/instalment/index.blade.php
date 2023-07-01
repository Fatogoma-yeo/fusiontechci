@extends('layouts.base')
@section('content')
<div class="">
    <div class="rounded-md shadow-lg py-2 w-full">
        <div class="p-2">
            <a href="{{ route('instalments.create') }}" class="inline-flex justify-center py-2 px-4 border-2 shadow-sm text-md font-medium rounded-full text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
                            Type
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Numéro
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Montant
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Date de Versement
                        </th>
                        <th scope="col" class="px-2 py-3">
                            Auteur
                        </th>
                    </tr>
                </thead>
                <tbody>
                @forelse($instalments as $instalment)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $instalment->type }}
                        </th>
                        <td class="px-2 py-4 whitespace-nowrap">
                            {{ $instalment->number }}
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            @currency($instalment->amount)
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            {{ $instalment->date }}
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-gray-900">
                            @foreach ($users as $user)
                                @if($user->id == $instalment->author_id)
                                    <span class="font-semibold px-2 py-2 bg-green-0 rounded-full">{{ $user->name }}</span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-2 py-4 text-center">Aucun versement pour l'instant</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="m-2">
            {{ $instalments->links() }}
        </div>
    </div>
</div>
@endsection
