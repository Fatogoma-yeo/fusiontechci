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
                            </ul>
                        </div>
                        <div>
                            <img class="w-32" src="{{ asset( 'svg/fusion_logo.svg' ) }}" alt="fusiontechci">
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
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Sale Price' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'En Stock' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse ($products_detail as $products)
                                      <tr class="text-sm">
                                          <td class="p-2 border border-gray-500"><span class="mx-2">{{$products->name}}</span></td>
                                          <td class="p-2 border border-gray-500 text-right">
                                              @if($products->inventory)
                                                  <span class="mx-2">@currency($products->inventory->unit_price)</span>
                                              @else
                                                  <span class="mx-2">@currency(0)</span>
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right" id="en_stock">
                                              @if($products->inventory)
                                                  <span class="mx-2">{{ $products->inventory->after_quantity }}</span>
                                              @else
                                                  <span class="mx-2">0</span>
                                              @endif
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
                                        <td class="p-2 border border-gray-500" colspan="2"></td>
                                        <td class="p-2 border border-gray-500 text-right"><span class="mx-2 font-semibold" id="total_stock">0</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- <div class="flex justify-end p-2">
                            </div> -->
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

    $(function () {

        var stocks = document.querySelectorAll("#en_stock");

        let sum_stock = 0;
        for(let i = 0; i < stocks.length; i++) {
            sum_stock += parseInt(stocks[i].innerText)
        }

        document.getElementById('total_stock').innerText = sum_stock;
    });
</script>

@endpush
