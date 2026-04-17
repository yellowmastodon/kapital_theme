import { setOffcanvasBannerCookie } from "./donation-offcanvas-banner";

export default function initializeForm(form_wrapper) {
    
    // guard: don't initialise twice
    if (form_wrapper.dataset.formInitialized === '1') return;
    form_wrapper.dataset.formInitialized = '1';

    const bannerMode = form_wrapper.dataset.bannerMode;

    //first make ids unique, to allow multiple forms
    const uid = makeIdsUnique(form_wrapper);
    //rotate color

    if (bannerMode === 'default'){
        setCollapsedColor(form_wrapper);
    }

    //rotate questions on load
    if (bannerMode === 'yesno'){
        const yesBtnWrappers = [...form_wrapper.querySelectorAll('.btn-wrapper--yes')];
        const noBtnWrappers = [...form_wrapper.querySelectorAll('.btn-wrapper--no')];

        const randomIndex = Math.floor(Math.random() * yesBtnWrappers.length);

        yesBtnWrappers.forEach((wrap, i) => {
            wrap.style.visibility = '';
            wrap.style.display = i === randomIndex ? '' : 'none';
        });
        noBtnWrappers.forEach((wrap, i) => {
            wrap.style.visibility = '';
            wrap.style.display = i === randomIndex ? '' : 'none';
        });
    }

    //click to expand form  
    form_wrapper.querySelectorAll('.darujme-form-expand-btn').forEach(el=>{
        el.addEventListener("click", () => {


        const inner = form_wrapper.querySelector(".darujme-form-inner");
        const collapsedForm = inner.querySelector('.darujme-collapsed-form')
        const expandedForm = form_wrapper.querySelector('.darujme-expanded-form');

        if (bannerMode === 'yesno'){

            let response = "";
            if (el.dataset.yesno === 'no'){
                response = collapsedForm.dataset.responseNo;
            } else {
                response = collapsedForm.dataset.responseYes;
            }
            expandedForm.querySelector('.bubble-heading').outerHTML = response;
        }

        const collapsedHeight = collapsedForm.offsetHeight;


        inner.style.height = collapsedHeight + "px";
        form_wrapper.classList.remove("collapsed");
        expandedForm.style.display = "";

        animateExpand(inner);

    });
    })


    //radio inputs of fixed values
    var fv = 'input[type=radio][name=fixed_value]';
    const valueHiddenInput = form_wrapper.querySelector('#darujme_value' + uid);
    const kindHiddenInput = form_wrapper.querySelector('#darujme_kind' + uid);
    const paymentMethodIdHiddenInput = form_wrapper.querySelector('#darujme_payment_method_id' + uid);

    const paymentMethodIdTemp = form_wrapper.querySelectorAll(
        "input[type=radio][name=payment_method_id_temp], input[type=radio][name=payment_method_ib_id_temp]"
    );

    const paymentBankingTempRow = form_wrapper.querySelector('#onetime_payment_methods_ib' + uid);
    const companyCheckbox = form_wrapper.querySelector('#is_company' + uid);
    const periodicityRadios = form_wrapper.querySelectorAll('#periodicity' + uid + ' input[type=radio]');
    const form = form_wrapper.querySelector('#darujme-form' + uid);

    form_wrapper.querySelector("#periodical" + uid).checked = true;

    //on change preselect second value of fixed values
    let fv_second_child = form_wrapper.querySelectorAll('#periodical_fixed_values' + uid + ' ' + fv)[1];
    fv_second_child.checked = true;


    // Set initial value of the input
    valueHiddenInput.value =
        form_wrapper.querySelector(fv + ':checked')
            ? form_wrapper.querySelector(fv + ':checked').value
            : '';


    // Hide elements initially
    form_wrapper.querySelector('#onetime_fixed_values' + uid).style.display = 'none';
    form_wrapper.querySelector('#onetime_payment_methods' + uid).style.display = 'none';
    form_wrapper.querySelector("#onetime_payment_methods_ib" + uid).style.display = 'none';
    form_wrapper.querySelector('#custom_value_row' + uid).style.display = 'none';

    paymentMethodIdTemp.forEach((element) => {
        if (element.checked) element.checked = false;
    });


    // Initially hide business-related elements
    const businessElements = [
        '#row-business_name',
        '#row-business_address',
        '#row-business_id',
        '#row-business_tax_id',
        '#row-business_vat_id',
        '#row-business_request_confirmation'
    ].map(selector => form_wrapper.querySelector(selector + uid));

    businessElements.forEach(function (element) {
        if (!companyCheckbox.checked && element) {
            element.style.display = 'none';
        }
    });


    // Periodicity change
    periodicityRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {

            if (form_wrapper.querySelector('#custom_value' + uid).value === '') {
                if (form_wrapper.querySelector('#periodical_fixed_values' + uid).style.display === 'none') {
                    fv_second_child = form_wrapper.querySelectorAll('#periodical_fixed_values' + uid + ' ' + fv)[1];
                    fv_second_child.checked = true;
                    valueHiddenInput.value = fv_second_child.value;

                    form_wrapper.querySelector('#custom_value_row' + uid).style.display = 'none';
                    form_wrapper.querySelector('#custom_value' + uid).removeAttribute("required");
                } else {
                    fv_second_child = form_wrapper.querySelectorAll('#onetime_fixed_values' + uid + ' ' + fv)[1];
                    fv_second_child.checked = true;
                    valueHiddenInput.value = fv_second_child.value;

                    form_wrapper.querySelector('#custom_value_row' + uid).style.display = 'none';
                    form_wrapper.querySelector('#custom_value' + uid).removeAttribute("required");
                }
            }

            var onetime_elements = ['#onetime_fixed_values', '#onetime_payment_methods'];
            var periodical_elements = ['#periodical_fixed_values', '#periodical_payment_methods'];

            if (this.value === "onetime") {

                periodical_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector + uid);
                    element.style.display = 'none';
                });

                onetime_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector + uid);
                    element.style.display = '';
                    element.querySelectorAll("input[type=radio][name=payment_method_id_temp" + uid + "]")
                        .forEach(function (element) {
                            element.checked = false;
                        })
                });

            } else {

                periodical_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector + uid);
                    element.style.display = '';
                });

                onetime_elements.forEach(function (selector) {
                    var element = form_wrapper.querySelector(selector + uid);
                    element.style.display = 'none';
                    element.querySelectorAll("input[type=radio][name=payment_method_id_temp" + uid + "]")
                        .forEach(function (element) {
                            element.checked = false;
                        })
                });

                paymentBankingTempRow.style.display = 'none';

                if (paymentBankingTempRow.querySelector('input[type=radio]:checked')) {
                    paymentBankingTempRow.querySelector('input[type=radio]:checked').checked = false;
                }

                paymentBankingTempRow.querySelectorAll('input[type=radio]').forEach(
                    (element) => element.removeAttribute("required")
                );
            }

        });
    });


    // fixed_value radios
    var fixedValueRadios = form_wrapper.querySelectorAll(fv);

    fixedValueRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value !== "custom") {
                valueHiddenInput.value = this.value;
                form_wrapper.querySelector('#custom_value' + uid).value = '';
                form_wrapper.querySelector('#custom_value_row' + uid).style.display = 'none';
                form_wrapper.querySelector('#custom_value' + uid).removeAttribute("required");
            } else {
                form_wrapper.querySelector('#custom_value_row' + uid).style.display = '';
                form_wrapper.querySelector('#custom_value' + uid).setAttribute("required", "required");
            }
        });
    });


    // custom value change
    form_wrapper.querySelector('#custom_value' + uid).addEventListener('change', function () {
        var checkedRadio = form_wrapper.querySelector(fv + ':checked');
        if (checkedRadio) checkedRadio.checked = false;

        valueHiddenInput.value = this.value;
    });


    // Payment method
    paymentMethodIdTemp.forEach(function (payment_method) {
        payment_method.addEventListener('change', function () {

            if (payment_method.value !== "payment_ib") {

                if (payment_method.name !== "payment_method_ib_id_temp" + uid) {
                    paymentBankingTempRow.style.display = 'none';

                    if (paymentBankingTempRow.querySelector('input[type=radio]:checked')) {
                        paymentBankingTempRow.querySelector('input[type=radio]:checked').checked = false;
                    }

                    paymentBankingTempRow.querySelectorAll('input[type=radio]').forEach(
                        (element) => element.removeAttribute("required")
                    );
                }

                paymentMethodIdHiddenInput.value = payment_method.value;

            } else {
                paymentMethodIdHiddenInput.value = '';
                paymentBankingTempRow.style.display = '';

                paymentBankingTempRow.querySelectorAll('input[type=radio]').forEach(
                    (element) => element.setAttribute("required", "required")
                );
            }
        });
    });


    // Form submission: remove temp inputs
    form.addEventListener('submit', function (event) {

        
        var elementsToDisable = form_wrapper.querySelectorAll(
            fv +
            ', #custom_value' + uid +
            ', #is_company' + uid +
            ', input[type=radio][name=payment_method_id_temp' + uid + ']' +
            ', input[type=radio][name=payment_method_ib_id_temp' + uid + ']'
        );

        elementsToDisable.forEach(function (el) {
            el.disabled = true;
        });

        //set cookie based on periodicity
        const periodicity = form.querySelector('input[name="periodicity"]:checked').value;
        let days = 31;

        if (periodicity === 'periodical'){
            days = 183;
        }

        setOffcanvasBannerCookie(days);

        // Re-enable immediately after to preserve back-navigation
        setTimeout(() => {
            elementsToDisable.forEach(el => el.disabled = false);
        }, 0);
    });


    // Company checkbox
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
            var element = form_wrapper.querySelector(selector + uid);
            if (element) {
                element.style.display = (companyCheckbox.checked === true) ? 'block' : 'none';
            }
        });

        kindHiddenInput.value = (kindHiddenInput.value === 'person') ? 'company' : 'person';
    });
}


