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

<div class="hidden fixed inset-0 items-center justify-center overflow-y-auto px-4 py-2 sm:px-0 z-50" id="instalment-modal">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto">
        <div class="w-full text-primary pb-1 font-semibold flex justify-between pt-2">
            <div class="w-full p-1 pl-3 flex items-center text-xl">{{ __( 'Entrer la somme perçue' ) }}</div>
            <div class="w-full p-2 text-end">
                <span class="border-2 p-2 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" id="modal-close" onclick="instalmentModalClosefun()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </div>
        </div>
        <div class="w-full py-1">
            <div class="px-2 pb-2">
                <div class="grid grid-cols-2 gap-2">
                    <span class="hidden" id="id_for_order"></span>
                    <div class="h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                        <span>{{ __( 'Total' ) }} : </span>
                        <span class="uppercase"><span class="mr-2" id="instalment_total"></span></span>
                    </div>
                    <div class="cursor-pointer h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                        <span>{{ __( 'Discount' ) }} : </span>
                        <span class="uppercase"><span class="mr-2" id="instalment_discount"></span></span>
                    </div>
                    <div class="h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                        <span>{{ __( 'Paid' ) }} : </span>
                        <span class="instalment_paid" id="instalment_paid"></span>
                    </div>
                    <div class="h-16 flex justify-between items-center border rounded-md warning md:text-2xl p-2">
                        <span>{{ __( 'Due' ) }} : </span>
                        <span class="instalment_change" id="instalment_change"></span>
                    </div>
                    <div class="col-span-2 h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                        <span>{{ __( 'Screen' ) }} : </span>
                        <div>
                            <input id="payment" name="payment" placeholder="O" class="read-only:bg-gray-100 text-end" />
                            <span>F CFA</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-2">
                <div class="-mx-2 flex">
                    <div class="px-2 flex-auto">
                        <div
                            style="margin:-1px;"
                            class="text-2xl flex flex-1 col-span-3 cursor-pointer pb-2">
                            <span class="flex w-full "><x-payment-key-tab /></span>
                        </div>
                        <div
                            onclick="makePayment()"
                            class="hover:bg-green-500 col-span-3 bg-green-600 rounded-md text-2xl text-white border h-16 flex items-center justify-center cursor-pointer">
                            {{ __( 'Full Payment' ) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('javascript')
<script type="text/javascript">
    function makePayment() {
      var cash = document.getElementById('payment').value;
      var id = document.getElementById('id_for_order').textContent;
      if (cash != '') {
        $.ajax({
            type: 'get',
            url: "{{ route('proceed.paid-order')}}",
            data: {"orders_id": id, "cash": cash},
            success: function (response) {
              if (response.action == 'error') {
                alert(response.message);
              }else {
                window.location.reload();
              }
            }
        });
      }else {
        alert('Veillez saisir une somme');
      }
    }
</script>
@endpush
