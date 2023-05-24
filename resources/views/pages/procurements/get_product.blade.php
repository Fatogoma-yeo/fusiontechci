@if(!empty($getProducts))
    @foreach($getProducts as $product)
            <td class="border-2 border-gray-400">
            <p class="ml-2">{{$product['name']}}</p>
            </td>
            <td class="border-2 border-gray-400">
                <x-text-input id="net_purchase_price" class="m-2 w-auto" type="number" name="net_purchase_price" :value="0"  />
            </td>
            <td class="border-2 border-gray-400">
                <x-text-input id="goss_purchase_price" class="m-2 w-auto" type="number" name="goss_purchase_price" :value="0"  />
            </td>
            <td class="border-2 border-gray-400">
                <x-text-input id="purchase_price" class="m-2 w-auto" type="number" name="purchase_price" :value="0"  />
            </td>
            <td class="border-2 border-gray-400">
                <x-text-input id="quantity" class="m-2 w-auto" type="number" name="quantity" :value="1"  />
            </td>
            <td class="border-2 border-r-2 border-gray-400">
                <p class="m-2 uppercase">f cfa0</p>
            </td>
    @endforeach
@endif