function animateExpand(element) {
    element.style.height = element.scrollHeight + "px";
    element.classList.add("animating");

    setTimeout(() => {
        element.style.height = "auto";
        element.classList.remove("animating");
    }, 200);
}

function setCollapsedColor(form_wrapper, bannerMode = 'default'){

    const collapsedForm = form_wrapper.querySelector('.darujme-collapsed-form');
    const hasColors = collapsedForm.hasAttribute('data-colors');

    if (hasColors){
        if (!setCollapsedColor.color) {
                const colorArray = JSON.parse(form_wrapper.querySelector('.darujme-collapsed-form').getAttribute('data-colors'));
                if (colorArray.length){
                    const index = Math.floor(Math.random() * colorArray.length);
                    setCollapsedColor.color =  colorArray[index];
                } else {
                    //fallback
                    setCollapsedColor.color = '#212529'
                }
            }
            form_wrapper.style.transition = 'none'; //remove bg transition
            form_wrapper.style.setProperty('--kptl-darujme-bkg', setCollapsedColor.color);

            requestAnimationFrame(()=>{
                form_wrapper.style.transition = ''; //reset bg transition
            });
    }
   
}


function makeIdsUnique(form_wrapper) {
    // Check if already has a UID
    const existingUid = form_wrapper.dataset.uid;
    if (existingUid) {
        return existingUid;
    }

    const uid = "_" + Math.random().toString(36).substring(2, 9);
    
    // Store the UID on the form wrapper
    form_wrapper.dataset.uid = uid;

    form_wrapper.querySelectorAll('[id]').forEach(el => {
        const oldId = el.id;
        const newId = oldId + uid;
        el.id = newId;

        form_wrapper.querySelectorAll(`label[for="${oldId}"]`)
            .forEach(label => label.setAttribute("for", newId));

    });

    return uid;
}
