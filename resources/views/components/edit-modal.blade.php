@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
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

<div class="hidden fixed inset-0 items-center justify-center overflow-y-auto px-4 py-2 sm:px-0 z-50" id="edit-modal">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto">
        <div>
            <div class="w-full text-primary p-2 font-semibold flex justify-between">
                <div class="w-full p-1">{{ __( 'Définir la quantité' ) }}</div>
                <div class="w-full p-2 text-end">
                    <span class="border-2 p-2 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" onclick="editModalClosefun()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="w-full text-2xl font-bold text-center flex">
                <!-- <div class="w-full p-4 border" id="result">1</div> -->
                <input id="counter" class="read-only:bg-gray-100 w-full p-4 border text-center" value="" />
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(7)">7</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(8)">8</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(9)">9</div>
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(4)">4</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(5)">5</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(6)">6</div>
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(1)">1</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(2)">2</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(3)">3</div>
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="removenumber()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                    </svg>
                </div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number(0)">0</div>
                <button type="submit" class="w-full p-8 hover:bg-gray-200 border" onclick="getquantityfunc()" >Entrer</button>
            </div>
        </div>
    </div>
</div>
@push('javascript')
    <script>
        var val=document.getElementById("counter");

        function number(v){
            val.value+=v;
        }

        function cancel(){
            val.value="";
        }

        function removenumber(){
            val.value=val.value.substr(0,val.value.length-1);
        }

        function getquantityfunc() {
            document.getElementById('quantitie').innerHTML = val.value;
            var quantity = document.getElementById('quantitie').textContent;
            var price = document.getElementById('prices').textContent;
            document.getElementById('posSubTotals').innerHTML = quantity * price;

            var gtotal = 0;
            $("[id*=posSubTotals]").each(function(){
                gtotal = gtotal + parseFloat($(this).html());
            });
            $('#subTotal').html(current.format(gtotal.toString()));
            $('#Total').html(current.format(gtotal.toString()));

            edit_modal.style.display = "none";
            x.style.overflow = "auto";
            val.value="";
        }
    </script>
@endpush
