@extends('layouts.base')
@section('content')
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Annulation de commandes' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Donne une date de la commande et le nom de la caissière ou le caissier' ) ?? __( 'No description' ) }}</p>
            </div>
        </div>
        <div class="px-4">
            <div class="flex flex-wrap -mx-2 my-2 pb-2">
                <div class="px-2 mb-2">
                    <select class="w-full rounded py-1 px-8 border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500 shadow" name="order_author_id" id="order_author_id">
                        <option value="">Choisis une option</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="px-2 mb-2">
                    <select class="w-full rounded py-1 px-8 border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500 shadow" name="order_date" id="order_date">
                        <option value="">Choisis la date de la commande</option>
                        @foreach ($orders as $order)
                            <option value="{{ $order->created_at }}">
                              {{ $order->customer->name }} ( {{ $order->created_at }} ) -
                              @if($order->payment_status == 'paid')
                                <b>Payé</b>
                              @else
                                <b>Partiellement payé</b>
                              @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="px-2">
                    <button id="loadOrders" class="rounded flex justify-between bg-input-button shadow py-1 items-center text-primary px-2 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span class="pl-2">{{ __( 'Load' ) }}</span>
                    </button>
                </div>
            </div>
            <div id="void-order" class="anim-duration-500 fade-in-entrance">
                <div class="flex w-full">
                    <div class="my-4 flex justify-between w-full">
                        <div>
                            <ul class="flex flex-col">
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Date : %s' ), now()) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'By : %s' ), Auth::user()->name ) }}</li>
                            </ul>
                        </div>
                        <div>
                            <img class="w-32" src="{{ asset( 'svg/fusion_logo.svg' ) }}" alt="fusiontechci">
                        </div>
                    </div>
                </div>
                <div class="shadow rounded my-4">
                    <div class="border-b border-gray-500 relative overflow-x-auto">
                        <table class="table w-full">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="border p-2 border-gray-500 text-left">{{ __( 'Orders' ) }}</th>
                                    <th class="border p-2 border-gray-500 text-left">{{ __( 'Date' ) }}</th>
                                    <th width="100" class="border p-2 border-gray-500">{{ __( 'Author' ) }}</th>
                                    <th width="150" class="border p-2 border-gray-500">{{ __( 'Total' ) }}</th>
                                    <th width="150" class="border p-2 border-gray-500">{{ __( 'Action' ) }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-primary" id="orderbodydata">
                                 <tr>
                                    <td colspan="5" class="px-2 py-4 border border-gray-500 text-center">{{ __('No selection has been made.') }}</td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // format number to XOF format
    let current = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'XOF',
    });

    $( function () {
        $('#loadOrders').on('click', function(e) {
            e.preventDefault();
            var author_id = $('#order_author_id').val();
            var order_date = $('#order_date').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('void.orders') }}",
                data: {"author_id": author_id, "order_date": order_date},
                success: function(response) {
                  $('#orderbodydata').html(response);
                },
                error: function(response) {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text("Aucune date ou aucun nom n'a été selectionné.");
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 5000);
                },
            });
        });
    });

    function voidOrder(id) {
        $.ajax({
            type: 'get',
            url: "{{ route('order.void') }}",
            data: {"order_id": id},
            success: function (response) {
              window.location.reload();
            }
        });
    }
</script>

@endpush
