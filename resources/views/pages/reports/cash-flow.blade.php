@extends('layouts.base')
@section('content')
<div class="flex-auto flex flex-col bg-gray-200 rounded-md">
    <div class="flex-auto flex flex-col" id="dashboard-content">
        <div class="px-4 pt-4">
            <div class="page-inner-header mb-2">
                <h3 class="text-3xl text-primary font-bold">{!! __( 'Cash Flow Report' ) ?? __( 'Unamed Page' ) !!}</h3>
                <p class="text-secondary">{{ __( 'Provides an overview on the activity for a specific period.' ) ?? __( 'No description' ) }}</p>
            </div>
        </div>
        <div id="report-section" class="px-4">
            <div class="flex flex-wrap -mx-2 my-2">
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
                    <button id="loadCashFlowReport" class="rounded flex justify-between bg-input-button shadow py-1 items-center text-primary px-2 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span class="pl-2">{{ __( 'Load' ) }}</span>
                    </button>
                </div>
                <div class="px-2">
                    <button onclick="window.print();" class="rounded flex justify-between bg-input-button shadow py-1 items-center text-primary px-2 bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        <span class="pl-2">{{ __( 'Print' ) }}</span>
                    </button>
                </div>
            </div>
            <div id="cash-flow-report" class="anim-duration-500 fade-in-entrance">
                <div class="flex w-full">
                    <div class="my-4 flex justify-between w-full">
                        <div class="text-primary">
                            <ul class="flex flex-col">
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'Date : %s' ), now() ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ __( 'Document : Sale By Payment' ) }}</li>
                                <li class="pb-1 border-b border-dashed border-gray-500">{{ sprintf( __( 'By : %s' ), Auth::user()->name ) }}</li>
                            </ul>
                        </div>
                        <div>
                            <img class="w-32" src="{{ asset( 'svg/fusion_logo.svg' ) }}" alt="fusiontechci">
                        </div>
                    </div>
                </div>
                <div class="shadow rounded my-4">
                    <div class="ns-box">
                        <div class="border-b border-gray-500 relative overflow-x-auto">
                            <table class="table w-full">
                                <thead class="">
                                    <tr>
                                        <th class="border border-gray-500 p-2 text-left bg-gray-300">{{ __( 'Account' ) }}</th>
                                        <th width="150" class="border border-red-400 bg-red-200 p-2 text-right">{{ __( 'Debit' ) }}</th>
                                        <th width="150" class="text-right border-green-600 bg-green-200 border p-2">{{ __( 'Credit' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody class="" id="cashflowbody">
                                </tbody>
                                <tfoot class=" font-semibold">
                                    <tr>
                                        <td class="p-2 border border-gray-500">{{ __( 'Sub Total' ) }}</td>
                                        <td class="p-2 border border-red-400 bg-red-200 text-right" id="total_debit">@currency(0)</td>
                                        <td class="p-2 border text-right border-green-600 bg-green-200" id="total_credit">@currency(0)</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 border border-gray-500">{{ __( 'Balance' ) }}</td>
                                        <td colspan="2" class="p-2 border text-right border-cyan-700 bg-cyan-400" id="balance">@currency(0)</td>
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

<script>
    // format number to XOF format
    let current = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'XOF',
    });

    $(function () {
        $("#loadCashFlowReport").on("click", function (e) {
            e.preventDefault();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            $.ajax({
                type: 'GET',
                url: "{{ route('report.cash-flow') }}",
                data: {"startDate": startDate, "endDate": endDate},
                success: function(response) {
                    var cashflow = response.cashflow;

                    $("#cashflowbody").html(cashflow);

                    var debitcompte = document.querySelectorAll("#debitCompte");
                    var creditcompte = document.querySelectorAll("#creditCompte");

                    var total_debit = 0;
                    for (var i = 0; i < debitcompte.length; i++) {
                        total_debit += parseFloat(debitcompte[i].textContent);
                    }

                    var total_credit = 0;
                    for (var i = 0; i < creditcompte.length; i++) {
                        total_credit += parseFloat(creditcompte[i].textContent);
                    }

                    var balance = total_debit + total_credit;
                    $('#total_debit').html(current.format(total_debit));
                    $('#total_credit').html(current.format(total_credit));
                    $('#balance').html(current.format(balance));
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
