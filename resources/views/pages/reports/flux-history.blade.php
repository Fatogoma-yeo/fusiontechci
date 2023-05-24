@extends('layouts.base')
@section('content')

<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Product Histories' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Display all product stock flow.' ) ?? __( 'No description' ) }}</p>
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
                                        <th class="border border-gray-500 p-2 text-left">{{ __( 'Product' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Operation Type' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Initial Quantity' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Quantity' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'New Quantity' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Total Price' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Author' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Created At' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productsHistoryReport as $productHistory)
                                        <tr :class="@if($productHistory->operation === 'Vendue' || $productHistory->operation === 'Ajoutée')  'bg-green-200' @else 'bg-blue-200' @endif" class="text-sm">
                                            <td class="p-2 border border-gray-500">
                                                {{$productHistory->product_name}}
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                                {{$productHistory->operation}}
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                                {{$productHistory->before_quantity}}
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                                {{$productHistory->quantity}}
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                                {{$productHistory->after_quantity}}
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                                @currency($productHistory->total_price)
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                                @foreach ($userDetails as $user)
                                                    @if($user->id == $productHistory->author_id)
                                                        <span class="font-semibold px-2 py-2">{{ $user->name }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                                {{$productHistory->created_at}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="p-2 border border-gray-500 text-center">
                                                <span>{{ __( 'There is no product to display...' ) }}</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flex justify-end p-2">
                                {{ $productsHistoryReport->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection