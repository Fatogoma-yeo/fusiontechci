
<div class="w-full text-primary pb-1 font-semibold flex justify-between pt-2">
    <div class="w-full p-1 pl-3 flex items-center text-xl">{{ __( 'Entrer la somme perçue' ) }}</div>
    <div class="w-full p-2 text-end">
        <span class="border-2 p-2 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" id="modal-close" onclick="modalClosefun()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </span>
    </div>
</div>
<div class="w-full py-1">
    <div class="px-2 pb-2">
        <div class="grid grid-cols-2 gap-2">
            <div id="details" class="h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                <span>{{ __( 'Total' ) }} : </span>
                <span class="uppercase"><span class="mr-2" id="total_value"></span>f cfa</span>
            </div>
            <div id="discount" @click="toggleDiscount()" class="cursor-pointer h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                <span>{{ __( 'Discount' ) }} : </span>
                <span class="discount_value">0 F CFA</span>
            </div>
            <!-- <div id="paid" class="h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                <span>{{ __( 'Paid' ) }} : </span>
                <span class="paid_value" id="paid_value"></span>
            </div>
            <div id="change" class="h-16 flex justify-between items-center border rounded-md warning md:text-2xl p-2">
                <span>{{ __( 'Change' ) }} : </span>
                <span class="change_value">0 F CFA</span>
            </div> -->
            <div id="change" class="col-span-2 h-16 flex justify-between items-center border rounded-md md:text-2xl p-2">
                <span>{{ __( 'Screen' ) }} : </span>
                <div>
                    <input id="cash" placeholder="O" class="read-only:bg-gray-100 text-end" />
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
                    <span class="flex w-full "><x-key-value /></span>
                </div>
                <div
                    onclick="makeFullPayment()"
                    class="hover:bg-green-500 col-span-3 bg-green-600 rounded-md text-2xl text-white border h-16 flex items-center justify-center cursor-pointer">
                    {{ __( 'Full Payment' ) }}</div>
            </div>
        </div>
    </div>
</div>