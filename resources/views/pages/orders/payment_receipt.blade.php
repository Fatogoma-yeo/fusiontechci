<?php
use App\Models\Client;
use App\Models\Orders;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\View;

$order = Orders::where(['created_at' =>now(), 'author' => Auth::id()])->firstOrFail();
$orders = OrderProduct::with('category')->where('orders_id', $order->id)->get();
$customer = Client::where('id', $order->customer_id)->firstOrFail();

?>
<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 1000)"
    class="w-full h-full" id="invoice_content">
    <div class="w-full md:w-1/2 lg:w-1/3 shadow-lg bg-white mx-auto">
        <div class="flex items-center justify-center">
            <!-- <h3 class="text-3xl font-bold">Fusiontechci</h3> -->
            <img class="w-32" src="{{ asset( 'svg/fusion_logo.svg' ) }}" alt="fusiontechci">
        </div>
        <div class="p-2 border-b border-gray-700">
            <div class="flex flex-wrap -mx-2 text-sm">
                <div class="px-2 w-1/2">
                    <span class="font-semibold">{{ __('Customer') }}</span> : {{ $customer->name }}
                </div>
                <div class="px-2 w-1/2">
                    <span class="font-semibold">{{ __('Date') }}</span> : {{ $order->created_at}}
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
                    @foreach($orders as $product )
                    <tr>
                        <td colspan="2" class="p-2 border-b border-gray-700">
                            <span class="">{{ $product->product_name }} (x{{ $product->quantity }})</span>
                            <br>
                            <span class="text-xs text-gray-600">{{ $product->category->name }}</span>
                        </td>
                        <td class="p-2 border-b border-gray-800 text-right uppercase">@currency( $product->pos_subtotal )</td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    <tr>
                        <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Sub Total' ) }}</td>
                        <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">@currency( $order->subtotal )</td>
                    </tr>
                    @if ( $order->discount > 0 )
                    <tr>
                        <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">
                            <span>{{ __( 'Discount' ) }}</span>
                        </td>
                        <td class="p-2 border-b border-gray-800 text-sm text-right">@currency( $order->discount )</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Total' ) }}</td>
                        <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">@currency( $order->total )</td>
                    </tr>
                    <!-- <tr>
                        <td colspan="2" class="font-bold p-2 border-b border-gray-800 text-sm font-semibolld">{{ __( 'Current Payment' ) }} : {{ __( 'Unknown Payment' ) }}</td>
                        <td class="p-2 border-b border-gray-800 text-sm text-right">{{ __('value')  }}</td>
                    </tr> -->
                    <tr>
                        <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Total Paid' ) }}</td>
                        <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">@currency( $order->tendered )</td>
                    </tr>
                    @switch( $order->payment_status )
                        @case( 'paids' )
                        <tr>
                            <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Change' ) }}</td>
                            <td class="p-2 border-b border-gray-800 text-sm text-right uppercase">@currency( $order->tendered )</td>
                        </tr>
                        @break
                        @case( 'partially_paid' )
                        <tr>
                            <td colspan="2" class="p-2 border-b border-gray-800 text-sm font-semibold">{{ __( 'Due' ) }}</td>
                            <td class="p-2 border-b border-gray-800 text-sm text-right">@currency( abs( $order->change ) )</td>
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

@push('javascript')
<script>
    window.print();
</script>
@endpush
