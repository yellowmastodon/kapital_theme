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
    getAdPlaceholders,
    registerClicks,
} from './ad-inserter';
import headerFunctions from './header';
import ajaxRequest from './ajax-request';
import postFilterModal from './post-filter-modal';
import showMorePosts from './show-more-posts';
import initializeForm from './donation-form';
import galleryCarousel from './gallery-carousel';
import shareButton from './share-button';
import postViewLoader from './post-views-loader';

shareButton();
headerFunctions();

document.querySelectorAll('.dismiss-notice').forEach((element) => {
    element.addEventListener("click", (event) => {
        event.target.closest('.woocommerce-message').remove();
    })
});

//stop images with max height from resizing on mobile
document.addEventListener('DOMContentLoaded', ()=>{
 document.documentElement.style.setProperty('--kptl-initial-vh', (window.screen.height / 100) + 'px');
});

showMorePosts();
if (document.querySelector('.gallery-with-lightbox')){
    galleryCarousel();
}

document.querySelectorAll(".darujme-form-wrapper").forEach(wrapper => {
    initializeForm(wrapper);
});

const isSinglePostOrPodcast = checkSinglePostOrPodcast();

postFilterModal();

//adInserter();
if (!document.body.classList.contains('woocommerce-active')) {
    const adPlaceholders = getAdPlaceholders();
    if (isSinglePostOrPodcast) {
        const AdInsertingEnabled = checkAdInsertingEnabled();
        const DonationInsertingEnabled = checkDonationInsertingEnabled();

        if (AdInsertingEnabled || DonationInsertingEnabled || adPlaceholders.length) {
            ajaxRequest('adinserter', { onead: false, ad: AdInsertingEnabled || adPlaceholders.length, donation: DonationInsertingEnabled }, adInserter, [true, adPlaceholders, AdInsertingEnabled, ajaxRequest]);
        }
    } else if (adPlaceholders.length) {
        ajaxRequest('adinserter', { onead: false, ad: true, donation: false }, adInserter, [false, adPlaceholders, false, ajaxRequest]);
    }
}

let postViewsElements = 'article .post-views';
postViewLoader(postViewsElements);