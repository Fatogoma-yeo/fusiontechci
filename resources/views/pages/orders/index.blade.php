@extends('layouts.default')
@section('content')
<div x-data ="{ openTab: 2, activeClasses:'shadow bg-white text-gray-800', inactiveClasses:'focus:bg-gray-100 text-white' }" class="h-full flex-auto flex flex-col" id="pos-container" x-cloak>
    <div class="flex overflow-hidden flex-shrink-0 px-2 pt-2 pb-1">
        <div class="-mx-2 flex overflow-x-auto pb-1">
            <div class="header-buttons flex px-2 flex-shrink-0">
                <div class="px-2 flex flex-row gap-2 overflow-x-auto">
                    <a href="{{route('dashboard')}}" class="bg-green-600 inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-6 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        {{ __('Dashboard') }}
                    </a>
                    <button id="ordermodal" class="bg-gray-100 inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-sm text-gray-900 hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5V18M15 7.5V18M3 16.811V8.69c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 010 1.954l-7.108 4.061A1.125 1.125 0 013 16.811z" />
                        </svg>
                        {{ __('Orders') }}
                    </button>
                    <button id="usermodal" class="bg-gray-100 inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-sm text-gray-900 hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Clients') }}
                    </button>
                    <a href="" class="bg-gray-100 inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-sm text-gray-900 hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                        </svg>
                        {{ __('Réinitialiser') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <ul class="md:hidden flex flex-row px-4">
        <li  class="" @click=" openTab = 1 " id="panier">
            <button  :class="openTab === 1 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-2 px-2 text-md font-medium text-center border-transparent border-b-2" >
                <span> {{ __( 'Cart' ) }} </span>
                <span class="inline-flex items-center justify-center text-sm rounded-full h-6 w-6 bg-green-500 text-white ml-1 counter"> 0 </span>
            </button>
        </li>
        <li  class="" @click=" openTab = 2 " id="product">
            <button :class="openTab === 2 ? activeClasses : inactiveClasses" class="inline-block cursor-pointer text-gray-900 bg-gray-500 hover:text-gray-600 hover:border-gray-300 rounded-t-lg py-2 px-2 text-md font-medium text-center border-transparent border-b-2">
                {{ __( 'Products' ) }}
            </button>
        </li>
    </ul>
    <div class="flex-auto overflow-hidden flex px-2 pb-2">
        <div class="flex flex-auto overflow-hidden -m-2">
            <div class="flex w-full md:flex md:w-1/2 hidden overflow-hidden p-2" id="pos-cart-div">
                <div id="pos-cart" class="flex-auto flex flex-col rounded-md bg-gray-100">
                    <div class="rounded shadow flex flex-col flex-auto overflow-hidden">
                        <div class="flex flex-col h-full justify-between">
                            <div class="w-full text-primary font-semibold flex">
                                <div class="w-full lg:w-4/6 p-2 border border-l-0 border-t-0">{{ __( 'Product' ) }}</div>
                                <div class="hidden lg:flex lg:w-1/6 p-2 border border-t-0">{{ __( 'Quantity' ) }}</div>
                                <div class="hidden lg:flex lg:w-1/6 p-2 border border-r-0 border-t-0">{{ __( 'Total' ) }}</div>
                            </div>
                            <div class="flex flex-auto flex-col overflow-auto product_list">
                                <!-- Loop Procuts On Cart -->
                                @include('pages.orders.products')
                                <!-- End Loop -->
                            </div>
                            <div class="w-full flex flex-col">
                                <table class="w-full border text-sm font-light">
                                    <tbody>
                                        <tr class="border-b">
                                            <td class="whitespace-nowrap border-r px-4 py-2">
                                                <a @click="userselectmodal()" class="cursor-pointer outline-none border-dashed py-1 border-b-2 border-blue-400 text-sm" id="selectuser">{{ __( 'Customer' ) }}: <span class="font-bold" id="pos_customer">N/A</span></a>
                                            </td>
                                            <td class="whitespace-nowrap border-r px-4 py-2">
                                                {{ __( 'Sub Total' ) }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2"><span class="flex justify-end uppercase font-bold gap-2"><span id="subTotal">0</span> f fca</span></td>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="whitespace-nowrap border-r px-4 py-2">
                                              <span class="hidden" id="orders_id"></span>
                                            </td>
                                            <td class="whitespace-nowrap border-r px-4 py-2">
                                                {{ __( 'Discount' ) }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2"><span class="flex justify-end uppercase gap-2"><span id="rabais">0</span> f fca</span></td>
                                        </tr>
                                        <tr class="border-b bg-green-600 text-white">
                                            <td class="whitespace-nowrap border-r px-4 py-2">
                                            </td>
                                            <td class="whitespace-nowrap border-r px-4 py-2">
                                                {{ __( 'Total' ) }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2"><span class="flex justify-end uppercase font-bold gap-2"><span id="Total">0</span> f fca</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="w-full h-16 pt-1 flex flex-row">
                                    <div @click="save_form()" id="save_posForm" class="flex-shrink-0 w-1/4 flex items-center font-bold cursor-pointer justify-center bg-green-500 text-white hover:bg-green-600 border-r border-green-600 flex-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mr-2 inline-flex">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                        </svg>
                                        <span class="text-lg hidden md:inline lg:text-2xl">{{ __( 'Pay' ) }}</span>
                                    </div>
                                    <div @click="waiting_pos()" id="hold-button" class="flex-shrink-0 w-1/4 flex items-center font-bold cursor-pointer justify-center bg-blue-500 text-white border-r hover:bg-blue-600 border-blue-600 flex-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mr-2 inline-flex">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                        </svg>
                                        <span class="text-lg hidden md:inline lg:text-2xl">{{ __( 'Hold' ) }}</span>
                                    </div>
                                    <div @click="openDiscountPopup()" id="discount-button" class="flex-shrink-0 w-1/4 flex items-center font-bold cursor-pointer justify-center bg-white border-r border-box-edge hover:bg-indigo-100 flex-auto text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mr-2 inline-flex">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185zM9.75 9h.008v.008H9.75V9zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 4.5h.008v.008h-.008V13.5zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                        <span class="text-lg hidden md:inline lg:text-2xl">{{ __( 'Discount' ) }}</span>
                                    </div>
                                    <div @click="voidOngoingOrder()" id="void-button" class="flex-shrink-0 w-1/4 flex items-center font-bold cursor-pointer justify-center bg-red-500 text-white border-box-edge hover:bg-red-600 flex-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 mr-2 inline-flex">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                                        </svg>
                                        <span class="text-lg hidden md:inline lg:text-2xl">{{ __( 'Void' ) }}</span>
                                    </div>
                                </div>
                                @include('pages.orders.orders_form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2 sm:w-full flex overflow-hidden w-full p-2" id="pos-grid-div">
                <div id="pos-grid" class="flex flex-auto flex-col rounded-md  bg-gray-100">
                    <div id="grid-container" class="rounded shadow  overflow-hidden flex flex-auto flex-col">
                        <div class="px-2 py-2 sm:px-2">
                            <div class="border border-gray-300 flex justify-between rounded-lg">
                                <div class="border-r px-2 flex items-center border-gray-300">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" id="pos_search" class="bg-gray-50 border-transparent rounded-r-md focus:border-transparent focus:ring-0 text-gray-900 text-sm block w-full"  placeholder="{{__('Search for products.')}}">
                            </div>
                        </div>
                        <div class="overflow-hidden h-full flex-col flex">
                            @if($product_detail != null)
                                <div class="flex xs:grid-cont-2 lg:grid-container sm:grid-cont-4 md:grid-cont-3 gap-0 flex-auto overflow-auto w-full h-full" id="pos_products">

                                </div>
                            @else
                                <div class="h-full w-full flex items-center justify-center flex-col">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 504 512" class="h-6 w-6">
                                        <path d="M456 128c26.5 0 48-21 48-47 0-20-28.5-60.4-41.6-77.8-3.2-4.3-9.6-4.3-12.8 0C436.5 20.6 408 61 408 81c0 26 21.5 47 48 47zm0 32c-44.1 0-80-35.4-80-79 0-4.4.3-14.2 8.1-32.2C345 23.1 298.3 8 248 8 111 8 0 119 0 256s111 248 248 248 248-111 248-248c0-35.1-7.4-68.4-20.5-98.6-6.3 1.5-12.7 2.6-19.5 2.6zm-128-8c23.8 0 52.7 29.3 56 71.4.7 8.6-10.8 12-14.9 4.5l-9.5-17c-7.7-13.7-19.2-21.6-31.5-21.6s-23.8 7.9-31.5 21.6l-9.5 17c-4.1 7.4-15.6 4-14.9-4.5 3.1-42.1 32-71.4 55.8-71.4zm-160 0c23.8 0 52.7 29.3 56 71.4.7 8.6-10.8 12-14.9 4.5l-9.5-17c-7.7-13.7-19.2-21.6-31.5-21.6s-23.8 7.9-31.5 21.6l-9.5 17c-4.2 7.4-15.6 4-14.9-4.5 3.1-42.1 32-71.4 55.8-71.4zm80 280c-60.6 0-134.5-38.3-143.8-93.3-2-11.8 9.3-21.6 20.7-17.9C155.1 330.5 200 336 248 336s92.9-5.5 123.1-15.2c11.5-3.7 22.6 6.2 20.7 17.9-9.3 55-83.2 93.3-143.8 93.3z"/>
                                    </svg>
                                    <p class="text-sm">{{ __( 'Well.. nothing to show for the meantime' ) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script>

    const x = document.getElementsByTagName('BODY')[0] // Select body tag because of disable scroll when modal is active
    const modal = document.getElementById('modal') // modal
    const edit_modal = document.getElementById('edit-modal') // edit modal
    const discount_modal = document.getElementById('discount-modal') // discount modal
    const modalClose = document.getElementById('modal-close') // close modal button
    // const modalBtn = document.getElementById('modal-button') // launch modal button
    const user_modal = document.getElementById('user-modal') // modal
    const userModalClose = document.getElementById('userModalclose') // close modal button
    const user_select = document.getElementById('user-select') // modal
    // var total = document.getElementById('Total').innerText;

    var panier = document.getElementById("panier");
    var product = document.getElementById("product");
    var pos_cart = document.getElementById("pos-cart-div");
    var pos_grid = document.getElementById("pos-grid-div");

    $(panier).on("click", function(e) {
        e.preventDefault();
        pos_cart.classList.remove("hidden");
        pos_grid.classList.add("hidden");
    });
    $(product).on("click", function(e) {
        e.preventDefault();
        pos_cart.classList.add("hidden");
        pos_grid.classList.remove("hidden");
    });


    // Select and trigger all close buttons
    function modalClosefun() {
        modal.style.display = "none";
        x.style.overflow = "auto";
    }

    $(document).on('click','#usermodal',function () {
        var ids = document.getElementById('usermodal');
        if (ids) {
            user_modal.style.display = "flex"; // Show modal
            x.style.overflow = "hidden"; //Disable scroll on body
        }
    });

    function userModalClosefun() {
        user_modal.style.display = "none";
        x.style.overflow = "auto";
    }

    function pendingModalClosefun() {
        document.getElementById('pending-orders-modal').style.display = "none";
        x.style.overflow = "auto";
    }

    function instalmentModalClosefun() {
        document.getElementById('instalment-modal').style.display = "none";
        x.style.overflow = "auto";
    }

    function orderProductModalclosefun() {
        document.getElementById('order-products-modal').style.display = "none";
        x.style.overflow = "auto";
    }

    function orderPartialProductModalclosefun() {
        document.getElementById('order-partial-products-modal').style.display = "none";
        x.style.overflow = "auto";
    }

    function userselectmodal() {
        var ids = document.getElementById('selectuser');
        if (ids) {
            user_select.style.display = "flex"; // Show modal
            x.style.overflow = "hidden"; //Disable scroll on body
        }
    }

    function newusermodal() {
        user_select.style.display = "none";
        user_modal.style.display = "flex"; // Show modal
        x.style.overflow = "hidden";
    }

    $(document).on('click', '#user-select-close', function () {
        user_select.style.display = "none";
        x.style.overflow = "auto";
    });

    $(document).on('click', '#ordermodal', function () {
        document.getElementById('pending-orders-modal').style.display = "flex";
        x.style.overflow = "hidden";
    });

    function editModalClosefun() {
        document.getElementById("counter").value = 0;
        edit_modal.style.display = "none";
        x.style.overflow = "auto";
    }

    function discountModalClosefun() {
        document.getElementById("finalValue").value = 0;
        discount_modal.style.display = "none";
        x.style.overflow = "auto";
    }

    // Close modal when click away from modal
    window.onclick = function (event) {
        if (event.target == user_select) {
            user_select.style.display = "none"; // Hide modal
            x.style.overflow = "auto"; // Active scroll on body
        }
    }

    function changeQuantity(id) {
        document.getElementById("results").textContent = id;
        edit_modal.style.display = "flex"; // Show modal
        x.style.overflow = "hidden"; //Disable scroll on body
    }

    function openDiscountPopup(id) {
        var ids = document.getElementById('pos_product_id');
        if (id) {
          document.getElementById("initkey").textContent = id;
          discount_modal.style.display = "flex"; // Show modal
          x.style.overflow = "hidden"; //Disable scroll on body
        }else if (ids) {
          document.getElementById("initkey").textContent = '';
          discount_modal.style.display = "flex"; // Show modal
          x.style.overflow = "hidden"; //Disable scroll on body
        }else {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text("Vous devez fournir des produits avant de procéder.");
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 5000);
        }
    }

    function save_form() {
        var ids = document.getElementById('pos_product_id');
        var totalDiscount = document.getElementById('rabais').textContent;
        var total = document.getElementById('Total').textContent;
        var customer = document.getElementById('pos_customer').textContent;
        if (ids) {
            if (customer != "N/A") {
                modal.style.display = "flex"; // Show modal
                x.style.overflow = "hidden"; //Disable scroll on body
                document.getElementById('total_value').textContent = total;
                document.getElementById('discount_value').textContent = totalDiscount;
            }else {
                user_select.style.display = "flex"; // Show modal
                user_modal.style.display = "none";
                x.style.overflow = "hidden"; //Disable scroll on body
                save_pos_condition();
                document.getElementById('total_value').textContent = total;
                document.getElementById('discount_value').textContent = totalDiscount;
            }
        }else {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text("Vous devez fournir des produits avant de procéder.");
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 5000);
        }
    }

    function makeFullPayment() {
        document.getElementById('posForm').submit();
    }

    function save_pos_condition() {
        $.ajax({
            type: "get",
            url: "{{ route('clients.index') }}",
            success: function(data) {
                var customers = data.customers;
                var notDetails = data.nothing;
                var notDetailToNew = data.newuser;
                var customer_name = document.getElementById('customer_name');
                if (customers.length > 0) {
                    $(".selectCustomer").html(customers);
                    $(".vertical-menu").html(customers);
                }else {;
                  $(".selectCustomer").html(notDetailToNew);
                  $(".vertical-menu").html(notDetails);
                  // $(".selectCustomer").html(notDetails);
                }
            },
        });
        $(document).on("click", "#getCustomerSelect", function () {
            var customer_name = $(this).find("#customer_name").text();
            document.getElementById("pos_customer").innerHTML = customer_name;

            user_modal.style.display = "none";
            user_select.style.display = "none";
            x.style.overflow = "auto";
            modal.style.display = "flex"; // Show modal
            document.getElementById("pos_customer_name").value = customer_name;
        });
    }

    function waiting_pos_condition() {
        $.ajax({
            type: "get",
            url: "{{ route('clients.index') }}",
            success: function(data) {
                var customers = data.customers;
                var notDetails = data.nothing;
                var notDetailToNew = data.newuser;
                var customer_name = document.getElementById('customer_name');
                if (customers.length > 0) {
                    $(".selectCustomer").html(customers);
                    $(".vertical-menu").html(customers);
                }else {;
                  $(".selectCustomer").html(notDetailToNew);
                  $(".vertical-menu").html(notDetails);
                  // $(".selectCustomer").html(notDetails);
                }
            },
        });
        $(document).on("click", "#getCustomerSelect", function () {
            var customer_name = $(this).find("#customer_name").text();
            document.getElementById("pos_customer").innerHTML = customer_name;

            user_modal.style.display = "none";
            user_select.style.display = "none";
            x.style.overflow = "auto";
            waitingfunction();
        });
    }

    function waitingfunction() {
        var customer_name = document.getElementById('pos_customer').textContent;
        var subtotal = document.getElementById('subTotal').textContent;
        var rabais = document.getElementById('rabais').textContent;
        var total = document.getElementById('Total').textContent;
        var idAll = document.querySelectorAll('#pos_product_id');
        var nameAll = document.querySelectorAll('#pos_product_name');
        var priceAll = document.querySelectorAll('#prices');
        var quantityAll = document.querySelectorAll('#quantitie');
        var posSubTotalAll = document.querySelectorAll('#posSubTotals');
        var productId = [];
        var productName = [];
        var price = [];
        var quantity = [];
        var posSubTotal = [];
        if (idAll.length > 0) {
            for (let i = 0; i < idAll.length; i++) {
                productId.push(idAll[i].textContent);
            }
            for (let i = 0; i < nameAll.length; i++) {
                productName.push(nameAll[i].textContent);
            }
            for (let i = 0; i < priceAll.length; i++) {
                price.push(priceAll[i].textContent);
            }
            for (let i = 0; i < quantityAll.length; i++) {
                quantity.push(quantityAll[i].textContent);
            }
            for (let i = 0; i < posSubTotalAll.length; i++) {
                posSubTotal.push(posSubTotalAll[i].textContent);
            }
      }
      $.ajax({
          type: "get",
          url: "{{ route('wait-pos.waiting') }}",
          data: {'product_id': productId, 'product_name': productName, 'price': price, 'quantity': quantity, 'discount': rabais, 'pos_subtotal': posSubTotal,'subtotal': subtotal, 'total': total, 'customer': customer_name},
          success:function (response) {
            if (response.action == 'is_in_order') {
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'red');
                $('#notifDiv').text(response.message);
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 6000);
            }else {
                window.location.reload();
            }
          }
      });
    }

    function waiting_pos() {
        var ids = document.getElementById('pos_product_id');
        var customer = document.getElementById('pos_customer').textContent;
        if (ids) {
            if (customer != "N/A") {
              waitingfunction();
            }else {
                user_select.style.display = "flex"; // Show modal
                user_modal.style.display = "none";
                x.style.overflow = "hidden"; //Disable scroll on body
                waiting_pos_condition();
            }

        }else {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text("Vous devez fournir des produits avant de procéder.");
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 5000);
        }
    }

    function voidOngoingOrder() {
      var orderId = document.getElementById('orders_id').textContent;
        if ( orderId != '') {
            $.ajax({
                type: 'get',
                url: "{{ route('cancel-order.pending') }}",
                data: {"orders_id": orderId},
                success: function (response) {
                    window.location.reload();
                },
            });
        }else {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text("Impossible d'annuler une commande impayée.");
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 5000);
        }
    }

    function proceedOrderCustomer(query = '') {
        $.ajax({
            type: "get",
            url: "{{ route('customer.proceed')}}",
            data: {"orders_id": query},
            success: function (response) {
                document.getElementById('pos_customer').innerText = response;
            }
        });
    }

    function openCustomerHistory(id) {
      $.ajax({
          type: 'get',
          url: "{{ route('customer.account')}}",
          data: {'customer_id': id},
          success: function (response) {
             $("#pos-customer-select").html(response);
             user_modal.style.display = 'flex';
             user_select.style.display = "none";
             x.style.overflow = "hidden";
             $('#customer_account').show();
             $('#new_customer').hide();
          }
      });
    }

    $(document).ready(function () {

        fetch_product_data();

        function fetch_product_data(query = '') {

            $.ajax({
                type : 'get',
                url : "{{ route('pos.search')}}",
                data:{'pos_search':query},
                success:function(data){
                    $("#pos_products").html(data);
                }
            });
        }

        fetch_pending_data();

        function fetch_pending_data(query = '') {
            $.ajax({
                type: 'get',
                url: "{{ route('pending.search') }}",
                data: {'pending_search': query},
                success: function (data) {
                    $('#pending_products').html(data);
                }
            });
        }

        fetch_partial_pending_data();

        function fetch_partial_pending_data(query = '') {
            $.ajax({
                type: 'get',
                url: "{{ route('pending.partial') }}",
                data: {'partial_pending_search': query},
                success: function (data) {
                    $('#partial_pending_products').html(data);
                }
            });
        }

        $('#pos_search').on('keyup',function(e){
            var $value= e.target.value;
            fetch_product_data($value);
        });

        $(document).on('click','#usermodal',function(){
            $.ajax({
                type: "get",
                url: "{{ route('clients.index') }}",
                success: function(data) {
                    var customers = data.customers;
                    var notDetails = data.nothing;
                    var customer_name = document.getElementById('customer_name');
                    if (customers.length > 0) {
                        $(".vertical-menu").html(customers);
                    }else {;
                        $(".vertical-menu").html(notDetails);
                    }
                },
            });
        });

        $(document).on('click','#selectuser',function(){
            $.ajax({
                type: "get",
                url: "{{ route('clients.index') }}",
                success: function(data) {
                    var customers = data.customers;
                    var notDetails = data.nothing;
                    var notDetailToNew = data.newuser;
                    var customer_name = document.getElementById('customer_name');
                    if (customers.length > 0) {
                        $(".selectCustomer").html(customers);
                        $(".vertical-menu").html(customers);
                    }else {;
                        $(".selectCustomer").html(notDetailToNew);
                        $(".vertical-menu").html(notDetails);
                    }
                },
            });
        });

        $(document).on("click", "#getCustomerSelect", function () {
            var customer_name = $(this).find("#customer_name").text();
            document.getElementById("pos_customer").innerHTML = customer_name;

            user_modal.style.display = "none";
            user_select.style.display = "none";
            x.style.overflow = "auto";
        });

        $("#createPosUserForm").on("submit", function (e) {
            e.preventDefault();
            var name = $("input[name*='name']").val();
            var email = $("input[name*='email']").val();
            var first_name = $("input[name*='first_name']").val();
            var phone = $("input[name*='phone']").val();
            var birth_date = $("input[name*='birth_date']").val();
            var limit_credit = $("input[name*='limit_credit']").val();
            var gender = $("[id*='gender']").val();

            $.ajax({
                type: "get",
                url: "{{ route('customers.pos') }}",
                data:{"name": name,"email": email,"gender": gender,"first_name": first_name,"phone": phone,"birth_date": birth_date, "limit_credit": limit_credit},
                success:function(response) {
                    var customerDetails = response.customer;
                    var customer_name = customerDetails.name;

                    document.getElementById("pos_customer").innerHTML = customer_name;

                    user_modal.style.display = "none";
                    x.style.overflow = "auto";

                    $("#pos-customers").find('form').trigger('reset');

                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'green');
                    $('#notifDiv').text("Client enregistré et selectionné avec succès !");
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 5000);
                },
            });
        });
    });

</script>
@endpush
