<div class="p-4">
    <div class="flex -mx-4 flex-wrap">
        <div class="px-4 mb-6 md:w-1/3">
            <div class="flex flex-auto flex-col rounded-lg shadow-lg bg-gradient-to-br from-purple-400 to-purple-600 text-white px-3 py-5">
                <div class="flex flex-row md:flex-col flex-auto">
                    <div class="w-1/2 md:w-full flex md:flex-col md:items-start justify-center">
                        <h6 class="font-bold hidden text-right md:inline-block">{{ __( 'Total Sales' ) }}</h6>
                        <h3 class="text-2xl font-bold uppercase">
                            @forelse($current_day as $detals)
                                <span id="total_sales">@currency($detals->total_sales)</span>
                            @empty
                                <span id="total_sales">@currency(00)</span>
                            @endforelse
                        </h3>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col px-2 justify-end items-end">
                        <h6 class="font-bold inline-block text-right md:hidden">{{ __( 'Total Sales' ) }}</h6>
                        <h4 class="text-xs text-right">
                            @forelse($current_day as $detals)
                                +<span id="total_sales">@currency($detals->total_sales)</span>
                            @empty
                                +<span id="total_sales">@currency(00)</span>
                            @endforelse
                            {{ __( 'Today' ) }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 mb-6 md:w-1/3">
            <div class="flex flex-auto flex-col rounded-lg shadow-lg bg-gradient-to-br from-red-400 to-red-600 text-white px-3 py-5">
                <div class="flex flex-row md:flex-col flex-auto">
                    <div class="w-1/2 md:w-full flex md:flex-col md:items-start justify-center">
                        <h6 class="font-bold hidden text-right md:inline-block">{{ __( 'Total des dépenses' ) }}</h6>
                        <h3 class="text-2xl font-bold uppercase">
                            @forelse($expenses as $expense)
                                <span id="">@currency($expense->total)</span>
                            @empty
                                <span id="">@currency(00)</span>
                            @endforelse
                        </h3>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col px-2 justify-end items-end">
                        <h6 class="font-bold inline-block text-right md:hidden">{{ __( 'Total des dépenses' ) }}</h6>
                        <h4 class="text-xs text-right">
                            @forelse($expense_sammary as $details)
                                +<span id="">@currency($details->total)</span>
                            @empty
                                +<span id="">@currency(00)</span>
                            @endforelse
                            {{ __( 'Today' ) }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 mb-6 md:w-1/3">
            <div class="flex flex-auto flex-col rounded-lg shadow-lg bg-gradient-to-br from-blue-400 to-blue-600 text-white px-3 py-5">
                <div class="flex flex-row md:flex-col flex-auto">
                    <div class="w-1/2 md:w-full flex md:flex-col md:items-start justify-center">
                        <h6 class="font-bold hidden text-right md:inline-block">{{ __( 'Clients Registered' ) }}</h6>
                        <h3 class="text-2xl font-bold uppercase">
                            0
                        </h3>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col px-2 justify-end items-end">
                        <h6 class="font-bold inline-block text-right md:hidden">{{ __( 'Clients Registered' ) }}</h6>
                        <h4 class="text-xs text-right">+F FCA 00 {{ __( 'Today' ) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="py-4">
        <ul v-if="report.today_orders && report.today_orders.length > 0" class="bg-white shadow-lg rounded overflow-hidden">
            <li v-for="order of report.today_orders" :key="order.id" class="p-2 border-b-2 border-blue-400">
                <h3 class="font-semibold text-lg flex justify-between">
                    <span>{{ __( 'Total' ) }} : {{ __('order.total') }}</span>
                    <span>{{ __('order.code') }}</span>
                </h3>
                <ul class="pt-2 flex -mx-1 text-sm text-gray-700">
                    <li class="px-1">{{ __( 'Discount' ) }} : {{ __('order.discount') }}</li>
                    <li class="px-1">{{ __( 'Status' ) }} : {{ __( 'order.payment_status' ) }}</li>
                </ul>
            </li>
        </ul>
        <div v-if="report.today_orders && report.today_orders.length === 0" class="flex items-center justify-center">
            <i class="las la-frown"></i>
        </div>
    </div> -->
</div>
