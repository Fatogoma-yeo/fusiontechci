@extends( 'layouts.base' )

@section( 'content' )
<div class="h-full flex-auto flex flex-col">
    <div class="px-4 flex-auto flex flex-col" id="dashboard-content">
      <div class="page-inner-header mb-4 text-gray-300">
        <h3 class="text-3xl text-primary font-bold">{!! $procurement->name ?? __( 'Unamed Page' ) !!}</h3>
        <p class="text-secondary">{{ __( 'list of product procured.' ) ?? __( 'No description' ) }}</p>
      </div>
    </div>
</div>

<div class="p-4 shadow bg-gray-50">
    <div id="printable-container">
        <div class="my-4 flex justify-between">
            <div>
                <img class="w-32" src="{{ asset('svg/fusion_logo.svg') }}" alt="Logo Fusiontechci">
            </div>
            <div class="text-gray-600">
                {{ sprintf( __( 'Date : %s' ), $procurement->updated_at ) }}
            </div>
        </div>
        <div class="flex flex-wrap -mx-2">
            <div class="px-3 w-full print:w-1/2 md:w-1/2">
                <h3 class="font-semibold text-xl border-b-2 border-blue-400 py-2 mb-2">{{ __('Provider') }}</h3>
                <ul class="flex flex-col">
                    <li class="py-1"><span class="font-bold">{{ __( 'Name' ) }}: </span> {{ $procurement->provider->name }}</li>
                    <li class="py-1"><span class="font-bold">{{ __( 'Surname' ) }}: </span>{{ $procurement->provider->first_name ?? __( 'N/A' ) }}</li>
                    <li class="py-1"><span class="font-bold">{{ __( 'Email' ) }}: </span>{{ $procurement->provider->email ?? __( 'N/A' ) }}</li>
                    <li class="py-1"><span class="font-bold">{{ __( 'Phone' ) }}: </span>{{ $procurement->provider->phone ?? __( 'N/A' ) }}</li>
                    <li class="py-1"><span class="font-bold">{{ __( 'Address' ) }}: </span>{{ $procurement->provider->adress ?? __( 'N/A' ) }}</li>
                </ul>
            </div>
        </div>
        <div class="my-4">
            <table class="w-full">
                <thead class="border bg-gray-300">
                    <tr>
                        <th>{{ __( 'Product' ) }}</th>
                        <th>{{ __( 'Price' ) }}</th>
                        <th>{{ __( 'Quantity' ) }}</th>
                        <th>{{ __( 'Total' ) }}</th>
                    </tr>
                </thead>
                <tbody class="border">
                    @foreach( $procurement->procurementProduct as $product )
                    <tr>
                        <td class="border p-1">
                            <h3 class="font-semibold">{{ $product->product_name }}</h3>
                        </td>
                        <td class="text-right border p-1">@currency( $product->purchase_price )</td>
                        <td class="text-right border p-1">{{ $product->quantity }}</td>
                        <td class="text-right border p-1">@currency( $product->purchase_price * $product->quantity )</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border">
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="border p-1 font-semibold">{{ __( 'Total' ) }}</td>
                        <td class="text-right border p-1 text-yellow-600">@currency($procurement->cost )</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="border p-1 font-semibold">{{ __( 'Payment Status' ) }}</td>
                        <td class="text-right border p-1 font-semibold">
                            @if ($procurement->payment_status == 'paid')
                                {{ __('Payé') }}
                            @else
                                {{ __('Impayé') }}
                            @endif
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="flex justify-between">
        <div></div>
        <div>
            <button @click="window.print();" class="inline-flex items-center px-2 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2 inline-flex">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
                {{ __( 'Print' ) }}
            </button>
        </div>
    </div>
</div>
@endsection
