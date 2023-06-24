<form method="post" action="{{ route('orders.store') }}" id="posForm" class="hidden">
    @csrf

    <input type="text" name="product_id[]" id="product_id">
    <input type="text" name="product_name[]" id="product_name">
    <input type="text" name="price[]" id="product_price">
    <input type="text" name="quantity[]" id="product_quantity">
    <input type="text" name="pos_subtotal[]" id="pos_subtotal">
    <input type="text" name="customer" id="pos_customer_name">
    <input type="text" name="subtotal" id="product_subtotal">
    <input type="text" name="total" id="product_total">
    <input type="text" name="discount" id="discount_total">
    <input type="text" name="orders_id" id="proceed_orders_id">
    <input type="text" name="cash_value" id="cash_value">

</form>
@push('javascript')
    <script>
        $(document).ready(function () {
            $("#save_posForm").on('click', function(){
                var customer_name = document.getElementById('pos_customer').textContent;
                var ids = document.getElementById('pos_product_id').textContent;
                var order_id = document.getElementById('orders_id').textContent;
                var subtotal = document.getElementById('subTotal').textContent;
                var rabais = document.getElementById('rabais').textContent;
                var total = document.getElementById('Total').textContent;
                var idAll = document.querySelectorAll('#pos_product_id');
                var nameAll = document.querySelectorAll('#pos_product_name');
                var priceAll = document.querySelectorAll('#prices');
                var quantityAll = document.querySelectorAll('#quantitie');
                var posSubTotalAll = document.querySelectorAll('#posSubTotals');
                var productId = [];
                var productName = [];
                var price = [];
                var quantity = [];
                var posSubTotal = [];
                if (idAll.length > 0) {
                    for (let i = 0; i < idAll.length; i++) {
                        productId.push(idAll[i].textContent);
                    }
                    for (let i = 0; i < nameAll.length; i++) {
                        productName.push(nameAll[i].textContent);
                    }
                    for (let i = 0; i < priceAll.length; i++) {
                        price.push(priceAll[i].textContent);
                    }
                    for (let i = 0; i < quantityAll.length; i++) {
                        quantity.push(quantityAll[i].textContent);
                    }
                    for (let i = 0; i < posSubTotalAll.length; i++) {
                        posSubTotal.push(posSubTotalAll[i].textContent);
                    }
                }

                if (ids) {
                    document.getElementById("product_id").value = productId;
                    document.getElementById("product_name").value = productName;
                    document.getElementById("product_price").value = price;
                    document.getElementById("product_quantity").value = quantity;
                    document.getElementById("pos_subtotal").value = posSubTotal;
                    document.getElementById("pos_customer_name").value = customer_name;
                    document.getElementById("product_subtotal").value = subtotal;
                    document.getElementById("product_total").value = total;
                    document.getElementById("discount_total").value = rabais;
                    document.getElementById("proceed_orders_id").value = order_id;
                }
            });
        });
    </script>
@endpush
