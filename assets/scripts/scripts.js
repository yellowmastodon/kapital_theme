// Import just what we need

// import 'bootstrap/js/dist/alert';
// import 'bootstrap/js/dist/button';
import 'bootstrap/js/dist/carousel';
import Collapse from 'bootstrap/js/dist/collapse';
//import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/modal';
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
import ajaxRequest from './ajax-request';
import postFilterModal from './post-filter-modal';
import showMorePosts from './show-more-posts';
import initializeForm from './donation-form';
import productCarousel from './product-carousel';

document.querySelectorAll('.dismiss-notice').forEach((element) => {
    element.addEventListener("click", (event) => {
        event.target.closest('.woocommerce-message').remove();
    })
})

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
const topHeader = document.getElementById('top-header');
const topHeaderLogo = topHeader.querySelector('svg');
const horizontalNavLogo = document.getElementById('horizontal-nav-logo');
let topHeaderLogoBottom;
let topHeaderCollapsed;
let horizontalNavLogoShown;
let topHeaderCollapse;
let isTouchDevice = false;


/** top header is shown onload only on front page
 * horizontal nav logo is shown only when top header is not visible
 * initally they share the state (showHorizontalNavLogo = topHeaderCollapsed)
*/
topHeaderCollapsed = !topHeader.classList.contains('show');
horizontalNavLogoShown = topHeaderCollapsed;
if (topHeaderCollapsed) {
    topHeaderCollapse = new Collapse(topHeader, {
        toggle: false
    });
}


//if has opacity-0 class, that means it is hidden

const hideHorizontalNavLogo = () => {
    horizontalNavLogo.classList.add('opacity-0');
    horizontalNavLogoShown = false;
    setTimeout(() => {
        horizontalNavLogoShown = false;
        horizontalNavLogo.classList.add('invisible');
    }, 100);
}

const showHorizontalNavLogo = () => {
    horizontalNavLogo.classList.remove('opacity-0', 'invisible');
    horizontalNavLogoShown = true;
    //simple fix for situation when user scrolls up and down fast enough, that it adds class later than the remove attempt
    setTimeout(() => {
        horizontalNavLogoShown = true;
        horizontalNavLogo.classList.remove('invisible');
    }, 100);
}


window.onscroll = function () {
    if (topHeaderCollapsed) {
        if (document.documentElement.scrollTop == 0) {
            topHeaderCollapse.show();
            topHeaderCollapsed = false;
            //remove event listener for wheel after the top header is shown
            window.removeEventListener("wheel", showTopHeaderOnMousewheelUp);
            hideHorizontalNavLogo();
        }
    }
    if (!topHeaderCollapsed) {
        topHeaderLogoBottom = topHeaderLogo.getBoundingClientRect().bottom;
        if (topHeaderLogoBottom > 0 && horizontalNavLogoShown) {
            hideHorizontalNavLogo();
        }
        if (topHeaderLogoBottom <= 0 && !horizontalNavLogoShown) {
            showHorizontalNavLogo();
        }
    }
};

window.addEventListener("wheel", showTopHeaderOnMousewheelUp);

//uncollapse top part of header by scrollwheel up when on top of page (onscroll is not triggered by wheelup if there is nowhere to scroll on desktop    )
function showTopHeaderOnMousewheelUp(event) {
    if (event.deltaY < 0 && document.documentElement.scrollTop == 0 && topHeaderCollapsed) {
        if (!document.body.classList.contains('modal-open')){
            topHeaderCollapse.show();
            topHeaderCollapsed = false;
            //remove event listener after the top header is shown
            window.removeEventListener("wheel", showTopHeaderOnMousewheelUp);
            hideHorizontalNavLogo();
        }
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
