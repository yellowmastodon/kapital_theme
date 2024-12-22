import loadHeaderSeries from './load-header-series';
import Collapse from 'bootstrap/js/dist/collapse';


export default function headerFunctions() {

    loadHeaderSeries();
    const topHeader = document.getElementById('top-header');
    const topHeaderLogo = topHeader.querySelector('svg');
    const horizontalNavLogo = document.getElementById('horizontal-nav-logo');
    let topHeaderLogoBottom;
    let topHeaderCollapsed;
    let horizontalNavLogoShown;
    let topHeaderCollapse;
    let isTouchDevice = false;
    let isCollapseInitialized = false;

    /** top header is shown onload only on front page
     * horizontal nav logo is shown only when top header is not visible
     * initally they share the state (showHorizontalNavLogo = topHeaderCollapsed)
     * this should happen only after large breakpoint - 900px
    */
    topHeaderCollapsed = !topHeader.classList.contains('show');
    horizontalNavLogoShown = topHeaderCollapsed;
    
    const initializeCollapsed = () => {
        if (topHeaderCollapsed) {
            topHeaderCollapse = new Collapse(topHeader, {
                toggle: false
            });
            isCollapseInitialized = true;
        }        
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



    const showTopHeaderOnScroll = () => {
        if (topHeaderCollapsed) {
            if (document.documentElement.scrollTop == 0) {
                topHeaderCollapse.show();
                topHeaderCollapsed = false;
                //remove event listener for wheel after the top header is shown
                window.removeEventListener("wheel", showTopHeaderOnMousewheelUp);
                hideHorizontalNavLogo();
            }
        } else {
            toggleHorizontalNavLogo();
        }
    }
    
    const toggleHorizontalNavLogo = () => {
        topHeaderLogoBottom = topHeaderLogo.getBoundingClientRect().bottom;
        if (topHeaderLogoBottom > 0 && horizontalNavLogoShown) {
            hideHorizontalNavLogo();
        }
        if (topHeaderLogoBottom <= 0 && !horizontalNavLogoShown) {
            showHorizontalNavLogo();
        }

    }

    if (window.screen.width >= 900){
        initializeCollapsed();
        window.addEventListener("scroll", showTopHeaderOnScroll);
        window.addEventListener("wheel", showTopHeaderOnMousewheelUp);
    } else {
        if (!topHeaderCollapsed) {
            window.addEventListener("scroll", toggleHorizontalNavLogo);
        }
    }

    


    window.onresize = () => {
        if (window.screen.width >= 900){
            if (!isCollapseInitialized){
                initializeCollapsed();
                window.addEventListener("scroll", showTopHeaderOnScroll);
                window.addEventListener("wheel", showTopHeaderOnMousewheelUp);
            }
        }
    }

    //uncollapse top part of header by scrollwheel up when on top of page (onscroll is not triggered by wheelup if there is nowhere to scroll on desktop    )
    function showTopHeaderOnMousewheelUp(event) {
        if (event.deltaY < 0 && document.documentElement.scrollTop == 0 && topHeaderCollapsed) {
            if (!document.body.classList.contains('modal-open')) {
                topHeaderCollapse.show();
                topHeaderCollapsed = false;
                //remove event listener after the top header is shown
                window.removeEventListener("wheel", showTopHeaderOnMousewheelUp);
                hideHorizontalNavLogo();
            }
        }
    }
}