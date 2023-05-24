@extends( 'layouts.base' )
@section( 'content' )
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Sold Stock' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Provides an overview over the sold stock during a specific period.' ) ?? __( 'No description' ) }}</p>
            </div>
        </div>
        <div id="report-section" class="px-4">
            <div class="flex flex-wrap -mx-2">
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
                <div class="px-2">
                    <div class="ns-button">
                        <button id="loadStockReport" class="rounded flex justify-between shadow py-1 items-center text-primary px-2 bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            <span class="pl-2">{{ __( 'Load' ) }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex -mx-2 pt-2">
                <div class="px-2">
                    <div class="ns-button">
                        <button onclick="window.print();" class="rounded flex justify-between border-box-background text-primary shadow py-1 items-center bg-white px-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                            </svg>
                            <span class="pl-2">{{ __( 'Print' ) }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="report-printable" class="anim-duration-500 fade-in-entrance">
                <div class="flex w-full">
                    <div class="my-4 flex justify-between w-full">
                        <div class="text-primary">
                            <ul class="flex flex-col">
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Date : %s' ), now() ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Document : %s' ), __('Sold Stock Report') ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'By : %s' ), Auth::user()->name ) }}</li>
                            </ul>
                        </div>
                        <div>
                            <img class="w-32" src="{{ asset( 'svg/fs.logo.svg' ) }}" alt="fusiontechci">
                        </div>
                    </div>
                </div>
                <div class="shadow rounded my-4">
                    <div class="ns-box">
                        <div class="border-b bg-white p-2 relative overflow-x-auto">
                            <table class="table w-full border border-gray-500">
                                <thead class="bg-gray-300">
                                    <tr>
                                        <th class="border border-gray-500 p-2 text-left">{{ __( 'Product' ) }}</th>
                                        <th width="150" class="text-right border border-gray-500 p-2">{{ __( 'Quantity' ) }}</th>
                                        <th width="150" class="text-right border border-gray-500 p-2">{{ __( 'Total' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody class="" id="stockbodydata">
                                    <!-- <tr>
                                        <td class="p-2 border border-gray-500">@{{ product.name }}</td>
                                        <td class="p-2 border border-gray-500 text-right">@{{ product.quantity }}</td>
                                        <td class="p-2 border border-gray-500 text-right">@{{ product.total_price | currency }}</td>
                                    </tr> -->
                                </tbody>
                                <tfoot class="font-semibold">
                                    <tr>
                                        <td class="p-2 border border-gray-500"></td>
                                        <td class="p-2 border border-gray-500 text-right" id="quantity_total">@currency(00)</td>
                                        <td class="p-2 border border-gray-500 text-right" id="sales_total">@currency(00)</td>
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
        $('#loadStockReport').on('click', function(e) {
            e.preventDefault();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('report.sold-stock') }}",
                data: {"startDate": startDate, "endDate": endDate},
                success: function(response) {
                    var stockDetail = response.stockReportDetail;
                    var result = response.stockReportTotal;

                    $("#stockbodydata").html(stockDetail);

                    for (let i = 0; i < result.length; i++) {
                        var quantity_total = result[i].quantity;
                        var total = result[i].pos_total;

                        $('#quantity_total').html(quantity_total);
                        $('#sales_total').html(current.format(total));
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
