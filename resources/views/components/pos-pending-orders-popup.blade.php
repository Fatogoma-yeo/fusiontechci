@props([
    'name',
    'show' => false,
    'maxWidth' => 'xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div class="hidden fixed inset-0 items-center justify-center overflow-y-auto px-4 py-2 sm:px-0 z-50" id="pending-orders-modal">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-data="{ openTab: 1, activeClasses:'shadow bg-white text-gray-800', inactiveClasses:'focus:bg-gray-500 text-white hover:text-white' }" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto" x-cloak>
        <div class="shadow-lg w-full md:w-3/5-screen lg:w-2/5-screen h-6/7-screen flex flex-col overflow-hidden">
            <div class="p-2 flex justify-between text-primary items-center border-b">
                <h3 class="font-semibold">{{ __( 'Orders' ) }}</h3>
                <div>
                    <span class="border-2 p-1 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" id="pendingModalclose" onclick="pendingModalClosefun()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="p-2 flex overflow-hidden flex-auto flex-col">
                <ul class="pt-2 px-2 flex flex-row">
                    <li  class="" @click=" openTab = 1 ">
                        <a  :class="openTab === 1 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-2 px-4 text-md font-medium text-center border-transparent border-b-2" >{{ __( 'On Hold' ) }}</a>
                    </li>
                    <li  class="" @click=" openTab = 2 ">
                        <a :class="openTab === 2 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-2 px-4 text-md font-medium text-center border-transparent border-b-2">{{ __( 'Partially Paid' ) }}</a>
                    </li>
                </ul>
                <div x-show="openTab === 1" class="flex flex-auto flex-col overflow-hidden border">
                    <div class="p-1">
                        <div class="flex justify-between rounded-md border-2 bg-blue-500 border-blue-400">
                            <x-input id="pending_search" class="block w-full" type="text" name="pending_search" :value="old('search')" />
                            <button class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded font-semibold text-sm text-white tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                          </div>
                      </div>
                      <div class="overflow-y-auto flex flex-auto">
                          <div class="flex p-2 flex-auto flex-col overflow-y-auto" id="pending_products">
                          </div>
                      </div>
                  </div>
                <div x-show="openTab === 2" class="flex flex-auto flex-col overflow-hidden border">
                    <div class="p-1">
                        <div class="flex justify-between rounded-md border-2 bg-blue-500 border-blue-400">
                            <x-input id="pending_search" class="block w-full" type="text" name="pending_search" :value="old('search')" />
                            <button class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded font-semibold text-sm text-white tracking-widest hover:bg-blue-600 focus:bg-blue-700 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                          </div>
                      </div>
                      <div class="overflow-y-auto flex flex-auto">
                          <div class="flex p-2 flex-auto flex-col overflow-y-auto" id="partial_pending_products">
                          </div>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
<script type="text/javascript">

    function proceedOpenOrder(id) {
        proceedOrderCustomer(id);
        $.ajax({
            type: 'get',
            url: "{{ route('proceed.order')}}",
            data: {"orders_id": id},
            success: function (response) {
              $('.product_list').html(response);
              $(function () {
                  var gtotal = 0;
                  var discounTotal = 0;
                  $("[id*=posSubTotals]").each(function(){
                      gtotal = gtotal + parseFloat($(this).html());
                  });
                  $("[id*=rabais]").each(function(){
                      discounTotal = discounTotal + parseFloat($(this).html());
                  });
                  $('#subTotal').html(gtotal.toString());
                  $('#Total').html(gtotal.toString() - discounTotal.toString());
              });

              document.getElementById('rabais').innerText = document.getElementById('pending_pos_discount').textContent;
              document.getElementById('orders_id').innerText = id;
              document.getElementById('pending-orders-modal').style.display = "none";
              x.style.overflow = "auto";

          }
      });
    }

    function proceedPaidOrder(id) {
      $.ajax({
          type: 'get',
          url: "{{ route('orders.detail')}}",
          data: {"order_id": id},
          success: function (response) {
              var orders = response.orders;
              document.getElementById('instalment_total').innerText = current.format(orders.total);
              document.getElementById('instalment_paid').innerText = current.format(orders.tendered);
              document.getElementById('instalment_discount').innerText = current.format(orders.discount);
              document.getElementById('instalment_change').innerText = current.format(Math.abs(orders.change));
              document.getElementById('instalment-modal').style.display = 'flex';
              document.getElementById('id_for_order').innerText = id;
          }
      });
    }

    function previewOrder(id) {
        document.getElementById('preview_orders_id').innerText = id;
        $.ajax({
            type: "get",
            url: "{{ route('preview.order') }}",
            data: {"orders_id": id},
            success: function (response) {
              $('#previewOrderProducts').html(response);
            }
        });
        document.getElementById('order-products-modal').style.display = "flex";
    }

    function previewPartialOrder(id) {
        document.getElementById('preview_partial_order_id').innerText = id;
        $.ajax({
            type: "get",
            url: "{{ route('preview_partial.order') }}",
            data: {"orders_id": id},
            success: function (response) {
              $('#previewPartialOrderProducts').html(response);
            }
        });
        document.getElementById('order-partial-products-modal').style.display = "flex";
    }

</script>
@endpush
