<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.delete-cart-item').click(function (){
        var btn = $(this);
        var rowID = btn.attr('id');
        var cartItem = btn.closest('.cart-item');

        var data = {
            'id': rowID,
        };
        toggleScreenSpinner(true);
        $.post('/cart/destroy/item',data).done(function (response) {
            cartItem.remove();
            if (response.item_count == 0){
                // Find a <table> element with id="myTable":
                var table = document.getElementById("cart-table");
                // Create an empty <tr> element and add it to the 1st position of the table:
                var newRow = table.insertRow();
                // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
                var newCell = newRow.insertCell();
                newCell.innerHTML = '<td>{{__('main.There is no form items yet.')}}</td>';
            }
            refreshCartInfo(response)
        });
    });

    $( document ).ajaxComplete(function() {
        toggleScreenSpinner(false);
    });
    function refreshCartInfo(cart)
    {
        $('.cart-count').each(function (){
            $(this).html(cart.item_count);
        });
        $('.cart-subtotal').html(cart.subtotal);
        $('.cart-grand-total').html(cart.grand_total);
    }
    function addItemToCart()
    {
        $('.cart-action').click(function (){
            var btn = $(this);
            var product = btn.closest('.product');
            var cartCount = $('.cart-count');
            if (btn.hasClass('in-cart')){
                UIkit.notification("<span uk-icon='icon: warning'></span> "+"{{__('main.Item is already added to your cart.')}}", {pos: 'top-center', status:'warning'})
                return false;
            }
            btn.html('<div uk-spinner="ratio: 0.6"></div>\n'+' {{__('main.Adding ...')}}')

            var data = {
                'id': product.find('.product-id-input').val(),
                'name':product.find('.product-name-input').val(),
                'qty': 1,
                'price': product.find('.product-price-input').val(),
                'image': product.find('.product-primary-image-input').val(),
                'sku': product.find('.product-sku-input').val(),
            };
            $.post('/cart/add',data).done(function (response) {
                btn.html('<span uk-icon="icon: check"></span>'+' {{__('main.Added to cart')}}')
                btn.addClass('in-cart');
                refreshCartInfo(response)
                UIkit.notification("<span uk-icon='icon: check'></span> "+"{{__('main.Item has been added successfully.')}}", {pos: 'top-center', status:'success'})
            });
        });
    }
    addItemToCart();
</script>