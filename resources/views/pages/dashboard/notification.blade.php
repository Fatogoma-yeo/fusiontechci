<x-notification align="right" width="48">
    <x-slot name="trigger">
      <div id="notification-button" class="hover:shadow-lg hover:border-opacity-0 hover:bg-gray-50 rounded-full border border-gray-400 h-12 w-12 cursor-pointer font-bold text-2xl text-gray-900 justify-center items-center flex">
        @if(auth()->user()->notification->count() > 0)
          <div class="relative float-right mt-2">
              <div class="absolute -ml-6 -mt-8">
                  <div class="bg-sky-400 w-8 h-8 text-white rounded-full text-xs flex items-center justify-center">{{ auth()->user()->notification->count() }}</div>
              </div>
          </div>
        @endif
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
          </svg>
      </div>
    </x-slot>

    <x-slot name="content">
        <div class="absolute bg-white rounded-md left-0 top-0 sm:relative zoom-out-entrance anim-duration-300 h-5/7-screen sm:w-64 sm:h-108 flex flex-row-reverse">
            <div class="z-50 sm:rounded-lg shadow-lg h-full w-full md:mt-2 overflow-y-hidden flex flex-col">
                <div class="sm:hidden p-2 cursor-pointer flex items-center justify-center border-b ">
                    <h3 class="font-semibold hover:text-info-primary">Close</h3>
                </div>
                <div class="overflow-y-auto flex flex-col flex-auto">
                  @forelse(auth()->user()->notification as $notify)
                    <div class="notification-card notice border-b">
                        <div class="p-2 cursor-pointer" @click="even( notification )">
                            <div class="flex items-center justify-between">
                                <h1 class="font-semibold">{{ $notify->title }}</h1>
                                <button @click="deleteNotify('{{ $notify->id }}')" class="border rounded-full h-8 w-8 items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <p class="py-1 text-sm">{{ $notify->description }}</p>
                        </div>
                    </div>
                  @empty
                    <div class="h-full w-full flex items-center justify-center">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 504 512" class="h-6 w-6">
                                <path d="M456 128c26.5 0 48-21 48-47 0-20-28.5-60.4-41.6-77.8-3.2-4.3-9.6-4.3-12.8 0C436.5 20.6 408 61 408 81c0 26 21.5 47 48 47zm0 32c-44.1 0-80-35.4-80-79 0-4.4.3-14.2 8.1-32.2C345 23.1 298.3 8 248 8 111 8 0 119 0 256s111 248 248 248 248-111 248-248c0-35.1-7.4-68.4-20.5-98.6-6.3 1.5-12.7 2.6-19.5 2.6zm-128-8c23.8 0 52.7 29.3 56 71.4.7 8.6-10.8 12-14.9 4.5l-9.5-17c-7.7-13.7-19.2-21.6-31.5-21.6s-23.8 7.9-31.5 21.6l-9.5 17c-4.1 7.4-15.6 4-14.9-4.5 3.1-42.1 32-71.4 55.8-71.4zm-160 0c23.8 0 52.7 29.3 56 71.4.7 8.6-10.8 12-14.9 4.5l-9.5-17c-7.7-13.7-19.2-21.6-31.5-21.6s-23.8 7.9-31.5 21.6l-9.5 17c-4.2 7.4-15.6 4-14.9-4.5 3.1-42.1 32-71.4 55.8-71.4zm80 280c-60.6 0-134.5-38.3-143.8-93.3-2-11.8 9.3-21.6 20.7-17.9C155.1 330.5 200 336 248 336s92.9-5.5 123.1-15.2c11.5-3.7 22.6 6.2 20.7 17.9-9.3 55-83.2 93.3-143.8 93.3z"/>
                            </svg>
                            <p class="text-secondary text-sm">{{ __( 'There is nothing to display...' ) }}</p>
                        </div>
                    </div>
                  @endforelse
                </div>
                <div class="cursor-pointer clear-all">
                    <h3 @click="deleteAll()" class="text-sm p-2 flex items-center justify-center w-full font-semibold ">{{ __( 'Clear All' ) }}</h3>
                </div>
            </div>
        </div>
    </x-slot>
</x-notification>

@push('javascript')
<script type="text/javascript">
    function deleteNotify(id) {
      $.ajax({
        type: "get",
        url: "{{ route('notifications.deleteSingle') }}",
        data: {"notify_id": id},
        success: function (response) {
          window.location.reload();
        }
      });
    }
    function deleteAll() {
      $.ajax({
        type: "get",
        url: "{{ route('notifications.deletAll') }}",
        success: function (response) {
          window.location.reload();
        }
      });
    }
</script>
@endpush
