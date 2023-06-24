<div class="w-full">
    <div class="w-full text-primary text-center font-semibold flex gap-2 py-2 px-2">
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(7)">7</div>
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(8)">8</div>
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(9)">9</div>
    </div>
    <div class="w-full text-primary text-center font-semibold flex gap-2 py-2 px-2">
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(4)">4</div>
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(5)">5</div>
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(6)">6</div>
    </div>
    <div class="w-full text-primary text-center font-semibold flex gap-2 py-2 px-2">
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(1)">1</div>
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(2)">2</div>
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(3)">3</div>
    </div>
    <div class="w-full text-primary text-center font-semibold flex gap-2 py-2 px-2">
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="removenumbers()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline-flex">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
            </svg>
        </div>
        <div class="w-full hover:bg-gray-200 cursor-pointer border rounded-md" onclick="numbers(0)">0</div>
        <div class="w-full hover:bg-gray-200 border rounded-md" onclick="cancels()">C</div>
    </div>
</div>

@push('javascript')
    <script>
        var cash =document.getElementById("cash");

        function numbers(v){
            cash.value+=v;
            document.getElementById("cash_value").value = cash.value;
        }

        function cancels(){
            cash.value="";
        }

        function removenumbers(){
            cash.value = cash.value.substr(0,cash.value.length-1);
        }
    </script>
@endpush
