
<div id="ns-orders-summary" class="flex flex-auto bg-gray-100 flex-col shadow rounded-lg overflow-hidden">
    <div class="p-2 flex title justify-between border-b">
        <h3 class="font-semibold">{{ __( 'Recents Orders' ) }}</h3>
        <div class="">
            
        </div>
    </div>
    <div class="head flex-auto flex-col flex h-56 overflow-y-auto ns-scrollbar">
        <!-- <div class="h-full flex items-center justify-center" v-if="! hasLoaded">
            <ns-spinner size="8" border="4"></ns-spinner>
        </div> -->
        <div class="h-full flex items-center justify-center flex-col" v-if="hasLoaded && orders.length === 0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 504 512" class="h-6 w-6">
                <path d="M456 128c26.5 0 48-21 48-47 0-20-28.5-60.4-41.6-77.8-3.2-4.3-9.6-4.3-12.8 0C436.5 20.6 408 61 408 81c0 26 21.5 47 48 47zm0 32c-44.1 0-80-35.4-80-79 0-4.4.3-14.2 8.1-32.2C345 23.1 298.3 8 248 8 111 8 0 119 0 256s111 248 248 248 248-111 248-248c0-35.1-7.4-68.4-20.5-98.6-6.3 1.5-12.7 2.6-19.5 2.6zm-128-8c23.8 0 52.7 29.3 56 71.4.7 8.6-10.8 12-14.9 4.5l-9.5-17c-7.7-13.7-19.2-21.6-31.5-21.6s-23.8 7.9-31.5 21.6l-9.5 17c-4.1 7.4-15.6 4-14.9-4.5 3.1-42.1 32-71.4 55.8-71.4zm-160 0c23.8 0 52.7 29.3 56 71.4.7 8.6-10.8 12-14.9 4.5l-9.5-17c-7.7-13.7-19.2-21.6-31.5-21.6s-23.8 7.9-31.5 21.6l-9.5 17c-4.2 7.4-15.6 4-14.9-4.5 3.1-42.1 32-71.4 55.8-71.4zm80 280c-60.6 0-134.5-38.3-143.8-93.3-2-11.8 9.3-21.6 20.7-17.9C155.1 330.5 200 336 248 336s92.9-5.5 123.1-15.2c11.5-3.7 22.6 6.2 20.7 17.9-9.3 55-83.2 93.3-143.8 93.3z"/>
            </svg>
            <p class="text-sm">{{ __( 'Well.. nothing to show for the meantime.' ) }}</p>
        </div>
        <div 
            v-for="order of orders" 
            :key="order.id" 
            :class="order.payment_status === 'paid' ? 'paid-order' : 'other-order'" 
            class="border-b single-order p-2 flex justify-between">
            <div>
                <h3 class="text-lg font-semibold">{{ __( 'Order' ) }} : {{ __('order.code') }}</h3>
                <div class="flex -mx-2">
                    <div class="px-1">
                        <h4 class="text-semibold text-xs">
                            <i class="lar la-user-circle"></i>
                            <span>{{ __('order.user.username') }}</span>
                        </h4>
                    </div>
                    <div class="divide-y-4"></div>
                    <div class="px-1">
                        <h4 class="text-semibold text-xs">
                            <i class="las la-clock"></i> 
                            <span>{{ __('order.created_at') }}</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div>
                <h2 
                    :class="order.payment_status === 'paid' ? 'paid-currency' : 'unpaid-currency'" 
                    class="text-xl font-bold">{{ __('order.total currency') }}</h2>
            </div>
        </div>
    </div>
</div>