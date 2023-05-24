<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale() ) }}">
    <head>
        <meta charset = "utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Fonts -->

        <!-- Scripts -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="w-full h-full" id="invoice_content">
            <div class="w-full md:w-1/2 lg:w-1/3 shadow-lg bg-white p-2 mx-auto">
                <div class="flex items-center justify-center">
                    <h3 class="text-3xl font-bold">Fusiontechci</h3>
                    <!-- <img src="" alt=""> -->
                </div>
                <div class="p-2 border-b border-gray-700">
                    <div class="flex flex-wrap -mx-2 text-sm">
                        <div class="px-2 w-1/2">
                            <span class="font-semibold">{{ __('Customer') }}</span> : {{ $customer_name }}
                        </div>
                        <div class="px-2 w-1/2">
                            <span class="font-semibold">{{ __('Date') }}</span> : {{ $orders->date}}
                        </div>
                    </div>
                </div>
                <div class="table w-full">
                    <table class="w-full">
                        <thead>
                            <tr class="font-semibold">
                                <td colspan="2" class="p-2 border-b border-gray-800">{{ __( 'Product' ) }}</td>
                                <td class="p-2 border-b border-gray-800 text-right">{{ __( 'Total' ) }}</td>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($ordersDetails as $product )
                            <tr>
                                <td colspan="2" class="p-2 border-b border-gray-700">
                                    <span class="">{{ $product->product_name }} (x{{ $product->quantity }})</span>
                                    <br>
                                    @if ($categoryDetail->id == $product->product_category_id)
                                        <span class="text-xs text-gray-600">{{ $categoryDetail->name }}</span>
                                    @endif
                                </td>
                                <td class="p-2 border-b border-gray-800 text-right uppercase">{{ $product->pos_subtotal }} f cfa</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Sub Total' ) }}</td>
                                <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">{{ $orders->subtotal }} f cfa</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Total' ) }}</td>
                                <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">{{ $orders->subtotal - $orders->discount }} f cfa</td>
                            </tr>
                            <!-- <tr>
                                <td colspan="2" class="font-bold p-2 border-b border-gray-800 text-sm font-semibolld">{{ __( 'Current Payment' ) }} : {{ __( 'Unknown Payment' ) }}</td>
                                <td class="p-2 border-b border-gray-800 text-sm text-right">{{ __('value')  }}</td>
                            </tr> -->
                            <tr>
                                <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Total Paid' ) }}</td>
                                <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">{{ $orders->subtotal - $orders->discount }} f cfa</td>
                            </tr>
                            @switch( $orders->status )
                                @case( 'sold' )
                                <tr>
                                    <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Change' ) }}</td>
                                    <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">0 f cfa</td>
                                </tr>
                                @break
                                @case( 'partially' )
                                <tr>
                                    <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Due' ) }}</td>
                                    <td class="p-2 border-b border-gray-800 text-sm text-right">{{ ns()->currency->define( abs( $orders->change ) ) }}</td>
                                </tr>
                                @break
                            @endswitch
                        </tbody>
                    </table>
                    <!-- <div class="pt-6 pb-4 text-center text-gray-800 text-sm">
                        <strong>{{ __( 'Note: ' ) }}</strong> {{ __('order-note') }}
                    </div> -->
                    <div class="pt-6 pb-4 text-center text-gray-800 text-sm">
                        
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.print();
        </script>
    </body>
</html>