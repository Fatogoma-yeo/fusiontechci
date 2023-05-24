<div id="dashboard-content" class="p-4">
    @include('pages.dashboard.component.dashboard-cards')
    <div class="-m-4 flex flex-wrap">
        <div class="p-4 flex md:w-full lg:w-1/2">
            @include('pages.dashboard.component.orders-chart')
        </div>
        <div class="p-4 flex md:w-full lg:w-1/2">
            @include('pages.dashboard.component.orders-summary')
        </div>
        <div class="p-4 flex md:w-full lg:w-1/2">
            @include('pages.dashboard.component.best-customers')
        </div>
    </div>
</div>