@extends( 'layouts.base' )

@section( 'content' )
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col pb-4" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Stock Physique' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Provides an overview of the products stock.' ) ?? __( 'No description' ) }}</p>
            </div>
        </div>
        <div id="report-section" class="px-4">
            <div id="low-stock-report" class="anim-duration-500 fade-in-entrance">
                <div class="text-primary">
                    <div class="ns-box">
                      <form class="" action="{{ route('inventories.store') }}" method="POST">
                          @csrf

                          <div class="flex justify-end p-2">
                            @if($productDetail->inventory != null)
                              <button class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded font-semibold text-sm text-white tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                              @foreach($products_detail as $products)
                              @if($products->inventory)
                              @if($products->inventory->stock_physic != 0 || $products->inventory->stock_physic != null ) disabled @endif
                              @endif
                              @endforeach>

                                  {{ __( 'Proceed' ) }}
                              </button>
                            @endif
                          </div>
                          <div class="bg-white relative overflow-x-auto">
                              <table class="table border border-gray-500 w-full">
                                  <thead class="bg-gray-300">
                                      <tr>
                                          <th class="border border-gray-500 p-2 text-left">{{ __( 'Products' ) }}</th>
                                          <th width="150" class="border border-gray-500 p-2 text-right">{{ __( 'Stock Physique' ) }}</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @forelse ($products_detail as $products)
                                        <tr class="text-sm">
                                            <td class="p-2 border border-gray-500"><span class="mx-2">{{$products->name}}</span></td>
                                              <td class="p-2 border border-gray-500 text-right">
                                                  @if($products->inventory)
                                                    <input type="text" name="product_id[]" class="hidden" value="{{$products->id}}">
                                                    <input type="number" id="physic_quantity" class="mx-2 w-28 border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="physic_quantity[]" required>
                                                  @else
                                                    <span class="mx-2">Aucune quantité</span>
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
                              </table>
                          </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
