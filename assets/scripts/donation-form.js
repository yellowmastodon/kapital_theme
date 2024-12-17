export default function initializeForm(form_wrapper) {
    //click to expand form
    form_wrapper.querySelector('#darujme-form-expand-btn').addEventListener("click",
        () => {
            form_wrapper.querySelector('#darujme-expanded-form').style.display = "";
            setTimeout(()=>{
                form_wrapper.classList.remove("collapsed");
            }, 20); //wait a bit so the transition works;
        });
    //radio inputs of fixed values
    var fv = 'input[type=radio][name=fixed_value]';
    const valueHiddenInput = form_wrapper.querySelector('#darujme_value');
    const kindHiddenInput = form_wrapper.querySelector('#darujme_kind');
    const paymentMethodIdHiddenInput = form_wrapper.querySelector('#darujme_payment_method_id');
    const paymentMethodIdTemp = form_wrapper.querySelectorAll("input[type=radio][name=payment_method_id_temp], input[type=radio][name=payment_method_ib_id_temp]");
    const paymentBankingTempRow = form_wrapper.querySelector('#onetime_payment_methods_ib');
    const companyCheckbox = form_wrapper.querySelector('#is_company');
    const periodicityRadios = form_wrapper.querySelectorAll('#periodicity input[type=radio]');
    const form = form_wrapper.querySelector('#darujme-form');

    form_wrapper.querySelector("#periodical").checked = true;
    //on change preselect second value in of fixed values
    let fv_second_child = document.querySelectorAll('#periodical_fixed_values ' + fv)[1];
    fv_second_child.checked = true;
    

    // Set initial value of the input
    valueHiddenInput.value = document.querySelector(fv + ':checked') ? document.querySelector(fv + ':checked').value : '';

    // Hide elements initially
    form_wrapper.querySelector('#onetime_fixed_values').style.display = 'none';
    form_wrapper.querySelector('#onetime_payment_methods').style.display = 'none';
    form_wrapper.querySelector("#onetime_payment_methods_ib").style.display = 'none';
    form_wrapper.querySelector('#custom_value_row').style.display = 'none';
    paymentMethodIdTemp.forEach(
        (element)=>{
            if (element.checked){
                element.checked = false;
            }
        }
    )
    
    // Initially hide business-related elements
    const businessElements = form_wrapper.querySelectorAll(
        '#row-business_name, #row-business_address, #row-business_id, #row-business_tax_id, #row-business_vat_id, #row-business_request_confirmation'
    );
    businessElements.forEach(function (element) {
        if (!companyCheckbox.checked){
            element.style.display = 'none';
        }
    });

    // Add event listener for changes in radio buttons inside #periodicity container
    periodicityRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (document.getElementById('custom_value').value === '') {
                if (document.getElementById('periodical_fixed_values').style.display === 'none') {
                    fv_second_child = document.querySelectorAll('#periodical_fixed_values ' + fv)[1];
                    fv_second_child.checked = true;
                    valueHiddenInput.value = fv_second_child.value;
                    form_wrapper.querySelector('#custom_value_row').style.display = 'none';
                    form_wrapper.querySelector('#custom_value').removeAttribute("required");
                } else {
                    fv_second_child = document.querySelectorAll('#onetime_fixed_values ' + fv)[1];
                    fv_second_child.checked = true;
                    valueHiddenInput.value = fv_second_child.value;
                    form_wrapper.querySelector('#custom_value_row').style.display = 'none';
                    form_wrapper.querySelector('#custom_value').removeAttribute("required");
                }
            }
            // Toggle the visibility of certain elements
            var onetime_elements = ['#onetime_fixed_values', '#onetime_payment_methods'];
            var periodical_elements = ['#periodical_fixed_values', '#periodical_payment_methods'];
            if (this.value === "onetime") {
                periodical_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector);
                    element.style.display = 'none';
                });
                onetime_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector);
                    element.style.display = '';
                    element.querySelectorAll("input[type=radio][name=payment_method_id_temp]").forEach(function (element) {
                        element.checked = false;
                    })
                });
            } else {
                periodical_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector);
                    element.style.display = '';
                });
                onetime_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector);
                    element.style.display = 'none';
                    element.querySelectorAll("input[type=radio][name=payment_method_id_temp]").forEach(function (element) {
                        element.checked = false;
                    })
                });
                paymentBankingTempRow.style.display = 'none';
                    if (paymentBankingTempRow.querySelector('input[type=radio]:checked')){
                        paymentBankingTempRow.querySelector('input[type=radio]:checked').checked = false;
                    }
                    paymentBankingTempRow.querySelectorAll('input[type=radio]').forEach(
                        (element) => {
                            element.removeAttribute("required");
                        }
                    )
            }
        });
    });

    // Add event listener for changes in fixed_value radio buttons
    var fixedValueRadios = document.querySelectorAll(fv);
    fixedValueRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value !== "custom") {
                valueHiddenInput.value = this.value;
                form_wrapper.querySelector('#custom_value').value = '';
                form_wrapper.querySelector('#custom_value_row').style.display = 'none';
                form_wrapper.querySelector('#custom_value').removeAttribute("required");
            } else {
                form_wrapper.querySelector('#custom_value_row').style.display = '';
                form_wrapper.querySelector('#custom_value').setAttribute("required", "required");
            }
        });
    });

    // Add event listener for changes in custom_value input
    form_wrapper.querySelector('#custom_value').addEventListener('change', function () {
        var checkedRadio = document.querySelector(fv + ':checked');
        if (checkedRadio) {
            checkedRadio.checked = false;
        }
        valueHiddenInput.value = this.value;
    });

    //Add event listener for payment method
    paymentMethodIdTemp.forEach(function(payment_method){
        payment_method.addEventListener('change', function(){
            if(payment_method.value !== "payment_ib"){
                if (payment_method.name !== "payment_method_ib_id_temp"){
                    paymentBankingTempRow.style.display = 'none';
                    if (paymentBankingTempRow.querySelector('input[type=radio]:checked')){
                        paymentBankingTempRow.querySelector('input[type=radio]:checked').checked = false;
                    }
                    paymentBankingTempRow.querySelectorAll('input[type=radio]').forEach(
                        (element) => {
                            element.removeAttribute("required");
                        }
                    )
                }
                paymentMethodIdHiddenInput.value = payment_method.value;
            } else {
                paymentMethodIdHiddenInput.value = '';
                paymentBankingTempRow.style.display = '';
                paymentBankingTempRow.querySelectorAll('input[type=radio]').forEach(
                    (element) => {
                        element.setAttribute("required", "required");
                    }
                )
            }
        })
    })


    // Add event listener for form submission
   form.addEventListener('submit', function (event) {
        var elementsToRemove = form_wrapper.querySelectorAll(fv + ', #custom_value, #is_company, input[type=radio][name=payment_method_id_temp], input[type=radio][name=payment_method_ib_id_temp]');
        elementsToRemove.forEach(function (el) {
            el.remove();
        });
    });

    // Add event listener for the company checkbox
    companyCheckbox.addEventListener('click', function () {
        var elementsToToggle = [
            '#row-business_name',
            '#row-business_address',
            '#row-business_id',
            '#row-business_tax_id',
            '#row-business_vat_id',
            '#row-business_request_confirmation'
        ];
        elementsToToggle.forEach(function (selector) {
            var element = form_wrapper.querySelector(selector);
            element.style.display = (companyCheckbox.checked === true) ? 'block' : 'none';
        });

        kindHiddenInput.value = (kindHiddenInput.value === 'person') ? 'company' : 'person';
    });
}