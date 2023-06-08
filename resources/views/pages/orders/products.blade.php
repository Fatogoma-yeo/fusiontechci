@if($productsDetails == null)
<div class="text-primary flex">
    <div class="w-full text-center py-4 border-b">
        <h3>{{ __( 'No products added...' ) }}</h3>
    </div>
</div>
@else
    @foreach($productsDetails as $product)
        <div class="products_item flex" id="content">
            <div class="w-full md:w-4/6 p-2 border border-l-0 border-t-0">
                <span class="hidden product_id" id="pos_product_id">{{ $product["product_id"] }}</span>
                <div class="flex justify-between product-details mb-1">
                    <h3 class="font-semibold" id="pos_product_name">{{$product["product_name"]}}</h3>
                    <div class="-mx-1 flex product-options">
                        <div class="px-1 mx-2 border-dashed py-1 border-b-2 border-red-400">
                            <a onclick="remove('{{ $product['product_id'] }}')" class="hover:text-red-500 cursor-pointer outline-none border-dashed py-1 border-b border-gray-600 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                        </div>
                        <div class="px-1 border-dashed py-1 border-b-2 @if($product['is_gross'] == 1) border-green-600 @else border-blue-400 @endif">
                            <a onclick="gross_purchase('{{ $product['product_id'] }}')" class="cursor-pointer outline-none border-dashed py-1 border-b text-sm @if($product['is_gross'] == 1) text-green-600 hover:text-green-700 @else hover:text-blue-400 @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between product-controls">
                    <div class="-mx-1 flex flex-wrap">
                        <div class="px-1 w-1/2 md:w-auto mb-1">
                            <span class="hidden posprix" id="prices">@if($product['is_gross'] == 1){{ $product["gross_purchase_price"] }}@else{{ $product["net_purchase_price"] }}@endif</span>
                            <a class="outline-none border-dashed py-1 border-b-2 border-blue-400 text-sm @if($product['is_gross'] == 1) border-green-600 text-green-600 @else border-blue-400 @endif">
                                {{ __( 'Price' ) }} :
                                <span id="net_purchase_price">
                                  @if($product['is_gross'] == 1)
                                    {{ $product["gross_purchase_price"] }} fcfa
                                  @else
                                    {{ $product["net_purchase_price"] }} fcfa
                                  @endif
                                </span>
                            </a>
                        </div>
                        <div class="px-1 w-1/2 md:w-auto mb-1">
                            <a onclick="openDiscountPopup('{{ $product['product_id'] }}')" class="cursor-pointer outline-none border-dashed py-1 border-b-2 border-blue-400 text-sm">{{ __( 'Discount' ) }} : <span id="discountValue">{{ $product['discount'] }}</span> fcfa </a>
                        </div>
                        <div class="px-1 w-1/2 md:w-auto mb-1 lg:hidden">
                            <a onclick="changeQuantity('{{ $product['product_id'] }}')" class="cursor-pointer outline-none border-dashed py-1 border-b-2 border-blue-400 text-sm" id="quantities">{{ __( 'Quantity' ) }}: {{ $product["quantity"] }} </a>
                        </div>
                        <div class="px-1 w-1/2 md:w-auto mb-1 lg:hidden">
                            <span class="hidden" id="posSubTotals">@if($product['is_gross'] == 1){{ $product["quantity"] * $product["gross_purchase_price"] }}@else{{ $product["quantity"] * $product["net_purchase_price"] }}@endif</span>
                            <span class="cursor-pointer outline-none border-dashed py-1 border-b-2 border-blue-400 text-sm">
                              {{ __( 'Total' ) }}:
                              <span id="total_purchase_price">
                                @if($product['is_gross'] == 1)
                                  {{ $product["quantity"] * $product["gross_purchase_price"] }}
                                @else
                                  {{ $product["quantity"] * $product["net_purchase_price"] }}
                                @endif
                              </span> F CFA
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="changeQuantity('{{ $product['product_id'] }}')"  class="hidden lg:flex w-1/6 p-2 border items-center justify-center cursor-pointer">
                <span class="border-b-2 border-dashed border-blue-400 p-2 quantity" id="quantitie">{{ $product["quantity"] }}</span>
            </div>
            <div class="hidden lg:flex w-1/6 p-2 border border-r-0 border-t-0 items-center justify-center posTotal">
              @if($product['is_gross'] == 1)
                {{ $product["quantity"] * $product["gross_purchase_price"] }} F CFA
              @else
                {{ $product["quantity"] * $product["net_purchase_price"] }} F CFA
              @endif
            </div>
        </div>
    @endforeach
@endif
