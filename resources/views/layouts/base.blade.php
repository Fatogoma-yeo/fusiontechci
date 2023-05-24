<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" id="base">
                <div class="p-4 text-gray-900">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>