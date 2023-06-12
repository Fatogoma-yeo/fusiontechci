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

<div class="hidden fixed inset-0 items-center justify-center overflow-y-auto px-4 py-2 sm:px-0 z-50" id="order-products-modal">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto">
        <div class="shadow-lg  w-full md:w-3/5-screen lg:w-2/5-screen h-6/7-screen flex flex-col overflow-hidden">
            <div class="p-2 flex justify-between text-primary items-center border-b">
                <h3 class="font-semibold">{{ __( 'Products' ) }} </h3>
                <div>
                    <span class="border-2 p-1 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" id="orderProductModalclose" onclick="orderProductModalclosefun()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </div>
            <span class="hidden" id="preview_orders_id"></span>
            <div class="flex-auto p-2 overflow-y-auto" id="previewOrderProducts">

            </div>
            <div class="flex justify-end p-2 border-t">
                <div class="px-1">
                    <div class="-mx-2 flex">
                        <div class="px-1">
                            <button onclick="openOrder()" class="bg-blue-500 rounded text-white outline-none px-2 py-3 text-md">{{ __( 'Open' ) }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('javascript')
<script type="text/javascript">
  function openOrder() {
        var id = document.getElementById('preview_orders_id').textContent;
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

              document.getElementById('order-products-modal').style.display = "none";
              document.getElementById('pending-orders-modal').style.display = "none";
              x.style.overflow = "auto";
          }
      });
  }
</script>
@endpush
