<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

        <!-- Fonts -->

        <!-- Scripts -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/style.js') }}"></script>
        <script src="{{ asset('js/toastr.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans">
        <div id="notifDiv" class="fixed top-4 right-4 w-auto font-normal text-white ml-96 p-4"></div>
        <div class="flex w-full" x-data="{ isOpen : true }" id="test">
            <div class="min-h-screen overflow-y-auto transition-all duration-200 column testPrint" :class="isOpen?'w-auto' : 'w-0'" id="left">
                <div class="top-left shadow-md rounded-b-lg bg-gray-0 text-white border-b-4 border-gray-500">
                    <div class="h-16 flex justify-center items-center">
                        Fusiontechci
                    </div>
                </div>
                <div class="bottom">
                    <aside class="sticky top-0 shadow-md">
                        @include('layouts.sidebar')
                    </aside>
                </div>
            </div>
            <div class="min-h-screen overflow-y-auto w-full column" id="right">
                <div class="top-right" id='test1'>
                    @include('layouts.navigation')
                </div>
                <div class="bottom bg-gray-0">
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
        <script>
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
        </script>
        <script type="text/javascript">
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            window.addEventListener('resize', () => {
                this._responsive.detect();
                this.defineCurrentScreen();
            });
            
            $(document).ready(function(){
                $('#search').on('keyup',function(e){
                    var $value= e.target.value;
                    $.ajax({
                        type : 'get',
                        url : "{{ route('product.get')}}",
                        data:{'search':$value},
                        success:function(data){
                            $('.product_list').html(data);
                        }
                    });
                });
                $(document).on('click','.list', function () {
                    var maxField = 50;
                    var wrapper = $('#productSelect');
                    var value = $(this).text();
                    var product_id = $(this).find("input[name='product_id']").val();
                    $(".product_list").html("");
                    $("#search").val("");  

                    var fieldHTML =+'<tbody class="text-md">'
                                +'       <tr class="prod_item border-b-2 border-gray-400 px-2 py-2">'
                                +'          <td class="border-2 border-gray-400">'
                                +'              <p class="ml-2">'
                                +'                  <input type="text" class="hidden" name="product_id[]" value='+product_id+'>'
                                +                   value
                                +'                  <a  class="flex items-center cursor-pointer" onclick="deleteRow(this)">'
                                +'                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-600">'
                                +'                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />'
                                +'                      </svg>'
                                +'                  </a>'
                                +'              </p>'
                                +'            </td>'
                                +'            <td class="border-2 border-gray-400">'
                                +'                <input type="number" id="net_purchase_price" class="m-2 w-auto border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="net_purchase_price[]" onkeyup="valuefunc(this)" required>'
                                +'            </td>'
                                +'            <td class="border-2 border-gray-400">'
                                +'                <input type="number" id="gross_purchase_price" class="m-2 w-auto border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="gross_purchase_price[]" :value="0" required>'
                                +'            </td>'
                                +'            <td class="border-2 border-gray-400">'
                                +'                <input type="number" id="purchase_price" class="m-2 w-auto border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="purchase_price[]"  onkeyup="pricefunc(this)" required>'
                                +'            </td>'
                                +'            <td class="border-2 border-gray-400">'
                                +'                <input type="number" id="quantity" class="m-2 w-auto border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="quantity[]"  onkeyup="quantityfunc(this)" required>'
                                +'            </td>'
                                +'            <td class="border-2 border-r-2 border-gray-400 total">'
                                +'                <p class="m-2 uppercase">0 f cfa</p>'
                                +'                <p class="m-2 uppercase value hidden">0 f cfa</p>'
                                +'            </td>'
                                +'       </tr>'
                                +'    </tbody>'; 
                    var x = 1;
                    if(x < maxField){ 
                        x++;
                        $(wrapper).append(fieldHTML);
                    }
                    // if (x < maxField) {
                    //     x++;
                    //     $( "#purchase_price" )
                    //     .keyup(function() {
                    //         var value = $( this ).val();
                    //         $( "#total" ).text( value );
                    //     })
                    //     .keyup();
                    // }

                });
            });

            function upTo(el, tagName) {
                tagName = tagName.toLowerCase();

                while (el && el.parentNode) {
                    el = el.parentNode;
                    if (el.tagName && el.tagName.toLowerCase() == tagName) {
                    return el;
                    }
                }
                return null;
            }

            function deleteRow(el) {
                var row = upTo(el, 'tr')
                if (row) row.parentNode.removeChild(row);
            }

            var Total = document.getElementById("Total");
            var cost = document.getElementById("cost");
            var Value = document.getElementById("value");
            var total = document.getElementsByClassName("total");
            var value = document.getElementsByClassName("value");
            var currency = " F CFA";

            function totalResult() {
                var cal = 0;
                for (let i = 0; i < total.length; i++) {
                    cal += parseInt(total[i].innerText);
                }
                Total.innerText = cal + currency;
                cost.value = cal;
            }
            function valueResult() {
                var cal = 0;
                for (let i = 0; i < value.length; i++) {
                    cal += parseInt(value[i].innerText);
                }
                Value.value = cal;
            }

            function quantityfunc(q) {
                var priceValue = q.parentElement.parentElement.children[3].children[0].value;
                q.parentElement.parentElement.children[5].children[0].innerHTML = q.value * priceValue + currency;
                totalResult();
                var unitValues = q.parentElement.parentElement.children[1].children[0].value;
                q.parentElement.parentElement.children[5].children[1].innerHTML = q.value * unitValues + currency;
                valueResult();
            }

            function pricefunc(p) {
                var quantityValue = p.parentElement.parentElement.children[4].children[0].value;
                p.parentElement.parentElement.children[5].children[0].innerHTML = p.value * quantityValue + currency;
                totalResult();
            }

            function valuefunc(v) {
                var unitValue = v.parentElement.parentElement.children[4].children[0].value;
                v.parentElement.parentElement.children[5].children[1].innerHTML = v.value * unitValue + currency;
                valueResult();
            }

        </script>
        @stack('javascript')
    </body>
</html>
