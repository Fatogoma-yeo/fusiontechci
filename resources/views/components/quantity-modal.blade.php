<form  class="p-2" id="quantityForm">
    @csrf

    <div class="w-full text-primary pb-1 font-semibold flex justify-between">
        <div class="w-full p-1">{{ __( 'Définir la quantité' ) }}</div>
        <div class="w-full p-2 text-end">
            <span class="border-2 p-2 rounded-full cursor-pointer hover:bg-gray-50 hover:text-black" x-on:click="$dispatch('close')" onclick="reload()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
        </div>
    </div>
    <div class="w-full text-2xl font-bold text-center flex">
        <div class="w-full p-4 border" id="result">1</div>
        <input type="text" id="quantity" name="quantity" value="" class="hidden" />
        <input type="text" id="select_product_id" name="select_product_id" value="" class="hidden" />
    </div>
    <div class="w-full text-primary text-center font-semibold flex">
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number7func(this)">7</div>
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number8func(this)">8</div>
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number9func(this)">9</div>
    </div>
    <div class="w-full text-primary text-center font-semibold flex">
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number4func(this)">4</div>
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number5func(this)">5</div>
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number6func(this)">6</div>
    </div>
    <div class="w-full text-primary text-center font-semibold flex">
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number1func(this)">1</div>
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number2func(this)">2</div>
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number3func(this)">3</div>
    </div>
    <div class="w-full text-primary text-center font-semibold flex">
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="removenumberfunc()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
            </svg>
        </div>
        <div class="w-full p-8 hover:bg-gray-200 cursor-pointer border" onclick="number0func(this)">0</div>
        <button type="submit" class="w-full p-8 hover:bg-gray-200 border" x-on:click="$dispatch('close')" onclick="sendquantityfunc()" >Entrer</button>
    </div>
</form>