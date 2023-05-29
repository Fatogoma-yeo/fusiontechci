@extends( 'layouts.base' )

@section( 'content' )
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Profit Report' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Provides an overview of the provide of the products sold.' ) ?? __( 'No description' ) }}</p>
            </div>
        </div>
        <div id="report-section" class="px-4">
            <div class="flex flex-wrap -mx-2 my-4">
                <div class="px-2">
                    <x-date-time-picker>
                        <span class="text-sm w-24">
                            <input type="text" class="border border-transparent h-0 w-full text-center text-sm px-1 cursor-pointer" readonly="" name="startDate" id="startDate" value="<?php echo date('Y-m-d'); ?>" >
                        </span>
                    </x-date-time-picker>
                </div>
                <div class="px-2">
                    <x-date-time-picker>
                        <span class="text-sm w-24">
                            <input type="text" class="border border-transparent h-0 w-full text-center text-sm px-1 cursor-pointer" readonly="" name="endDate" id="endDate" value="<?php echo date('Y-m-d'); ?>" >
                        </span>
                    </x-date-time-picker>
                </div>
                <div class="px-2 pb-2">
                    <button id="loadProfitReport" class="rounded flex justify-between bg-box-background shadow py-1 items-center text-primary px-2 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span class="pl-2">{{ __( 'Load' ) }}</span>
                    </button>
                </div>
                <div class="px-2">
                    <button onclick="window.print();" class="rounded flex justify-between bg-box-background shadow py-1 items-center text-primary px-2 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        <span class="pl-2">{{ __( 'Print' ) }}</span>
                    </button>
                </div>
            </div>
            <div id="profit-report" class="anim-duration-500 fade-in-entrance">
                <div class="flex w-full">
                    <div class="my-4 flex justify-between w-full">
                        <div class="text-primary">
                            <ul class="flex flex-col">
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Date : %s' ), now() ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ __( 'Document : Profit Report' ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'By : %s' ), Auth::user()->name ) }}</li>
                            </ul>
                        </div>
                        <div>
                            <img class="w-32" src="{{ asset( 'svg/fusion_logo.svg' ) }}" alt="fusiontechci">
                        </div>
                    </div>
                </div>
                <div class="shadow rounded my-4">
                    <div class="">
                        <div class="border-b relative overflow-x-auto">
                            <table class="table border border-gray-500 w-full">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-500 p-2 text-left">{{ __( 'Product' ) }}</th>
                                        <th width="150" class="text-right border border-gray-500 p-2">{{ __( 'Quantity' ) }}</th>
                                        <th width="150" class="text-right border border-gray-500 p-2">{{ __( 'Purchase Price' ) }}</th>
                                        <th width="150" class="text-right border border-gray-500 p-2">{{ __( 'Sale Price' ) }}</th>
                                        <th width="150" class="text-right border border-gray-500 p-2">{{ __( 'Profit' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody id="profitbodydata">

                                </tbody>
                                <tfoot class="font-semibold">
                                    <tr>
                                        <td class="p-2 border border-gray-500"></td>
                                        <td class="p-2 border border-gray-500 text-right" id="quantity_total">00</td>
                                        <td class="p-2 border border-gray-500 text-right" id="total_purchase_price">@currency(00)</td>
                                        <td class="p-2 border border-gray-500 text-right" id="total_pos_price">@currency(00)</td>
                                        <td class="p-2 border border-gray-500 text-right text-yellow-600" id="total_profit">@currency(00)</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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
        $('#loadProfitReport').on('click', function(e) {
            e.preventDefault();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('report.profit') }}",
                data: {"startDate": startDate, "endDate": endDate},
                success: function(response) {
                    var profitDetail = response.profitReportDetail;
                    var profitotal = response.profit_total;
                    var result = response.profitReportTotal;
                    var profit_price = [];

                    $("#profitbodydata").html(profitDetail);

                    profitotal.forEach(element => {
                        var total_purchase_price = element.purchase_price * element.quantity;
                        var total_price = element.pos_subtotal;
                        profit_price.push(total_price - total_purchase_price);
                    });
                    for (let i = 0; i < result.length; i++) {
                        var quantity_total = result[i].quantity_total;
                        var pos_total = result[i].pos_total;
                        var purchase_price_total = result[i].purchase_price_total;
                        var total_profit = 0;
                        profit_price.forEach(profit => {
                            total_profit +=profit;
                        });

                        $('#quantity_total').html(quantity_total);
                        $('#total_purchase_price').html(current.format(purchase_price_total));
                        $('#total_pos_price').html(current.format(pos_total));
                        $('#total_profit').html(current.format(total_profit));
                    }
                },
                error: function(response) {
                    $('#notifDiv').fadeIn();
                    $('#notifDiv').css('background', 'red');
                    $('#notifDiv').text("Aucune vente n'a été effectué pendant cette periode.");
                    setTimeout(() => {
                        $('#notifDiv').fadeOut();
                    }, 5000);
                },
            });
        });
    });
</script>

@endpush
