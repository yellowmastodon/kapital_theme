export default function showMorePosts(){
    const MEDIA_BREAKPOINT_XL = 1400;
    const showMoreButtons = document.querySelectorAll('.show-more-posts');

    for (let i = 0; i < showMoreButtons.length; i++){
        showMoreButtons[i].addEventListener("click", unhidePosts);
    }
    function unhidePosts(event){
            let target = event.target.closest('button');
            event.preventDefault();
            let wrapper = target.parentNode.closest('section').querySelector('.show-more-posts-wrapper');
            let height = wrapper.offsetHeight;
            wrapper.style.height = height + 'px';
            wrapper.classList.remove('show-more-hide');
            height = wrapper.scrollHeight;
            wrapper.style.height = height + 'px';
            //reset after transition
            setTimeout(function(){
                wrapper.style.height = "";
            }, 700);
            //move focus for keyboard navigation
            let moveFocusElement;
            if (window.screen.width >= 1400){
                moveFocusElement = wrapper.querySelector(".hide-xl");
            } else {
                moveFocusElement = wrapper.querySelector(".hide-sm");
            }
            setTimeout(function(){
                moveFocusElement.focus({preventScroll: true});
                let scrollToHeight = moveFocusElement.getBoundingClientRect().top + + window.scrollY + document.getElementById("horizontal-nav").offsetHeight;
                window.scrollTo(0, scrollToHeight, "smooth"
                  );
                  console.log(scrollToHeight);

            }, 10);


            let showAllText = target.getAttribute("show-all-text");
            target.innerHTML = showAllText + '<svg class="icon-square ms-2"><use xlink:href="#icon-arrow-right"></use></svg>';
            target.removeEventListener("click", unhidePosts);
    }
}