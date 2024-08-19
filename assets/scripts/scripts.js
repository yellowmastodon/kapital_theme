/**
 * Mobile navigation toggle
 * @param {mixed} event
 */

// Import just what we need

// import 'bootstrap/js/dist/alert';
// import 'bootstrap/js/dist/button';
// import 'bootstrap/js/dist/carousel';
import Collapse from 'bootstrap/js/dist/collapse';
// import 'bootstrap/js/dist/dropdown';
// import 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/offcanvas';
// import 'bootstrap/js/dist/popover';
// import 'bootstrap/js/dist/scrollspy';
// import 'bootstrap/js/dist/tab';
// import 'bootstrap/js/dist/toast';
// import 'bootstrap/js/dist/tooltip';

const topHeader = document.getElementById('top-header');
const topHeaderLogo = topHeader.querySelector('svg');
const horizontalNavLogo = document.getElementById('horizontal-nav-logo');
let topHeaderLogoBottom;
let topHeaderCollapsed;
let horizontalNavLogoShown;
let topHeaderCollapse;

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
    console.log('hiding');
    horizontalNavLogo.classList.add('opacity-0');
    horizontalNavLogoShown = false;
    setTimeout(() => {
        horizontalNavLogoShown = false;
        horizontalNavLogo.classList.add('invisible');
    }, 100);
}

const showHorizontalNavLogo = () => {
    console.log('showing');
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
            hideHorizontalNavLogo();
        }
    }
    
    topHeaderLogoBottom = topHeaderLogo.getBoundingClientRect().bottom;

    if (topHeaderLogoBottom > 0 && horizontalNavLogoShown) {
        hideHorizontalNavLogo();
    }
    if (topHeaderLogoBottom <= 0 && !horizontalNavLogoShown) {
        showHorizontalNavLogo();
    }
};