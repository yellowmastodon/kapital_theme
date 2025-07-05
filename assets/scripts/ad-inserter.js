import initializeForm from "./donation-form";

/** 
 * Checks if the current page is a single post or podcast.
 * @returns {boolean} Returns true if it's a single post or podcast, false otherwise.
 */
function checkSinglePostOrPodcast() {
    if (document.body.classList.contains('single-post') || document.body.classList.contains('single-podcast')) {
        return true;
    } else {
        return false;
    }
}

/** 
 * Checks if the campaign (Darujme) insertion is active on the page.
 * @returns {boolean} Returns true if Darujme is active, false otherwise.
 */
function checkDarujmeActive() {
    if (document.body.classList.contains('darujme-active')) {
        return true;
    } else {
        return false;
    }
}

/** 
 * Checks if ad insertion is enabled for the single post page.
 * @returns {boolean} Returns true if ad insertion is enabled, false otherwise.
 */
function checkAdInsertingEnabled() {
    if (document.getElementById("main").classList.contains("show-ads")) {
        return true;
    } else {
        return false;
    }
}

/** 
 * Checks if donation form insertion is enabled on the page.
 * @returns {boolean} Returns true if donation form insertion is enabled, false otherwise.
 */
function checkDonationInsertingEnabled() {
    if (document.getElementById("main").classList.contains('show-support')) {
        return true;
    } else {
        return false;
    }
}

/** 
 * Inserts ads and donation form into the content of the page.
 * - For single posts: Inserts ad at 1/3 of the post, and donation form at 2/3.
 * - For other pages: Looks for manually inserted ad block, does not insert donation form via ajax.
 * - Calls a function to count clicks on ads.
 * @param {string} HTMLJson JSON-encoded HTML containing ad and donation form.
 * @param {boolean} singlePostOrPodcast Determines if it's a single post or podcast page.
 * @param {function} registerClicksCallback A function to be called when an ad link is clicked.
 */
function adInserter(HTMLJson, singlePostOrPodcast = true, registerClicksCallback = null) {

    const data = JSON.parse(HTMLJson); // Parse the JSON string into an object.
    const adHTML = data.ads; // Extract ad HTML from the parsed data.
    const donationHTML = data.donation_form; // Extract donation form HTML from the parsed data.
    const donationGloballyEnabled = document.body.classList.contains("darujme-active");
    if (singlePostOrPodcast) {
        // Select content areas for single post or podcast pages
        const content = document.querySelectorAll("#post-content, #podcast-content");
        const paragraphs = document.querySelectorAll("#post-content > p, #podcast-content > p");

        // If there are more than 8 paragraphs, split ad and donation placement
        if (paragraphs.length > 8) {
            const adPosition = Math.floor(paragraphs.length / 3) - 1; // Position for ad (1/3 of content)

            // Insert donation form and ad at calculated positions
            if (donationGloballyEnabled) {
                const donationPosition = Math.floor(paragraphs.length * 2 / 3) - 1; // Position for donation (2/3 of content)
                paragraphs[donationPosition].insertAdjacentHTML('afterend', donationHTML);
            }
            if (adHTML[0] !== "" && typeof adHTML[0] !== "undefined") {
                paragraphs[adPosition].insertAdjacentHTML('afterend', adHTML[0]);
            }
        } else {
            // If there are less than 8 paragraphs, handle insertion differently
            if (paragraphs.length > 3) {
                const adPosition = Math.floor(paragraphs.length / 2) - 1; // Place ad in the middle
                if (adHTML[0] !== "" && typeof adHTML[0] !== "undefined") {
                    paragraphs[adPosition].insertAdjacentHTML('afterend', adHTML[0]);
                }
            }
            // Insert donation form at the end of the content
            if (donationGloballyEnabled) {
                content[0].insertAdjacentHTML('beforeend', donationHTML);
            }
        }

        // If there is a donation form, initialize it
        if (donationHTML !== "") {
            initializeForm(document.getElementById('darujme-form-wrapper'));
        }
    }
    // Handle case for other pages where ad placeholders are manually inserted
    document.querySelectorAll('.wp-block-kapital-ad').forEach(
        (placeholder, key) => {
            // If there is an ad HTML to replace the placeholder, do so
            if (typeof adHTML[key] !== "undefined") {
                placeholder.insertAdjacentHTML('afterend', adHTML[key]);
            }
            // Remove the placeholder after replacement
            placeholder.remove();
        }
    );


    // Find all ads on the page and register click event listeners for them
    const allAds = document.querySelectorAll('.inzercia');
    registerClicks(allAds, registerClicksCallback);
}

/** 
 * Registers click event listeners for ad elements to count clicks.
 * @param {NodeList} elements The list of ad elements.
 * @param {function} ajaxCallback The callback function to call when an ad is clicked.
 */
function registerClicks(elements, ajaxCallback = null) {
    function onClick(event) {
        // Only process the click if it's trusted (not simulated)
        if (event.isTrusted) {
            const ad_id = Number(event.target.closest('.inzercia').attributes["data-ad-id"].value); // Get ad ID
            ajaxCallback('adclickcounter', { ad_id: ad_id }); // Call the provided callback with the ad ID
        }
    }

    // Add click event listener to each ad element
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("click", onClick);
    }
}

export {
    adInserter,
    checkSinglePostOrPodcast,
    checkDarujmeActive,
    checkAdInsertingEnabled,
    checkDonationInsertingEnabled,
    registerClicks,
}
