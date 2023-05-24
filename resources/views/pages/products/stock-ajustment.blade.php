@extends('layouts.base')
@section('content')

<div class="py-2 flex justify-between">
    <label for="title" class="font-bold my-2 text-primary text-white">
        <h1 class="text-2xl font-bold">{{ __( 'Stock Adjustment' ) }}</h1>
        <h3>{{ __( 'Adjust stock of existing products.' ) }}</h3>
    </label>
</div>
<div class="">
    <form method="POST" action="{{ route('product.stock-ajustment') }}" id="ajustForm">
        @csrf
        <div  class="">
            <div class="bg-white rounded-md shadow-lg px-4 w-full">
                <div class="">
                    <div class="grid grid-cols-1 gap-4 pb-8">
                        <div class="col-span-1 mt-4">
                            <x-text-input id="search" class="mt-1 w-full" type="text" placeholder="Saisissez le nom du produit." />
                            <div class="ajustproducts"></div>
                        </div>
                        <div class="col-span-1 mt-2 relative overflow-x-auto">
                            <table class="w-full rounded-lg">
                                <thead class="p-4 text-lg">
                                    <tr class="bg-teal-400 shadow-lg text-white mx-2 px-2">
                                    <th class="border-2">{{ __( 'Product' ) }}</th>
                                    <th class="border-2">{{ __( 'Unit' ) }}</th>
                                    <th class="border-2">{{ __( 'Operation' ) }}</th>
                                    <th class="border-2">{{ __( 'Quantity' ) }}</th>
                                    <th class="border-2">{{ __( 'Value' ) }}</th>
                                    </tr>
                                </thead>
                                <tbody class="text-md">
                                    <tbody id="ajustproductSelect" class="myTable"></tbody>
                                </tbody>
                            </table>
                            <div class="border-t p-2 flex justify-end">
                                <button class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded font-semibold text-sm text-white tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __( 'Proceed' ) }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('javascript')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        $('#search').on('keyup',function(e){
            var $value= e.target.value;
            $.ajax({
                type : 'get',
                url : "{{ route('product.search') }}",
                data:{'search':$value},
                success:function(data){
                    $('.ajustproducts').html(data);
                }
            });
        });

        $(document).on('click','.product', function () {
            var maxField = 50;
            var wrapper = $('#ajustproductSelect');
            var value = $(this).text();
            var product_id = $(this).find("input[name='product_id']").val();
            $(".ajustproducts").html("");
            $("#search").val("");

            var fieldHTML =+'<tbody class="text-md">'
                        +'       <tr class="prod_item border-b-2 border-gray-400 px-2 py-2">'
                        +'          <td class="border-2 border-gray-400">'
                        +'            <p class="ml-2">'
                        +'              <input type="text" class="hidden" name="product_id[]" value='+product_id+'>'
                        +                   value
                        +'               <a  class="flex items-center cursor-pointer" onclick="deleteRow(this)">'
                        +'                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-600">'
                        +'                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />'
                        +'                  </svg>'
                        +'              </a>'
                        +'             </p>'
                        +'            </td>'
                        +'            <td class="p-2 border-2 border-gray-400">'
                        +'                <input type="number" id="unit_price" class="px-2 w-full border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="unit_price[]" onkeyup="unitfunc(this)" required>'
                        +'            </td>'
                        +'            <td class="p-2 border-2 border-gray-400">'
                        +'              <select name="operation" id="operation" class="p-2 border-gray-300 rounded-md shadow-sm bg-gray-100 w-full focus:border-indigo-500 focus:ring-indigo-500" required>'
                        +'                   <option value="">Select</option>'
                        +'                   <option value="{{ __("Added") }}">{{ __("Added") }}</option>'
                        +'                   <option value="{{ __("Deleted") }}">{{ __("Deleted") }}</option>'
                        +'                   <option value="{{ __("Defective") }}">{{ __("Defective") }}</option>'
                        +'                   <option value="{{ __("Lost") }}">{{ __("Lost") }}</option>'
                        +'               </select>'
                        +'            </td>'
                        +'            <td class="p-2 border-2 border-gray-400">'
                        +'                <input type="number" id="quantity" class="px-2 w-full border-gray-300 bg-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="quantity[]"  onkeyup="quantitiesfunc(this)" required>'
                        +'            </td>'
                        +'            <td class="border-2 border-r-2 border-gray-400 total">'
                        +'                <p class="m-2 uppercase text-right">0 f cfa</p>'
                        +'                <input type="number" class="hidden" id="total_price" name="total_price[]">'
                        +'            </td>'
                        +'       </tr>'
                        +'    </tbody>'; 

            var x = 1;
            if(x < maxField){ 
                x++;
                $(wrapper).append(fieldHTML);
            }

        });
        
    });

    function upTo(el, tagName) {
        tagName = tagName.toLowerCase();

        while (el && el.parentNode) {
            el = el.parentNode;
            if (el.tagName && el.tagName.toLowerCase() == tagName) {
            return el;
            }
        }
        return null;
    }

    function deleteRow(el) {
        var row = upTo(el, 'tr')
        if (row) row.parentNode.removeChild(row);
    }

    var total = document.getElementsByClassName("total");
    var currency = " F CFA";

    function quantitiesfunc(q) {
        var unitValue = q.parentElement.parentElement.children[1].children[0].value;
        q.parentElement.parentElement.children[4].children[0].innerHTML = q.value * unitValue + currency;
        q.parentElement.parentElement.children[4].children[1].value = q.value * unitValue;
    }

    function unitfunc(u) {
        var quantityValue = u.parentElement.parentElement.children[3].children[0].value;
        u.parentElement.parentElement.children[4].children[0].innerHTML = u.value * quantityValue + currency;
        u.parentElement.parentElement.children[4].children[1].value = u.value * unitValue;
    }

</script>

@endpush