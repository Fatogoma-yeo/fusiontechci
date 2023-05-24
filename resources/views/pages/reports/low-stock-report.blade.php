@extends( 'layouts.base' )

@section( 'content' )
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Stock Report' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Provides an overview of the products stock.' ) ?? __( 'No description' ) }}</p>
            </div>
        </div>
        <div id="report-section" class="px-4">
            <div class="flex flex-wrap -mx-2">
                <div class="px-2 pb-2">
                    <div class="ns-button">
                        <button @click="loadReport()" class="rounded flex justify-between shadow py-1 items-center px-2 bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            <span class="pl-2">{{ __( 'Load' ) }}</span>
                        </button>
                    </div>
                </div>
                <div class="px-2">
                    <div class="ns-button">
                        <button onclick="window.print();" class="rounded flex justify-between shadow py-1 items-center px-2 bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>
                            <span class="pl-2">{{ __( 'Print' ) }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="low-stock-report" class="anim-duration-500 fade-in-entrance">
                <div class="flex w-full">
                    <div class="my-4 flex justify-between w-full">
                        <div class="text-primary">
                            <ul class="flex flex-col">
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Date : %s' ), now() ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Document : %s' ), __('Stock Report') ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'By : %s' ), Auth::user()->name ) }}</li>
                            </ul>
                        </div>
                        <div>
                            <img class="w-32" src="{{ asset( 'svg/fs.logo.svg' ) }}" alt="fusiontechci">
                        </div>
                    </div>
                </div>
                <div class="text-primary shadow rounded my-4">
                    <div class="ns-box">
                        <div class="bg-white relative overflow-x-auto">
                            <table class="table border border-gray-500 w-full">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th class="border border-gray-500 p-2 text-left">{{ __( 'Product' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Purchase Price' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Initial Quantity' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Sale Price' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Sold Stock' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'En Stock' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Total Price' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products_detail as $products)
                                        <tr class="text-sm">
                                            <td class="p-2 border border-gray-500">{{$products->name}}</td>
                                            <td class="p-2 border border-gray-500 text-right">
                                              @if(count($products->procurement) > 0)
                                                @foreach($products_history as $histories)
                                                  @if($products->id == $histories->product_id)
                                                    @currency($histories->purchase_price)
                                                  @endif
                                                @endforeach
                                              @else
                                                @currency(0)
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right" id="before_quantity">
                                              @if(count($products->procurement) > 0)
                                                @foreach($product_history as $history)
                                                  @if($products->id == $history->product_id)
                                                    {{ $history->quantity }}
                                                  @endif
                                                @endforeach
                                              @else
                                                0
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right">
                                              @if(count($products->procurement) > 0)
                                                @foreach($products_history as $histories)
                                                  @if($products->id == $histories->product_id)
                                                    @currency($histories->unit_price)
                                                  @endif
                                                @endforeach
                                              @else
                                                @currency(0)
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right hidden" id="unit_price">
                                              @if(count($products->procurement) > 0)
                                                @foreach($products_history as $histories)
                                                  @if($products->id == $histories->product_id)
                                                    {{ $histories->unit_price }}
                                                  @endif
                                                @endforeach
                                              @else
                                                0
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right" id="sold_stock">
                                              @if(count($products->procurement) > 0)
                                                @foreach($products_history as $histories)
                                                  @if($products->id == $histories->product_id)
                                                    {{ $histories->quantity }}
                                                  @endif
                                                @endforeach
                                              @else
                                                0
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right" id="en_stock">
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right hidden" id="prices">
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right" id="unit_total_prices">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="p-2 border border-gray-500 text-center">
                                                <span>{{ __( 'There is no product to display...' ) }}</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="p-2 border border-gray-500" colspan="5"></td>
                                        <td class="p-2 border border-gray-500 text-right" id="total_stock">0</td>
                                        <td class="p-2 border border-gray-500 text-right" id="total_prices">@currency(0)</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="flex justify-end p-2" v-if="stockReportResult.data">
                                <!-- <ns-paginate @load="loadStockReport( $event )" :pagination="stockReportResult"></ns-pagination> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')

<script>
    // format number to XOF format
    let current = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'XOF',
    });

    function printSaleReport(areaID){
        var printContent = document.getElementById(areaID).innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }

    $(function () {
        var beforeQuantity = document.querySelectorAll("#before_quantity");
        var soldStock = document.querySelectorAll("#sold_stock");
        var unitPrice = document.querySelectorAll("#unit_price");
        var unitTotalPrices = document.querySelectorAll("#unit_total_prices");
        var stocks = document.querySelectorAll("#en_stock");
        var total_price = document.querySelectorAll("#prices");

        let beforeQuantityValue = [];
        for (var i = 0; i < beforeQuantity.length; i++) {
          beforeQuantityValue.push(beforeQuantity[i].textContent);
        }

        let soldStockValue = [];
        for (var i = 0; i < soldStock.length; i++) {
          soldStockValue.push(soldStock[i].textContent);
        }

        let unitPriceValue = [];
        for (var i = 0; i < unitPrice.length; i++) {
          unitPriceValue.push(unitPrice[i].textContent);
        }

        let stocksValue = [];
        for (var i = 0; i < stocks.length; i++) {
          stocks[i].innerText = beforeQuantityValue[i] - soldStockValue[i];
          stocksValue.push(stocks[i].textContent);
        }

        for (var i = 0; i < total_price.length; i++) {
          total_price[i].innerText = unitPriceValue[i] * stocksValue[i];
        }

        for (var i = 0; i < unitTotalPrices.length; i++) {
          unitTotalPrices[i].innerText = current.format(unitPriceValue[i] * stocksValue[i]);
        }

        let sum_stock = 0;
        for(let i = 0; i < stocks.length; i++) {
            sum_stock += parseInt(stocks[i].innerText)
        }

        let sum_prices = 0;
        for(let i = 0; i < total_price.length; i++) {
            sum_prices += parseInt(total_price[i].innerText)
        }

        document.getElementById('total_stock').innerText = sum_stock;
        document.getElementById('total_prices').innerText = current.format(sum_prices);
    });
</script>

@endpush
