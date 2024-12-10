export default function initializeForm(form){
    document.addEventListener("DOMContentLoaded", function() {
    var fv = 'input[type=radio][name=fixed_value]';
    let fv_second_child = document.querySelectorAll('#periodical_fixed_values ' + fv)[1];
    fv_second_child.checked = true;

  
    // Set initial value of the input
    document.getElementById('value').value = document.querySelector(fv + ':checked') ? document.querySelector(fv + ':checked').value : '';
  
    // Hide elements initially
    document.getElementById('onetime_fixed_values').style.display = 'none';
    document.getElementById('onetime_payment_methods').style.display = 'none';
    document.getElementById('custom_value_row').style.display = 'none';

  
    // Add event listener for changes in radio buttons inside #periodicity container
    var periodicityRadios = document.querySelectorAll('#periodicity input[type=radio]');
    periodicityRadios.forEach(function(radio) {
      radio.addEventListener('change', function() {
        if (document.getElementById('custom_value').value === '') {
          if (document.getElementById('periodical_fixed_values').style.display === 'none') {
            fv_second_child = document.querySelectorAll('#periodical_fixed_values ' + fv)[1];
            fv_second_child.checked = true;
            document.getElementById('value').value = fv_second_child.value;
            document.querySelector('#custom_value_row').style.display = 'none';
            document.querySelector('#custom_value').removeAttribute("required");
          } else {
            fv_second_child = document.querySelectorAll('#onetime_fixed_values ' + fv)[1];
            fv_second_child.checked = true;
            document.getElementById('value').value = fv_second_child.value;
            document.querySelector('#custom_value_row').style.display = 'none';
            document.querySelector('#custom_value').removeAttribute("required");
          }
        }
  
        // Toggle the visibility of certain elements
        var elements = ['#onetime_fixed_values', '#onetime_payment_methods', '#periodical_fixed_values', '#periodical_payment_methods'];
        elements.forEach(function(selector) {
          var element = document.querySelector(selector);
          element.style.display = (element.style.display === 'none') ? 'block' : 'none';
        });
      });
    });
  
    // Add event listener for changes in fixed_value radio buttons
    var fixedValueRadios = document.querySelectorAll(fv);
    fixedValueRadios.forEach(function(radio) {
      radio.addEventListener('change', function() {
        if (this.value !== "custom"){
            document.querySelector('#value').value = this.value;
            document.querySelector('#custom_value').value = '';
            document.querySelector('#custom_value_row').style.display = 'none';
            document.querySelector('#custom_value').removeAttribute("required");
        } else {
            document.querySelector('#custom_value_row').style.display = '';
            document.querySelector('#custom_value').setAttribute("required","required");
        }
      });
    });
  
    // Add event listener for changes in custom_value input
    document.querySelector('#custom_value').addEventListener('change', function() {
      var checkedRadio = document.querySelector(fv + ':checked');
      if (checkedRadio) {
        checkedRadio.checked = false;
      }
      document.querySelector('#value').value = this.value;
    });
  
    // Add event listener for form submission
    document.querySelector('#darujme-form').addEventListener('submit', function(event) {
      var elementsToRemove = document.querySelectorAll(fv + ', #custom_value, #is_company');
      elementsToRemove.forEach(function(el) {
        el.remove();
      });
    });
  
    // Add event listener for the company checkbox
    document.querySelector('#is_company').addEventListener('click', function() {
      var elementsToToggle = [
        '#row-business_name',
        '#row-business_address',
        '#row-business_id',
        '#row-business_tax_id',
        '#row-business_vat_id',
        '#row-business_request_confirmation'
      ];
      elementsToToggle.forEach(function(selector) {
        var element = document.querySelector(selector);
        element.style.display = (element.style.display === 'none') ? 'block' : 'none';
      });
  
      var kindInput = document.querySelector('#kind');
      kindInput.value = (kindInput.value === 'person') ? 'company' : 'person';
    });
  
    // Initially hide business-related elements
    var businessElements = [
      '#row-business_name',
      '#row-business_address',
      '#row-business_id',
      '#row-business_tax_id',
      '#row-business_vat_id',
      '#row-business_request_confirmation'
    ];
    businessElements.forEach(function(selector) {
      var element = document.querySelector(selector);
      element.style.display = 'none';
    });
  });
}