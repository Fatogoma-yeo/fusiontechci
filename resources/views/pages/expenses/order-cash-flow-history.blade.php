@extends('layouts.base')
@section('content')

<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Cash Flow List' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Display all Cash Flow.' ) ?? __( 'No description' ) }}</p>
            </div>
        </div>
        <div id="report-section" class="px-4">
            <div id="low-stock-report" class="anim-duration-500 fade-in-entrance">
                <div class="text-primary shadow rounded my-4">
                    <div class="ns-box">
                        <div class="bg-white relative overflow-x-auto">
                            <table class="table border border-gray-500 w-full">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th class="border border-gray-500 p-2 text-left">{{ __( 'Name' ) }}</th>
                                        <th width="200" class="border border-gray-500 p-2 text-left">{{ __( 'Value' ) }}</th>
                                        <th width="200" class="border border-gray-500 p-2 text-left">{{ __( 'Operation' ) }}</th>
                                        <th width="200" class="border border-gray-500 p-2 text-left">{{ __( 'By' ) }}</th>
                                        <th width="200" class="border border-gray-500 p-2 text-left">{{ __( 'Date' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cash_flow_history as $history)
                                        <tr :class="@if($history->operation === 'credit' && $history->status === 'active') 'bg-green-200' @elseif($history->operation === 'credit' && $history->status === 'inactive') 'bg-blue-200' @endif" class="text-sm">
                                            <td class="py-4 px-2 border border-gray-500">
                                                @if($history->operation == 'debit')
                                                    {{ __('Order') }} : {{ $history->name }}
                                                @else
                                                    {{ __('Sale') }} : {{ $history->name }}
                                                @endif
                                            </td>
                                            <td class="py-4 px-2 border border-gray-500 text-left">
                                                @currency($history->value)
                                            </td>
                                            <td class="py-4 px-2 border border-gray-500 text-left">
                                                @if($history->operation == 'debit')
                                                    <span class="px-2 py-2 rounded-full bg-red-400 text-white">{{ __('Débit') }}</span>
                                                @else
                                                    <span class="px-2 py-2 rounded-full bg-green-0 text-white">{{ __('Crédit') }}</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-2 border border-gray-500 text-left">
                                                @foreach ($userDetails as $user)
                                                    @if($user->id == $history->author_id)
                                                        <span class="font-semibold px-2 py-2">{{ $user->name }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="py-4 px-2 border border-gray-500 text-left">
                                                {{ $history->created_at }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 px-2 border border-gray-500 text-center">
                                                <span>{{ __( 'There is nothing to display...' ) }}</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flex justify-end p-2">
                                {{ $cash_flow_history->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
