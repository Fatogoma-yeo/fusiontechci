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

<div class="hidden fixed inset-0 items-center justify-center overflow-y-auto px-4 py-2 sm:px-0 z-50" id="discount-modal">
    <div class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto">
        <div>
            <div class="w-full text-primary p-2 font-semibold flex justify-between">
                <div class="w-full p-1">{{ __( 'Product Discount' ) }}</div>
                <div class="w-full p-2 text-end">
                    <span class="border-2 p-2 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" onclick="discountModalClosefun()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="w-full text-2xl font-bold text-center flex">
                <div class="w-full p-4 border hidden" id="initkey"></div>
                <input id="finalValue" class="read-only:bg-gray-100 w-full p-4 border text-center" value="" />
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(7)">7</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(8)">8</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(9)">9</div>
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(4)">4</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(5)">5</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(6)">6</div>
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(1)">1</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(2)">2</div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(3)">3</div>
            </div>
            <div class="w-full text-primary text-center font-semibold flex">
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="removekeyvalue()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                    </svg>
                </div>
                <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="keyvalue(0)">0</div>
                <button type="submit" class="w-full p-8 hover:bg-gray-200 border" onclick="getkeyvaluefunc()" >Entrer</button>
            </div>
        </div>
    </div>
</div>
@push('javascript')
    <script>
        var key=document.getElementById("finalValue");

        function keyvalue(n){
            key.value+=n;
        }

        function cancel(){
            key.value="";
        }

        function removekeyvalue(){
            key.value=key.value.substr(0,key.value.length-1);
        }

        function getkeyvaluefunc() {
            var id = document.getElementById("initkey").textContent;
            if (id) {
                $.ajax({
                    type: 'get',
                    url: "{{ route('popup.discount') }}",
                    data:{"discount": key.value, "product_id": id},
                    success: function(response){
                      if (response.action == "not_reduce") {
                          $('#notifDiv').fadeIn();
                          $('#notifDiv').css('background', 'red');
                          $('#notifDiv').text(response.message);
                          setTimeout(() => {
                              $('#notifDiv').fadeOut();
                          }, 5000);
                      }else {
                        document.getElementById("rabais").textContent = key.value;
                        $('.product_list').html(response);
                        $(function () {
                            var gtotal = 0;
                            $("[id*=posSubTotals]").each(function(){
                                gtotal = gtotal + parseFloat($(this).html());
                            });
                            $('#subTotal').html(gtotal.toString());
                            $('#Total').html(gtotal.toString());
                            document.getElementById("rabais").textContent = 0;
                        });
                        counter();

                      }
                    },
                });
            }else {
                document.getElementById("rabais").textContent = key.value;
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
                counter();
            }

            discount_modal.style.display = "none";
            x.style.overflow = "auto";
            key.value="";
        }
    </script>
@endpush
