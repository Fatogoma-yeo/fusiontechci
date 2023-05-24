<x-app-layout>
    <!-- cahier dashboard -->
  @can('cashier_access')
    @include('pages.dashboard.cashier-dashboard')
  @endcan
    <!-- orner dashboard -->
  @can('owners_access')
    @include('pages.dashboard.store-dashboard')
  @endcan

</x-app-layout>
