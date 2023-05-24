@extends('layouts.default')
@section('content')
<div x-data ="{ openTab: 2, activeClasses:'shadow bg-white text-gray-800', inactiveClasses:'focus:bg-gray-100 text-white' }" class="h-full flex-auto flex flex-col" id="pos-container" x-cloak>
    <div class="flex overflow-hidden flex-shrink-0 px-2 pt-2">
        <div class="-mx-2 flex overflow-x-auto pb-1">
            <div class="header-buttons flex px-2 flex-shrink-0 flex-col">  
                <div class="px-2 flex flex-row gap-2 overflow-x-auto">
                    <a href="{{route('dashboard')}}" class="bg-green-0 inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-sm text-gray-900 hover:bg-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-6 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        {{ __('Tableau') }}
                    </a>
                    <a href="" class="bg-gray-100 inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-sm text-gray-900 hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Clients') }}
                    </a>
                    <a href="" class="bg-gray-100 inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-sm text-gray-900 hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                        </svg>
                        {{ __('Réinitialiser') }}
                    </a>
                </div>
                <ul class="sm:hidden flex flex-row pt-2 px-2">
                    <li  class="" onclick="swichToCart()">
                        <button class="inline-block cursor-pointer text-white bg-gray-500 hover:text-gray-300 hover:border-gray-300 rounded-t-lg py-2 px-2 text-md font-medium text-center border-transparent border-b-2" >
                            <span> Panier </span>
                            <span class="inline-flex items-center justify-center text-sm rounded-full h-6 w-6 bg-green-500 text-white ml-1"> 0 </span>
                        </button>
                    </li>
                    <li  class="" onclick="swichToGrid()">
                        <button class="inline-block cursor-pointer text-white bg-gray-500 hover:text-gray-300 hover:border-gray-300 rounded-t-lg py-2 px-2 text-md font-medium text-center border-transparent border-b-2">Produits</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="flex-auto overflow-hidden flex px-2">
        <div class="flex flex-auto overflow-hidden">
            <div class="flex md:w-1/2 overflow-hidden p-2" id="cart"> 
                <div id="pos-cart" class="flex-auto flex flex-col bg-gray-100 hidden md:inline-block">
                    <div class="flex flex-col h-full overflow-hidden flex-auto">
                        <div class="w-full font-semibold flex">
                            <div class="w-full md:w-4/6 p-2 border border-l-0 border-t-0">{{ __( 'Product' ) }}</div>
                            <div class="md:flex md:w-1/6 p-2 border-b border-t-0">{{ __( 'Quantity' ) }}</div>
                            <div class="md:flex md:w-1/6 p-2 border border-r-0 border-t-0">{{ __( 'Total' ) }}</div>
                        </div>
                        <div class="flex flex-auto flex-col overflow-auto product_list h-96">
                            <!-- Loop Procuts On Cart -->
                            @include('pages.orders.products')
                            <!-- End Loop -->
                        </div>
                        <div class="">
                            <table class="w-full border text-sm font-light">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="whitespace-nowrap border-r px-4 py-2">
                                            Client : <span class="font-bold"></span>
                                        </td>
                                        <td class="whitespace-nowrap border-r px-4 py-2">
                                            Sous Total
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2"><span class="flex justify-end uppercase font-bold gap-2"><span id="subTotal">0</span> f fca</span></td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="whitespace-nowrap border-r px-4 py-2">
                                            
                                        </td>
                                        <td class="whitespace-nowrap border-r px-4 py-2">
                                            Rabais
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2"><span class="flex justify-end uppercase gap-2"><span id="rabais">0</span> f fca</span></td>
                                    </tr>
                                    <tr class="border-b bg-green-600 text-white">
                                        <td class="whitespace-nowrap border-r px-4 py-2">
                                        </td>
                                        <td class="whitespace-nowrap border-r px-4 py-2">
                                            Total
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2"><span class="flex justify-end uppercase font-bold gap-2"><span id="Total">0</span> f fca</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="w-full pt-1 flex flex-row">
                                <a onclick="save_form()" id="save_posForm" class="bg-green-600 w-full inline-flex items-center justify-center py-2 border font-bold text-xl md:text-lg text-white hover:bg-green-700 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex items-center">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                    <span class="text-md lg:text-2xl">{{ __( 'Pay' ) }}</span>
                                </a>
                                <a onclick="waiting_pos()" class="bg-blue-600 w-full inline-flex items-center justify-center py-2 border font-bold text-xl md:text-lg text-white hover:bg-blue-800 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                    </svg>
                                    {{ __('Hold') }}
                                </a>
                                <a href="" class="bg-white w-full inline-flex items-center justify-center py-2 border font-bold text-xl md:text-lg text-gray-900 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185zM9.75 9h.008v.008H9.75V9zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm4.125 4.5h.008v.008h-.008V13.5zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    {{ __('Discount') }}
                                </a>
                                <a href="" class="bg-red-600 w-full inline-flex items-center justify-center py-2 border font-bold text-xl md:text-lg text-white hover:bg-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1 inline-flex">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                                    </svg>
                                    {{ __('Void') }}
                                </a>
                            </div>
                            @include('pages.orders.orders_form')
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 md:flex-col md:w-1/2 flex overflow-hidden" id="grid">
                <div id="pos-grid" class="flex-auto flex flex-col bg-gray-100 inline-block md:hidden">
                    <div id="grid-container" class="rounded shadow  overflow-hidden flex-auto flex flex-col">
                        <div class="px-2 py-2 sm:px-2">
                            <div class="border border-gray-300 flex justify-between rounded-lg">
                                <div class="border-r px-2 flex items-center border-gray-300">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" class="bg-gray-50 border-transparent rounded-r-md focus:border-transparent focus:ring-0 text-gray-900 text-sm block w-full"  placeholder="{{__('Search for products.')}}">
                            </div>
                        </div>
                        <div id="grid-items" class="h-full flex-col flex">
                            <div class="lg:grid-container sm:grid-cont-3 md:grid-cont-4 p-1 overflow-y-auto w-full h-96">
                                @foreach($products as $product)
                                    <div class="relative border border-r-0 border-t-0" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-product')" onclick="getproductfunc(this)">
                                        <a href="#">
                                            <input type="text" class="hidden" name="product_id" id="product_id" value="{{ $product->id }}"  >
                                            @if($product->media)
                                                <img src="{{ asset($product->media) }}" class="h-full w-full" alt="Image Produits" />
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            @endif

                                            <div class="absolute bottom-0 flex flex-col bg-gray-600 opacity-75 p-2 shadow-md w-full h-16">
                                                <span class="flex justify-center">
                                                    <h2 class="text-lg  text-white font-semibold">{{$product->name}}</h2>
                                                </span>
                                                <span class="flex justify-center">
                                                    <h3 class="text-md text-white font-semibold">
                                                        @foreach($procurementDetail as $value)
                                                            @if ($product->id == $value->product_id)
                                                                {{ $value->net_purchase_price }} F CFA
                                                            @endif
                                                        @endforeach
                                                    </h3>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
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
    // const modalBtn = document.getElementById('modal-button') // launch modal button
    const modalClose = document.getElementById('modal-close') // close modal button
    // var total = document.getElementById('Total').innerText;

    // Open modal
    // modalBtn.onclick = function () {
    //         modal.style.display = "flex"; // Show modal
    //         x.style.overflow = "hidden"; //Disable scroll on body
    // }

    // Select and trigger all close buttons
    function modalClosefun() {
        modal.style.display = "none";
        x.style.overflow = "auto";
    }

    function editModalClosefun() {
        document.getElementById("counter").value = 0;
        edit_modal.style.display = "none";
        x.style.overflow = "auto";
    }
    // Close modal when click away from modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none"; // Hide modal
            x.style.overflow = "auto"; // Active scroll on body
        }
    }

    var cart = document.getElementById('pos-cart');
    var xcart = document.getElementById('cart');
    var grid = document.getElementById('pos-grid');

    function swichToCart() {
        grid.classList.remove('inline-block');
        grid.classList.add('hidden');
        cart.classList.remove('hidden');
        cart.classList.add('inline-block');
        xcart.classList.remove('md:w-1/2');
        xcart.classList.add('w-full');
    }

    function swichToGrid() {
        cart.classList.remove('inline-block');
        cart.classList.add('hidden');
        grid.classList.remove('hidden');
        grid.classList.add('inline-block');
        xcart.classList.remove('w-full');
        xcart.classList.add('md:1/2');
    }

    function changeQuantity() {
        edit_modal.style.display = "flex"; // Show modal
        x.style.overflow = "hidden"; //Disable scroll on body
    }

    function save_form() {
        var ids = document.getElementById('pos_product_id').textContent;
        var total = document.getElementById('Total').textContent;
        if (ids) {
            modal.style.display = "flex"; // Show modal
            x.style.overflow = "hidden"; //Disable scroll on body
            document.getElementById('total_value').textContent = total;
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
        // var printWindow = window.open( "{{ route('dashboard')}}" );
        // document.getElementById('invoice_content').print();
    }

    function waiting_pos() {
        var ids = document.getElementById('pos_product_id');
        if (ids) {
            document.getElementById('posForm').submit();
        }else {
            $('#notifDiv').fadeIn();
            $('#notifDiv').css('background', 'red');
            $('#notifDiv').text("Vous devez fournir des produits avant de procéder.");
            setTimeout(() => {
                $('#notifDiv').fadeOut();
            }, 5000);
        }
    }
</script>
@endpush