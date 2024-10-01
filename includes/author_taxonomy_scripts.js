/** Autofills slug and other values, when editing term
 * term name is managed by php
 */

const first_name_input = document.getElementById("first_name");
const last_name_input = document.getElementById("last_name");
const slug_input = document.getElementById("tag-slug") || document.getElementById("slug");
const is_custom_slug = document.getElementById("is_custom_slug");
const full_name_select = document.getElementById("full_name");
let full_name_options = full_name_select.querySelectorAll("option");
let first_name = "";
let last_name = "";
let unsanitized_slug = slug_input.value;

/** sanitizes and autofills slug and calls function to construct variants of full name */
const onNameInput = () => {
    window.setTimeout(function() {
        if (is_custom_slug.value == "false") {
            unsanitized_slug = first_name_input.value + last_name_input.value;
            slug_input.value = unsanitized_slug.normalize('NFKD').replaceAll(/[\u0300-\u036f, \u02b0-\u02ff, \u0020-\u002f]/g, "").replaceAll(' ', '').toLowerCase();
        }
        constructFullNameOptions(first_name_input.value.trim(), last_name_input.value.trim());
    }, 1)
}

/** constructs 2 variants of full name and appends/removes them as option elements
 * @param {string} first_name - already trimmed first name
 * @param {string} last_name - already trimmed first name
 * */ 

const constructFullNameOptions = (first_name, last_name) => {
    if (last_name !== '') {
        if (first_name !== '') {
            if (full_name_options.length < 2) {
                let second_option = document.createElement("option");
                second_option.innerHTML = first_name + ' ' + last_name;
                second_option.value = first_name + ' ' + last_name;
                full_name_select.appendChild(second_option);
                full_name_options = full_name_select.querySelectorAll("option");
            }
            full_name_options[0].innerHTML = first_name + ' ' + last_name;
            full_name_options[0].value = first_name + ' ' + last_name;
            full_name_options[1].innerHTML = last_name + ' ' + first_name;
            full_name_options[1].value = last_name + ' ' + first_name;
            full_name_select.disabled = false;

        } else {
            if (full_name_options.length > 1) {
                full_name_options = full_name_select.querySelectorAll("option");
                if (typeof full_name_options[1] != 'undefined') {
                    full_name_options[1].remove();
                }
            }
            full_name_select.disabled = true;
            full_name_options[0].selected = true;
            full_name_options[0].value = last_name;
            full_name_options[0].innerHTML = last_name;

        }
    } else {
        if (typeof full_name_options[1] != 'undefined') {
            full_name_options[1].remove();
        }
        full_name_options = full_name_select.querySelectorAll("option");
        full_name_options[0].value = "Celé meno autorstva";
        full_name_options[0].innerHTML = "Celé meno autorstva";
        full_name_options[0].selected = true;
        full_name_select.disabled = true;

    }
}

first_name_input.addEventListener("input", onNameInput);
last_name_input.addEventListener("input", onNameInput);


slug_input.addEventListener("input", function() {
    is_custom_slug.value = "true";
});