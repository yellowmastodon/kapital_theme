<?php



function kapital_woo_quantity_script()
{
    // Check if we're on the cart page
    if (is_cart() || is_product()) {
?>
        <script id="dopice" type="text/javascript">
            function initializeQuantityButtons() {
                var quantityRows = document.querySelectorAll(".product-quantity");

                quantityRows.forEach(function(row){
                    var minus = row.querySelector(".kapital-woo-quantity-minus");
                    var plus = row.querySelector(".kapital-woo-quantity-plus");
                    var input = row.querySelector("input[type='number']");
                    var min = input.getAttribute('min');
                    var max = input.getAttribute('max');
                    input.setAttribute('size', input.value.length);
                minus.addEventListener("click", function(event) {
                    if ((Number(input.value) - 1 >= Number(min)) || min === "" && Number(input.value) - 1 > 0) {
                        input.value = Number(input.value) - 1;
                        input.setAttribute('size', input.value.length);
                        input.dispatchEvent(new Event('input', {
                            'bubbles': true
                        }));
                    }
                })
                plus.addEventListener("click", function(event) {
                    if (Number(input.value) + 1 <= Number(max) || max === "") {
                        input.value = Number(input.value) + 1;
                        input.setAttribute('size', input.value.length);
                        input.dispatchEvent(new Event('input', {
                            'bubbles': true
                        }));
                    }
                })
                })              
            }
            document.onload = initializeQuantityButtons();
            jQuery(document.body).on('updated_cart_totals', function () {
                initializeQuantityButtons() ; // Call function when cart is updated
    });

     jQuery(document.body).on('wc_fragments_refreshed', function() {
        initializeQuantityButtons() ; // Call function when cart fragments are refreshed
    });
        </script>
<?php
    }
}
add_action('wp_footer', 'kapital_woo_quantity_script');
