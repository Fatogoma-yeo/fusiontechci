@extends( 'layouts.base' )

@section( 'content' )
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Validation d\'inventaire' ) ?? __( 'Unamed Page' ) !!}</h3>
            </div>
        </div>
        <div id="report-section" class="px-4">
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
                <div class="text-primary shadow rounded pb-4">
                    <div class="ns-box">
                      <form action="{{ route('inventory.validate') }}" method="post">
                        @csrf

                          <div class="bg-white relative overflow-x-auto">
                            <table class="table border border-gray-500 w-full">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th class="border border-gray-500 p-2 text-left">{{ __( 'Product' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'En Stock' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Stock Physique' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Validation' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse ($products_detail as $products)
                                      <tr class="text-sm">
                                          <td class="p-2 border border-gray-500">
                                            <input class="hidden" type="number" name="product_id[]" value="{{$products->id}}">
                                            <span class="mx-2">{{$products->name}}</span>
                                          </td>
                                            <td class="p-2 border border-gray-500 text-right" id="en_stock">
                                              @if($products->inventory)
                                                  <span class="mx-2">{{ $products->inventory->after_quantity }}</span>
                                              @else
                                                  <span class="mx-2">0</span>
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right" id="stock_physic">
                                              @if($products->inventory)
                                                @if($products->inventory->stock_physic != null)
                                                  <input class="hidden" type="number" name="stock_physic[]" value="{{ $products->inventory->stock_physic }}">
                                                  <span class="mx-2">{{ $products->inventory->stock_physic }}</span>
                                                @else
                                                  <span class="mx-2">0</span>
                                                @endif
                                              @else
                                                  <input class="hidden" type="number" name="stock_physic[]" value="0">
                                                  <span class="mx-2">0</span>
                                              @endif
                                            </td>
                                            <td class="p-2 border border-gray-500 text-right flex flex-row">
                                              @if($products->inventory)
                                                <span class="flex flex-row mx-2" id="comptable">
                                                    @if($products->inventory->check_stock_physic_1 == 0)
                                                        @if(Auth::user()->email == 'comptabilite@fusiontechci.com')
                                                          <button type="button" onclick="checkStockPhysic1('{{ $products->id }}')" class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                            @if($products->inventory->stock_physic == 0 || $products->inventory->stock_physic == null) disabled @endif>

                                                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                              </svg>
                                                          </button>
                                                        @else
                                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600 inline-flex">
                                                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                          </svg>
                                                        @endif
                                                    @else
                                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 inline-flex">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                      </svg>
                                                    @endif
                                                </span>
                                                <span class="flex flex-row" id="chef_commercial">
                                                    @if($products->inventory->check_stock_physic_2 == 0)
                                                      @if(Auth::user()->email == 'servicecommercial@fusiontechci.com')
                                                         <button type="button" onclick="checkStockPhysic2('{{ $products->id }}')" class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                            @if($products->inventory->stock_physic == 0 || $products->inventory->stock_physic == null) disabled @endif>

                                                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                              </svg>
                                                          </button>
                                                      @else
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600 inline-flex">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                      @endif
                                                    @else
                                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 inline-flex">
                                                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                      </svg>
                                                    @endif
                                                </span>
                                              @else
                                                <span>-------</span>
                                              @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-2 border border-gray-500 text-center">
                                                <span>{{ __( 'There is no product to display...' ) }}</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="p-2 border border-gray-500" colspan="1"></td>
                                        <td class="p-2 border border-gray-500 text-right"><span class="mx-2 font-semibold" id="total_stock">0</span></td>
                                        <td class="p-2 border border-gray-500 text-right"><span class="mx-2 font-semibold" id="total_stock_physic">0</span></td>
                                        <td class="p-2 border border-gray-500 text-center">
                                          <span>
                                            @if($productDetail && Auth::user()->email == 'agencefke@fusiontechci.com')
                                              <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-0 rounded font-semibold text-sm text-white tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 transition ease-in-out duration-150" @if($inventoryCount != $inventoryCheckCount || $inventoryCount == 0) disabled @endif>
                                                  {{ __( 'Stocked' ) }}
                                              </button>
                                            @endif
                                          </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- <div class="flex justify-end p-2">
                            </div> -->
                        </div>
                      </form>
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
      var stock_physic = document.querySelectorAll("#stock_physic");

        let sum_stock = 0;
        for(let i = 0; i < stocks.length; i++) {
            sum_stock += parseInt(stocks[i].innerText)
        }

        let sum_stock_physic = 0;
        for(let i = 0; i < stock_physic.length; i++) {
            sum_stock_physic += parseInt(stock_physic[i].innerText)
        }

        document.getElementById('total_stock').innerText = sum_stock;
        document.getElementById('total_stock_physic').innerText = sum_stock_physic;
    });

    function checkStockPhysic1(id) {
      $.ajax({
        type: "get",
        url: "{{ route('inventory.validate') }}",
        data: {"check1_product_id": id, "check2_product_id": ''},
        success:function (response) {
           window.location.reload();
        }

      });
    }

    function checkStockPhysic2(id) {
      $.ajax({
        type: "get",
        url: "{{ route('inventory.validate') }}",
        data: {"check1_product_id": '', "check2_product_id": id},
        success:function (response) {
           window.location.reload();
        }

      });
    }

</script>

@endpush
