<div class="min-h-screen bg-green-0 flex flex-col overflow-y-auto px-1 text-gray-100 shadow-md" id="dropdown">
    <div>
        <div class="pt-6 pb-2 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        @can('orders_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link :href="route('orders.index')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                {{ __('POS') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        @can('clients_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(1)" onkeypress="toggleSubDir(1)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                {{ __('Customers') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist1" class="hidden bg-gray-0 border rounded-lg pb-1">
          @can('clients_access')
            <div class="pt-1 space-y-1">
                <a href="{{ route('clients.index') }}" class="text-white ml-4 mr-2">
                    {{ __('List') }}
                </a>
            </div>
          @endcan
            <div class="pt-1 pb-2 space-y-1">
                <a href="{{ route('clients.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create a customer') }}
                </a>
            </div>
        </div>

        @can('providers_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(2)" onkeypress="toggleSubDir(2)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                {{ __('Providers') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist2" class="hidden bg-gray-0 border rounded-lg pb-1">
            <div class="pt-1 space-y-1">
                <a href="{{ route('providers.index') }}" class="text-white ml-4 mr-2">
                    {{ __('List') }}
                </a>
            </div>
            <div class="pt-1 pb-2 space-y-1">
                <a href="{{ route('providers.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create A Provider') }}
                </a>
            </div>
        </div>

        @can('account_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(3)" onkeypress="toggleSubDir(3)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                {{ __('Accounting') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist3" class="hidden bg-gray-0 border rounded-lg pb-1">
          @can('expense_list')
            <div class="pt-1 space-y-1">
                <a href="{{ route('expenses.index') }}" class="text-white ml-4 mr-2">
                    {{ __('Expenses') }}
                </a>
            </div>
          @endcan
          @can('expense_create')
            <div class="pt-1 space-y-1">
                <a href="{{ route('expenses.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create Expense') }}
                </a>
            </div>
          @endcan
          @can('compte_list')
            <div class="pt-1 space-y-1">
                <a href="{{ route('expense_categories.index') }}" class="text-white ml-4 mr-2">
                    {{ __('Account') }}
                </a>
            </div>
          @endcan
          @can('compte_create')
            <div class="pt-1 space-y-1">
                <a href="{{ route('expense_categories.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create Account') }}
                </a>
            </div>
          @endcan
          @can('cash_flow_show')
            <div class="pt-1 pb-2 space-y-1">
                <a href="{{ route('expenses.history') }}" class="text-white ml-4 mr-2">
                    {{ __('Flux de trésorie') }}
                </a>
            </div>
          @endcan
        </div>

        @can('inventory_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link  class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(4)" onkeypress="toggleSubDir(4)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
                {{ __('Inventory') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist4" class="hidden bg-gray-0 border rounded-lg pb-1">
            <div class="pt-1 space-y-1">
                <a href="{{ route('inventories.index') }}" class="text-white ml-4 mr-2">
                    {{ __('Inventaire des Stocks') }}
                </a>
            </div>
            <div class="pt-1 space-y-1">
                <a href="{{ route('inventories.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Saisir de Stocks Physique') }}
                </a>
            </div>
            <div class="pt-1 space-y-1">
                <a href="{{ route('inventory.validate') }}" class="text-white ml-4 mr-2">
                    {{ __('Validation de l\'inventaire') }}
                </a>
            </div>
            <div class="pt-1 space-y-1">
                <a href="{{ route('inventory.stock-hs') }}" class="text-white ml-4 mr-2">
                    {{ __('Stocks HS') }}
                </a>
            </div>
            <div class="pt-1 space-y-1">
                <a href="{{ route('inventory.physic-stock-hs') }}" class="text-white ml-4 mr-2">
                    {{ __('Saisir de Stocks HS') }}
                </a>
            </div>
            <div class="pt-1 space-y-1">
                <a href="{{ route('inventory.stock-validate') }}" class="text-white ml-4 mr-2">
                    {{ __('Validation de Stocks') }}
                </a>
            </div>
            <div class="pt-1 pb-2 space-y-1">
                <a href="{{ route('product.stock-ajustment') }}" class="text-white ml-4 mr-2">
                    {{ __('Stock Adjustment') }}
                </a>
            </div>
        </div>

        @can('users_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link  class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(5)" onkeypress="toggleSubDir(5)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
                {{ __('Users') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist5" class="hidden bg-gray-0 border rounded-lg pb-1">
          @can('profile_access')
            <div class="pt-1 space-y-1">
                <a href="{{ route('profile.edit') }}" class="text-white ml-4 mr-2">
                    {{ __('Profile') }}
                </a>
            </div>
          @endcan
          @can('users_list')
            <div class="pt-1 space-y-1">
                <a href="{{ route('users.index') }}" class="text-white ml-4 mr-2">
                    {{ __('List') }}
                </a>
            </div>
          @endcan
          @can('users_create')
            <div class="pt-1 pb-2 space-y-1">
                <a href="{{ route('users.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create User') }}
                </a>
            </div>
          @endcan
        </div>

        @can('procurement_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link  class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(6)" onkeypress="toggleSubDir(6)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>

                {{ __('Procurements') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist6" class="hidden bg-gray-0 border rounded-lg pb-1">
          @can('products_access')
            <div class="pt-2 space-y-1">
                <a href="{{ route('products.index') }}" class="text-white ml-4 mr-2">
                    {{ __('Products') }}
                </a>
            </div>
          @endcan
          @can('products_create')
            <div class="pt-1 space-y-1">
                <a href="{{ route('products.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create Product') }}
                </a>
            </div>
          @endcan
          @can('categories_access')
            <div class="pt-1 space-y-1">
                <a href="{{ route('categories.index') }}" class="text-white ml-4 mr-2">
                    {{ __('Categories') }}
                </a>
            </div>
          @endcan
          @can('categories_create')
            <div class="pt-1  pb-2 space-y-1">
                <a href="{{ route('categories.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create Category') }}
                </a>
            </div>
          @endcan
        </div>

        @can('procurement_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link  class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(7)" onkeypress="toggleSubDir(7)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z" />
                </svg>
                {{ __('Commandes') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist7" class="hidden bg-gray-0 border rounded-lg pb-1">
          @can('procurement_list')
            <div class="pt-1 space-y-1">
                <a href="{{ route('procurements.index') }}" class="text-white ml-4 mr-2">
                    {{ __('Procurements List') }}
                </a>
            </div>
          @endcan
          @can('procurement_create')
            <div class="pt-1 space-y-1">
                <a href="{{ route('procurements.create') }}" class="text-white ml-4 mr-2">
                    {{ __('New Procurement') }}
                </a>
            </div>
          @endcan
        </div>

        @can('report_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link  class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(8)" onkeypress="toggleSubDir(8)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                {{ __('Reports') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist8" class="hidden bg-gray-0 border rounded-lg pb-1">
          @can('report_sale')
            <div class="pt-1 space-y-1">
                <a href="{{ route('report.sales') }}" class="text-white ml-4 mr-2">
                    {{ __('Sale Report') }}
                </a>
            </div>
          @endcan
          @can('sales_progress')
            <div class="pt-1 space-y-1">
                <a href="{{ route('report.sales-progress') }}" class="text-white ml-4 mr-2">
                    {{ __('Sales Progress') }}
                </a>
            </div>
          @endcan
          @can('stock_sale')
            <div class="pt-1 space-y-1">
                <a href="{{ route('report.sold-stock') }}" class="text-white ml-4 mr-2">
                    {{ __('Sold Stock') }}
                </a>
            </div>
          @endcan
          @can('profit')
            <div class="pt-1 space-y-1">
                <a href="{{ route('report.profit') }}" class="text-white ml-4 mr-2">
                    {{ __('Incomes') }}
                </a>
            </div>
          @endcan
          @can('report')
            <div class="pt-1 space-y-1 hidden">
                <a href="" class="text-white ml-4 mr-2">
                    {{ __('Sales By Payments') }}
                </a>
            </div>
          @endcan
          @can('product_report')
            <div class="pt-1 space-y-1">
                <a href="{{ route('report.low-stock') }}" class="text-white ml-4 mr-2">
                    {{ __("Stock Report") }}
                </a>
            </div>
          @endcan
          @can('cash_flow')
            <div class="pt-1 pb-2 space-y-1">
                <a href="{{ route('report.cash-flow') }}" class="text-white ml-4 mr-2">
                    {{ __('Cash Flow') }}
                </a>
            </div>
          @endcan
        </div>

        @can('param_access')
        <div class="pt-2 pb-2 space-y-1">
            <x-responsive-nav-link  class="cursor-pointer" aria-label="dropdown" tabindex="0" onclick="toggleSubDir(9)" onkeypress="toggleSubDir(9)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                </svg>
                {{ __('Settings') }}
            </x-responsive-nav-link>
        </div>
        @endcan
        <div id="sublist9" class="hidden bg-gray-0 border rounded-lg pb-1">
          @can('roles_access')
            <div class="pt-1 space-y-1">
                <a href="{{ route('roles.index') }}" class="text-white ml-4 mr-2">
                    {{ __('Roles List') }}
                </a>
            </div>
          @endcan
          @can('roles_create')
            <div class="pt-1 space-y-1">
                <a href="{{ route('roles.create') }}" class="text-white ml-4 mr-2">
                    {{ __('Create Roles') }}
                </a>
            </div>
          @endcan
            <div class="pt-1 pb-2 space-y-1">
                <a href="" class="text-white ml-4 mr-2">
                    {{ __('Permissions Manager') }}
                </a>
            </div>
        </div>
    </div>
</div>
