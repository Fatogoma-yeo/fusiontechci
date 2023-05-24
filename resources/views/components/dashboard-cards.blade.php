
<div class="-m-4 flex flex-wrap" id="dashboard-cards">
    <div class="p-4 md:w-1/2 lg:w-1/4">
        <div class="flex flex-auto flex-col rounded-lg shadow-lg bg-gradient-to-br from-cyan-500 to-blue-500 text-white px-3 py-5">
            <div class="flex flex-row md:flex-col flex-auto">
                <div class="w-1/2 md:w-full flex md:flex-col md:items-start justify-center">
                    <h6 class="font-bold hidden text-right md:inline-block">{{ __( 'Total Sales' ) }}</h6>
                    <h3 class="text-2xl font-bold uppercase">
                        f cfa 0.0
                    </h3>
                </div>
                <div class="w-1/2 md:w-full flex flex-col px-2 justify-end items-end">
                    <h6 class="font-bold inline-block text-right md:hidden">{{ __( 'Total Sales' ) }}</h6>
                    <h4 class="text-xs text-right">+{{ __( 'report.day_paid_orders' ) }} {{ __( 'Today' ) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 md:w-1/2 lg:w-1/4">
        <div class="flex flex-auto flex-col rounded-lg shadow-lg bg-gradient-to-br from-green-400 to-green-600 text-white px-3 py-5">
            <div class="flex flex-row md:flex-col flex-auto">
                <div class="w-1/2 md:w-full flex md:flex-col md:items-start justify-center">
                    <h6 class="font-bold hidden text-right md:inline-block">{{ __( 'Incomplete Orders' ) }}</h6>
                    <h3 class="text-2xl font-bold uppercase">
                        f cfa 0.0
                    </h3>
                </div>
                <div class="w-1/2 md:w-full flex flex-col px-2 justify-end items-end">
                    <h6 class="font-bold inline-block text-right md:hidden">{{ __( 'Incomplete Orders' ) }}</h6>
                    <h4 class="text-xs text-right">+{{ __( 'unpaid + partially_paid' ) }} {{ __( 'Today' ) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 md:w-1/2 lg:w-1/4">
        <div class="flex flex-auto flex-col rounded-lg shadow-lg bg-gradient-to-br from-red-300 via-red-400 to-red-500 text-white px-3 py-5">
            <div class="flex flex-row md:flex-col flex-auto">
                <div class="w-1/2 md:w-full flex md:flex-col md:items-start justify-center">
                    <h6 class="font-bold hidden text-right md:inline-block">{{ __( 'Wasted Goods' ) }}</h6>
                    <h3 class="text-2xl font-bold uppercase">
                        f cfa 0.0
                    </h3>
                </div>
                <div class="w-1/2 md:w-full flex flex-col px-2 justify-end items-end">
                    <h6 class="font-bold text-right md:hidden">{{ __( 'Wasted Goods' ) }}</h6>
                    <h4 class="text-xs text-right">+{{ __( 'report.day_wasted_goods' ) }} {{ __( 'Today' ) }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 md:w-1/2 lg:w-1/4">
        <div class="flex flex-auto flex-col rounded-lg shadow-lg bg-gradient-to-br from-indigo-400 to-indigo-600 text-white px-3 py-5">
            <div class="flex flex-row md:flex-col flex-auto">
                <div class="w-1/2 md:w-full flex md:flex-col md:items-start justify-center">
                    <h6 class="font-bold hidden text-right md:inline-block">{{ __( 'Expenses' ) }}</h6>
                    <h3 class="text-2xl font-bold uppercase">
                        f cfa 0.0
                    </h3>
                </div>
                <div class="w-1/2 md:w-full flex flex-col px-2 justify-end items-end">
                    <h6 class="font-bold inline-block text-right md:hidden">{{ __( 'Expenses' ) }}</h6>
                    <h4 class="text-xs text-right">+{{ __( 'report.day_expenses' ) }} {{ __( 'Today' ) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>