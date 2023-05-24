<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">

        <!-- Fonts -->

        <!-- Scripts -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/style.js') }}"></script>
        <script src="{{ asset('js/toastr.js') }}"></script>
        <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

    </head>
    <body class="font-sans overflow-hidden flex" id="body">
        <x-pos-modal name="confirm-product" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <x-quantity-modal />
        </x-pos-modal>
        <x-key-modal><x-check-modal /></x-key-modal>
        <x-edit-modal />
        <x-user-modal><x-pos-user-modal /></x-user-modal>
        <x-user-select-modal><x-pos-user-select /></x-user-select-modal>
        <div id="notifDiv" class="fixed top-4 right-4 w-auto font-normal text-white ml-96 p-2 rounded-lg"></div>
        <div class="h-screen flex-auto flex flex-col bg-gray-300" id="pos-container">
            <div class="flex-auto overflow-hidden flex p-2">
                <div class="flex flex-auto overflow-hidden -m-2">
                    @yield('content')
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var queryAll = document.getElementsByClassName("posTotal");
            // format number to XOF format
            let current = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'XOF',
            });

            window.addEventListener('resize', () => {
                this._responsive.detect();
                this.defineCurrentScreen();
            });

            // function totalfun() {
            //     var $finalPrice = $('#Total');
            //     $finalPrice.on('calculate', function() {
            //         var total = 0;
            //         $('div.products_item').each(function() {
            //             var $section = $(this);
            //             var input = $section.find('input#quantity').val();
            //             var price = $section.find('.price').data('price');

            //             total += (input * price);
            //         });

            //         $finalPrice.text(total);
            //     });

            //     $finalPrice.trigger('calculate');
            // }

            function counter() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('order.wishlist') }}",
                    success: function (response) {
                        var response = JSON.parse(response);
                        $('.counter').text(response);
                    },
                });
            }

            var user_id = "{{ Auth::user()->id }}";
            $(document).ready(function() {
                $('#quantityForm').on("submit",function (e) {
                    e.preventDefault();
                    var $product_id = $("#select_product_id").val();
                    var $quantity = $("#quantity").val();
                    $.ajax({
                        type:'get',
                        url : "{{ route('orders.index') }}",
                        data:{"product_id":$product_id, "quantity":$quantity, "author_id":user_id},
                        success:function(response){
                            if (response.action == "isnt_procurement"){
                                $('#notifDiv').fadeIn();
                                $('#notifDiv').css('background', 'red');
                                $('#notifDiv').text(response.message);
                                setTimeout(() => {
                                    $('#notifDiv').fadeOut();
                                }, 5000);

                            }else if(response.action == 'is_procurement'){
                                $('#notifDiv').fadeIn();
                                $('#notifDiv').css('background', 'rgb(202 138 4)');
                                $('#notifDiv').text(response.message);
                                setTimeout(() => {
                                    $('#notifDiv').fadeOut();
                                }, 5000);
                            }else if(response.action == 'low_quantity'){
                                $('#notifDiv').fadeIn();
                                $('#notifDiv').css('background', 'red');
                                $('#notifDiv').text(response.message);
                                setTimeout(() => {
                                    $('#notifDiv').fadeOut();
                                }, 5000);
                            }else{
                                $('.product_list').html(response);
                                $(function () {
                                    var gtotal = 0;
                                    $("[id*=posSubTotals]").each(function(){
                                        gtotal = gtotal + parseFloat($(this).html());
                                    });
                                    $('#subTotal').html(gtotal.toString());
                                    $('#Total').html(gtotal.toString());
                                });
                                counter();
                            }
                        }
                    });
                });
            });

            function remove(id) {
                $.ajax({
                    type: "delete",
                    url: "{{ route('delete.pos_product') }}",
                    data:{"product_id" : id},
                    success: function(response){
                        $('.product_list').html(response);
                        $(function () {
                            var gtotal = 0;
                            $("[id*=posSubTotals]").each(function(){
                                gtotal = gtotal + parseFloat($(this).html());
                            });
                            $('#subTotal').html(gtotal.toString());
                            $('#Total').html(gtotal.toString());
                        });
                        counter();
                    }
                });
            }

            var count = 0;

            function gross_purchase(price) {
                count++;
                $("[id*=quantitie]").each(function(){
                    quantity = parseFloat($(this).html());
                });

                $.ajax({
                    type: "get",
                    url: "{{ route('gross.price') }}",
                    data:{"price" : price},
                    success: function(response) {
                        var price = response.gross_price;
                        var gross_price = price.gross_purchase_price;
                        var subtotal = gross_price * quantity;

                        $("[class*=posTotal]").each(function(){
                            $(this).html(subtotal);
                        });

                        // $(".posTotal").html(subtotal);
                        $("#posSubTotals").html(subtotal);
                        $("#net_purchase_price").html(gross_price);
                        alert(count);
                    },
                });
            }


            $(document).ready(function() {
                toastr.options.timeOut = 8000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @elseif(Session::has('warning'))
                    toastr.warning('{{ Session::get('warning') }}');
                @endif
            });

            $(document).ready(function(){
                $('.products_item').on('click', function(e){
                    e.preventDefault();
                    alert('test');
                });
            });

            function reload() {
                var result = document.getElementById("result");
                var allNum = result.textContent;
                result.innerText = 1;
            }

            function getproductfunc(p) {
                var product_id = p.children[0].children[0].value;
                var productDet = document.getElementById("select_product_id");
                productDet.value = product_id;
            }

            function sendquantityfunc() {
                var result = document.getElementById("result");
                var quantity = document.getElementById("quantity");
                var finalNum = result.textContent;
                var result = document.getElementById("result");
                var allNum = result.textContent;

                quantity.value = finalNum;
                result.innerText = 1;
            }

            function removenumberfunc() {
                var result = document.getElementById("result");
                var allNum = result.textContent;
                const newNum = Number(allNum.toString().slice(0, -1));
                result.innerText = newNum;
            }

            function number7func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number7 = n.parentElement.children[0].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number7;
                }else {
                    result.innerText += number7;
                }
            }
            function number8func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number8 = n.parentElement.children[1].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number8;
                }else {
                    result.innerText += number8;
                }
            }
            function number9func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number9 = n.parentElement.children[2].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number9;
                }else {
                    result.innerText += number9;
                }
            }
            function number4func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number4 = n.parentElement.children[0].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number4;
                }else {
                    result.innerText += number4;
                }
            }
            function number5func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number5 = n.parentElement.children[1].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number5;
                }else {
                    result.innerText += number5;
                }
            }
            function number6func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number6 = n.parentElement.children[2].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number6;
                }else {
                    result.innerText += number6;
                }
            }
            function number1func(n) {
                var result = document.getElementById("result");
                var number1 = n.parentElement.children[0].textContent;
                result.innerText += number1;
            }
            function number2func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number2 = n.parentElement.children[1].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number2;
                }else {
                    result.innerText += number2;
                }
            }
            function number3func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number3 = n.parentElement.children[2].textContent;
                if (defaultnum == 1 ) {
                    result.innerText = number3;
                }else {
                    result.innerText += number3;
                }
            }
            function number0func(n) {
                var result = document.getElementById("result");
                var defaultnum = result.textContent;
                var number0 = n.parentElement.children[1].textContent;
                result.innerText += number0;
            }

        </script>
        @stack('javascript')
    </body>
</html>
