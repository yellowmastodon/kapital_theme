//import ajaxRequest from "./ajax-request";

/** checks page is single post */
function checkSinglePost() {
    if (document.body.classList.contains('single-post')) {
          return true;
    } else {
        return false;
    }
}

/** checks if single post has ad inserting enabled */
function checkAdInsertingEnabledSinglePost() {
    if (document.getElementById("main").classList.contains('show-ads')) {
          return true;
    } else {
        return false;
    }
}

/** insert ads
 * for single-post in 1/3 of post, for other pages looks for manually inserted ad block
 * also calls function to count clicks
 * @param {string} adHTML html to insert
 * @param {boolean} isSinglePost
 * @param {function} registerClicksCallback function to be called when an ad link is clicked
 */
function adInserter(adHTML, isSinglePost = false, registerClicksCallback) {
    const paragraphs = document.querySelectorAll("#post-content > p");
    if (paragraphs.length > 8) {
        const adPosition = Math.floor((paragraphs.length - 1) / 3);
        paragraphs[adPosition].insertAdjacentHTML('afterend', adHTML);
    } else if(paragraphs.length > 3){
        console.log(paragraphs);
        const adPosition = Math.floor((paragraphs.length - 1) / 2);
        paragraphs[adPosition].insertAdjacentHTML('afterend', adHTML);
    }
    const allAds = document.querySelectorAll('.inzercia');
    registerClicks(allAds, registerClicksCallback);
}

function registerClicks(elements, ajaxCallback = null){
    //console.log(elements);
    function onClick(event){
        //simple human detection
        if (event.isTrusted){
            const ad_id = Number(event.target.closest('.inzercia').attributes["data-ad-id"].value);
            ajaxCallback('adclickcounter', {ad_id: ad_id});
        }
    }
    for (let i = 0; i < elements.length; i++){
        elements[i].addEventListener("click", onClick);
    }
}

export {
    adInserter,
    checkSinglePost,
    registerClicks,
    checkAdInsertingEnabledSinglePost
}