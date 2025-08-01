export default function showMorePosts(){
    const MEDIA_BREAKPOINT_XL = 1400;
    const showMoreButtons = document.querySelectorAll('.show-more-posts-btn');

    for (let i = 0; i < showMoreButtons.length; i++){
        showMoreButtons[i].addEventListener("click", unhidePosts);
    }
    function unhidePosts(event){
            let target = event.target.closest('button');
            event.preventDefault();
            let wrapper = target.parentNode.closest('section').querySelector('.show-more-posts-wrapper');
            //let height = wrapper.offsetHeight;
            //wrapper.style.height = height + 'px';
            wrapper.classList.remove('show-more-hide');
            //height = wrapper.scrollHeight;
            //wrapper.style.height = height + 'px';
            //reset after transition
            /* setTimeout(function(){
                wrapper.style.height = "";
            }, 0); */
            //move focus for keyboard navigation
            let moveFocusElement;
            if (window.screen.width >= 1400){
                moveFocusElement = wrapper.querySelector(".hide-xl");
            } else {
                moveFocusElement = wrapper.querySelector(".hide-sm");
            }
            setTimeout(function(){
                moveFocusElement.focus({preventScroll: true});
                let scrollToHeight = moveFocusElement.getBoundingClientRect().top + window.scrollY - document.getElementById("horizontal-nav").offsetHeight - 20;
                window.scrollTo(0, scrollToHeight, "smooth"
                  );
            }, 10);


            let showAllText = target.getAttribute("data-show-all-text");
            target.removeEventListener("click", unhidePosts);
            let replacement = document.createElement('a');
            replacement.setAttribute("href", target.getAttribute("data-href"));
            replacement.setAttribute("class", target.getAttribute("class"));
            replacement.innerHTML = target.getAttribute("data-show-all-text") + '<svg class="icon-square ms-2"><use xlink:href="#icon-arrow-right"></use></svg>';
            target.parentNode.replaceChild(replacement, target);
    }
}