import initializeForm from "./donation-form";

// Ad cycling counter — persists across function calls
let n = 0;

/** 
 * Checks if the current page is a single post or podcast.
 * @returns {boolean} Returns true if it's a single post or podcast, false otherwise.
 */
function checkSinglePostOrPodcast() {
    return document.body.classList.contains('single-post') || document.body.classList.contains('single-podcast');
}

/** 
 * Checks if the campaign (Darujme) insertion is active on the page.
 * @returns {boolean} Returns true if Darujme is active, false otherwise.
 */
function checkDarujmeActive() {
    return document.body.classList.contains('darujme-active');
}

/** 
 * Checks if ad insertion is enabled for the single post page.
 * @returns {boolean} Returns true if ad insertion is enabled, false otherwise.
 */
function checkAdInsertingEnabled() {
    return document.getElementById("main")?.classList.contains("show-ads") ?? false;
}

/** 
 * Checks if donation form insertion is enabled on the page.
 * @returns {boolean} Returns true if donation form insertion is enabled, false otherwise.
 */
function checkDonationInsertingEnabled() {
    return document.getElementById("main")?.classList.contains('show-support') ?? false;
}

/** 
 * Checks if donation form insertion is enabled on the page.
 * @returns {boolean} Returns true if donation form insertion is enabled, false otherwise.
 */
function getAdPlaceholders() {
    return document.querySelectorAll('.wp-block-kapital-ad')
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
function adInserter(HTMLJson, singlePostOrPodcast = true, adPlaceholders, adInsertingEnabled, registerClicksCallback = null) {

    const data = JSON.parse(HTMLJson);
    const adHTML = data.ads;
    const donationHTML = data.donation_form;
    const donationGloballyEnabled = document.body.classList.contains("darujme-active");

    if (singlePostOrPodcast) {
        const content = document.querySelectorAll("#post-content, #podcast-content");
        const paragraphs = document.querySelectorAll("#post-content > p, #podcast-content > p");

        if (paragraphs.length > 8) {
            const donationPosition = Math.floor(paragraphs.length / 3) - 1;
            const adPosition = Math.floor(paragraphs.length * 2 / 3) - 1;

            if (donationGloballyEnabled) {
                paragraphs[donationPosition].insertAdjacentHTML('afterend', donationHTML);
            }

            // Insert ad at position and cycle
            if (adInsertingEnabled && adHTML[n] !== "" && typeof adHTML[n] !== "undefined") {
                paragraphs[adPosition].insertAdjacentHTML('afterend', adHTML[n]);
                // Move to next ad
                if (adHTML.length - 1 > n) {
                    n++;
                } else {
                    n = 0;
                }
            }
        } else {
            if (paragraphs.length > 3) {
                const adPosition = Math.floor(paragraphs.length / 2) - 1;
                if (adInsertingEnabled && adHTML[n] !== "" && typeof adHTML[n] !== "undefined") {
                    paragraphs[adPosition].insertAdjacentHTML('afterend', adHTML[n]);
                    // Move to next ad
                    if (adHTML.length - 1 > n) {
                        n++;
                    } else {
                        n = 0;
                    }
                }
            }
        }
        
        //in both cases insert one donation form at the end
        if (donationGloballyEnabled) {
                content[0].insertAdjacentHTML('beforeend', donationHTML);
        }

        if (donationHTML !== "") {
            document.querySelectorAll('.darujme-form-wrapper').forEach(e => {
                initializeForm(e);
            });
        }
    }

    // Handle manually inserted ad blocks
    adPlaceholders.forEach((placeholder) => {
        if (typeof adHTML[n] !== "undefined") {
            placeholder.insertAdjacentHTML('afterend', adHTML[n]);
            // Cycle ads
            if (adHTML.length - 1 > n) {
                n++;
            } else {
                n = 0;
            }
        }
        placeholder.remove();
    });

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
        if (event.isTrusted) {
            const ad_id = Number(event.target.closest('.inzercia').attributes["data-ad-id"].value);
            if (ajaxCallback) {
                ajaxCallback('adclickcounter', { ad_id: ad_id });
            }
        }
    }

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
    getAdPlaceholders,
    registerClicks,
}