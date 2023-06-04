@extends('layouts.base')
@section('content')
<div class="">
    <div class="text-white pb-2">
        <h1 class="text-2xl font-bold">{{ __('Accounts List') }}</h1>
        <h3>{{ __('Display All Accounts.') }}</h3>
    </div>
    <div class="rounded-md shadow-lg py-2 w-full">
        <div class="p-2">
            <a href="{{ route('expense_categories.create') }}" class="inline-flex justify-center py-2 px-4 border-2 shadow-sm text-md font-medium rounded-full text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full shadow-md rounded-lg text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-teal-400 dark:text-gray-100">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            {{ __( 'Name' ) }}
                        </th>
                        <th scope="col" class="px-2 py-3">
                            {{ __( 'Account' ) }}
                        </th>
                        <th scope="col" class="px-2 py-3">
                            {{ __( 'Operation' ) }}
                        </th>
                        <th scope="col" class="px-2 py-3">
                            {{ __( 'By' ) }}
                        </th>
                        <th scope="col" class="px-2 py-3">
                            {{ __( 'Created At' ) }}
                        </th>
                        <th scope="col" class="px-2 py-3 pr-4 text-right">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                @forelse($accounts as $account)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:bg-gray-600">
                        <td scope="row" class="px-2 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $account->name }}
                        </td>
                        <td class="px-2 py-4">
                            {{ $account->account }}
                        </td>
                        <td class="px-2 py-4">
                            {{ $account->operation }}
                        </td>
                        <td class="px-2 py-4 text-gray-900">
                            @foreach ($userDetails as $user)
                                @if($user->id == $account->author_id)
                                    <span class="font-semibold px-2 py-2 bg-green-0 rounded-full">{{ $user->name }}</span>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-2 py-4">
                            {{ $account->created_at }}
                        </td>
                        <td class="px-2 py-4 text-right">
                          @can('compte_edit')
                            <a href="{{ route('expense_categories.edit', $account->id) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                          @endcan
                          @can('compte_delete')
                            <form class="inline-block px-2" method="POST" action="{{ route('expense_categories.destroy', $account->id) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                          @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-2 py-4 text-center">Pas de Compte</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="m-2">
            {{ $accounts->links() }}
        </div>
    </div>
</div>
@endsection
