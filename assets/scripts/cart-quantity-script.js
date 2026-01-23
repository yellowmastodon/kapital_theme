function initializeQuantityButtons() {
    var quantityRows = document.querySelectorAll(".product-quantity");
    quantityRows.forEach(function (row) {
        var minus = row.querySelector(".kapital-woo-quantity-minus");
        var plus = row.querySelector(".kapital-woo-quantity-plus");
        var input = row.querySelector("input[type='number']");
        var min = input.getAttribute('min');
        var max = input.getAttribute('max');
        input.style.width = (input.value.length + 3) + 'ch';

        input.addEventListener('input', () => {
            input.style.width = (input.value.length + 3) + 'ch';
        });

        minus.addEventListener("click", function (event) {
            if ((min != null && min !== "" && Number(input.value) - 1 >= Number(min)) || ((min == null || min === "") && Number(input.value) - 1 >= 0)) {
                input.value = Number(input.value) - 1;
                input.dispatchEvent(new Event('input', {
                    'bubbles': true
                }));
            }
        })
        
        plus.addEventListener("click", function (event) {
            if (Number(input.value) + 1 <= Number(max) || max === "" || max === null) {
                input.value = Number(input.value) + 1;
                input.dispatchEvent(new Event('input', {
                    'bubbles': true
                }));
            }
        })
    });
}
window.addEventListener('load', initializeQuantityButtons);

jQuery(document.body).on('updated_cart_totals', function () {
    initializeQuantityButtons(); // Call function when cart is updated
});

jQuery(document.body).on('wc_fragments_refreshed', function () {
    initializeQuantityButtons(); // Call function when cart fragments are refreshed
});