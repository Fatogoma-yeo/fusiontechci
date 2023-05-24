
<div id="pos-customer-select" class="ns-box shadow-xl w-4/5-screen md:w-2/5-screen xl:w-108">

    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-gray-200 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" id="user-select-close">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <div id="header" class="border-b ns-box-header text-center font-semibold text-2xl py-2">
        <h2>{{ __( 'Select Customer' ) }}</h2>
    </div>
    <div class="relative">
        <div class="p-2 border-b ns-box-body items-center flex justify-between">
            <span>{{ __( 'Selected' ) }} : </span>
            <div class="flex items-center justify-between">
                <span></span>
            </div>
        </div>
        <div class="p-2 border-b ns-box-body flex justify-between text-primary">
            <div class="input-group flex-auto border-2 rounded">
                <input
                    placeholder="{{ __('Search Customer') }}" 
                    type="text" 
                    class="outline-none w-full p-2 rounded-md border">
            </div>
        </div>
        <div class="h-3/5-screen xl:h-2/5-screen overflow-y-auto">
            <ul class="selectCustomer">
                
            </ul>
        </div>
    </div>
</div>