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

<div class="hidden fixed inset-0 items-center justify-center overflow-y-auto px-4 py-2 sm:px-0 z-50" id="order-partial-products-modal">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto">
        <div class="shadow-lg  w-full md:w-3/5-screen lg:w-2/5-screen h-6/7-screen flex flex-col overflow-hidden">
            <div class="p-2 flex justify-between text-primary items-center border-b">
                <h3 class="font-semibold">{{ __( 'Products' ) }} </h3>
                <div>
                    <span class="border-2 p-1 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" id="orderProductModalclose" onclick="orderPartialProductModalclosefun()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </div>
            <span class="hidden" id="preview_partial_order_id"></span>
            <div class="flex-auto p-2 overflow-y-auto" id="previewPartialOrderProducts">

            </div>
            <div class="flex justify-end p-2 border-t">
                <div class="px-1">
                    <div class="-mx-2 flex">
                        <div class="px-1">
                            <button onclick="proceedPaid()" class="bg-blue-500 rounded text-white outline-none px-2 py-2 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                               {{ __('Paid') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('javascript')
<script type="text/javascript">

function proceedPaid() {
  var id = document.getElementById('preview_partial_order_id').textContent;
  proceedPaidOrder(id);
}

</script>
@endpush
