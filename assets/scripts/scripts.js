// Import just what we need

// import 'bootstrap/js/dist/alert';
// import 'bootstrap/js/dist/button';
import 'bootstrap/js/dist/carousel';
import Collapse from 'bootstrap/js/dist/collapse';
//import 'bootstrap/js/dist/dropdown';
import Modal from 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/offcanvas';
// import 'bootstrap/js/dist/popover';
// import 'bootstrap/js/dist/scrollspy';
// import 'bootstrap/js/dist/tab';
// import 'bootstrap/js/dist/toast';
// import 'bootstrap/js/dist/tooltip';
import {
    adInserter,
    checkSinglePostOrPodcast,
    checkDarujmeActive,
    checkAdInsertingEnabled,
    checkDonationInsertingEnabled,
    registerClicks,
} from './ad-inserter';
import headerFunctions from './header';
import ajaxRequest from './ajax-request';
import postFilterModal from './post-filter-modal';
import showMorePosts from './show-more-posts';
import initializeForm from './donation-form';
import productCarousel from './product-carousel';

headerFunctions();

document.querySelectorAll('.dismiss-notice').forEach((element) => {
    element.addEventListener("click", (event) => {
        event.target.closest('.woocommerce-message').remove();
    })
})

//stop images with max height from resizing on mobile
document.addEventListener('DOMContentLoaded', ()=>{
 document.documentElement.style.setProperty('--kptl-initial-vh', (window.screen.height / 100) + 'px');
});

showMorePosts();
if (document.body.classList.contains('single-product')){
    productCarousel();
}

const donation_form_wrapper = document.getElementById("darujme-form-wrapper");
if (donation_form_wrapper) {
    initializeForm(donation_form_wrapper);
}
//console.log(site_info);
const isSinglePostOrPodcast = checkSinglePostOrPodcast();
const AdInsertingEnabled = checkAdInsertingEnabled();
const DonationInsertingEnabled = checkDonationInsertingEnabled();
postFilterModal();

//adInserter();
if (!document.body.classList.contains('woocommerce-active')) {
    if (isSinglePostOrPodcast) {
        if (AdInsertingEnabled || DonationInsertingEnabled) {
            ajaxRequest('adinserter', { onead: true, ad: AdInsertingEnabled, donation: DonationInsertingEnabled }, adInserter, [true, ajaxRequest]);
        }
    } else {
        ajaxRequest('adinserter', { onead: false, ad: AdInsertingEnabled, donation: false }, adInserter, [false, ajaxRequest]);
    }
}

let postViewsElements = document.querySelectorAll('article .post-views');
let articles_id;
addEventListener("DOMContentLoaded", () => {
    if (typeof postViewsElements !== undefined) {
        postViewsElements = Array.from(document.querySelectorAll('article .post-views'));
        for (let i = 0; i < postViewsElements.length; i += 8) {
            let postViewsBatch = postViewsElements.slice(i, i + 8);
            let postIdsBatch = [];
            for (let i = 0; i < postViewsBatch.length; i++) {
                postIdsBatch[i] = postViewsBatch[i].getAttribute("data-id")
            }
            ajaxRequest('getviews', { ids: postIdsBatch },
                insertPostViews,
                [postViewsBatch]);
        }
    }
});
function insertPostViews(response, postViewsElements) {
    response = JSON.parse(response);
    for (let i = 0; i < response.length; i++) {
        let numberElement = postViewsElements[i].querySelector('.number');
        numberElement.insertAdjacentHTML('afterbegin', response[i]);
        postViewsElements[i].classList.remove('opacity-0');
    }
}
