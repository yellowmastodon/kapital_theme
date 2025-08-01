import ajaxRequest from "./ajax-request";
/**
 * @var string selector - post views placeholder element - should include data-id attribute with post id
 * */
export default function postViewLoader(selector) {
    let postViewsElements = document.querySelectorAll(selector);
    document.addEventListener("DOMContentLoaded", () => {
        if (typeof postViewsElements !== undefined && postViewsElements.length > 0) {
            postViewsElements = Array.from(postViewsElements);
            for (let i = 0; i < postViewsElements.length; i += 8) {
                let postViewsBatch = postViewsElements.slice(i, i + 8);
                let postIdsBatch = [];
                for (let i = 0; i < postViewsBatch.length; i++) {
                    postIdsBatch[i] = postViewsBatch[i].getAttribute("data-id");
                }
                ajaxRequest(
                    'getviews',
                    { ids: postIdsBatch },
                    insertPostViews,
                    [postViewsBatch]
                );
            }
        }
    });
}

function insertPostViews(response, postViewsElements) {
    response = JSON.parse(response);
    for (let i = 0; i < response.length; i++) {
        if (typeof postViewsElements[i] !== 'undefined'){
            let numberElement = postViewsElements[i].querySelector('.number');
            numberElement.insertAdjacentHTML('afterbegin', response[i]);
            postViewsElements[i].classList.remove('opacity-0');
        }
    }
}