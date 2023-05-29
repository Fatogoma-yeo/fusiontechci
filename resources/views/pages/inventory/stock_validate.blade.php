@extends( 'layouts.base' )

@section( 'content' )
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Validation du Stock Hors Service ' ) ?? __( 'Unamed Page' ) !!}</h3>
            </div>
        </div>
        <div id="report-section" class="px-4">
            <div id="low-stock-report" class="anim-duration-500 fade-in-entrance">
                <div class="flex w-full">
                    <div class="my-4 flex justify-between w-full">
                        <div class="text-primary">
                            <ul class="flex flex-col">
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Date : %s' ), now() ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Document : %s' ), __('Validation Stock HS') ) }}</li>
                            </ul>
                        </div>
                        <div>
                            <img class="w-32" src="{{ asset( 'svg/fusion_logo.svg' ) }}" alt="fusiontechci">
                        </div>
                    </div>
                </div>
                <div class="text-primary shadow rounded pb-4">
                    <div class="ns-box">
                      <form action="{{ route('inventory.stock-validate') }}" method="post">
                        @csrf

                          <div class="bg-white relative overflow-x-auto">
                            <table class="table border border-gray-500 w-full">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th class="border border-gray-500 p-2 text-left">{{ __( 'Product' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Sale Price' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Stock HS' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Stock HS Saisi' ) }}</th>
                                        <th width="150" class="border border-gray-500 p-2 text-left">{{ __( 'Validation' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse ($stock_hs_detail as $inventory)
                                      <tr class="text-sm">
                                          <input class="hidden" type="number" name="product_id[]" value="{{$inventory->product->id}}">
                                          <td class="p-2 border border-gray-500"><span class="mx-2">{{$inventory->product->name}}</span></td>
                                          <td class="p-2 border border-gray-500 text-right">
                                              <span class="mx-2">@currency($inventory->unit_price)</span>
                                          </td>
                                          <td class="p-2 border border-gray-500 text-right" id="stock_hs">
                                            @if($inventory->stock_hs != null)
                                              <span class="mx-2">{{ $inventory->stock_hs }}</span>
                                            @else
                                              <span class="mx-2">{{ $inventory->stock_hs }}</span>
                                            @endif
                                          </td>
                                          <td class="p-2 border border-gray-500 text-right">
                                            @if($inventory->stock_hs_physic != null)
                                              <input class="hidden" type="number" name="stock_hs_physic[]" value="{{ $inventory->stock_hs_physic }}">
                                              <span class="mx-2" id="stock_hs_physic">{{ $inventory->stock_hs_physic }}</span>
                                            @else
                                              <input class="hidden" type="number" name="stock_hs_physic[]" value="0">
                                              <span class="mx-2" id="stock_hs_physic">0</span>
                                            @endif
                                          </td>
                                          <td class="p-2 border border-gray-500 text-right flex flex-row">
                                              <span class="flex flex-row mx-2" id="comptable">
                                                @if($inventory->check_stock_hs_1 == 0)
                                                  <a onclick="checkStockHs1('{{ $inventory->product->id }}')" class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                    @if($inventory->stock_hs_physic == 0 || $inventory->stock_hs_physic == null) disabled @endif>

                                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                      </svg>
                                                  </a>
                                                @else
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 inline-flex">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                  </svg>
                                                @endif
                                              </span>
                                              <span class="flex flex-row" id="chef_comptable">
                                                @if($inventory->check_stock_hs_2 == 0)
                                                  <a onclick="checkStockHs2('{{ $inventory->product->id }}')" class="inline-flex justify-center py-1 px-2 border border-transparent shadow-sm text-md font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                    @if($inventory->stock_hs_physic == 0 || $inventory->stock_hs_physic == null) disabled @endif>

                                                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                      </svg>
                                                  </a>
                                                @else
                                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 inline-flex">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                  </svg>
                                                @endif
                                              </span>
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
                                        <td class="p-2 border border-gray-500 text-right"><span class="mx-2 font-semibold" id="total_stock_physic">0</span></td>
                                        <td class="p-2 border border-gray-500 text-center">
                                          <span>
                                            @if($stock_hs_detail)
                                              <button class="inline-flex items-center px-4 py-2 bg-gray-0 rounded font-semibold text-sm text-white tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 transition ease-in-out duration-150" @if($inventoryCount != $inventoryCheckCount || $inventoryCount == 0) disabled @endif>
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

      var stocks = document.querySelectorAll("#stock_hs");
      var stock_physic = document.querySelectorAll("#stock_hs_physic");

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

    function checkStockHs1(id) {
      $.ajax({
        type: "get",
        url: "{{ route('inventory.stock-validate') }}",
        data: {"check_1_product_id": id, "check_2_product_id": ''},
        success:function (response) {
           window.location.reload();
        }

      });
    }

    function checkStockHs2(id) {
      $.ajax({
        type: "get",
        url: "{{ route('inventory.stock-validate') }}",
        data: {"check_1_product_id": '', "check_2_product_id": id},
        success:function (response) {
           window.location.reload();
        }

      });
    }

</script>

@endpush
