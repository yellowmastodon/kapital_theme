export default function showMorePosts(){
    const showMoreButtons = document.querySelectorAll('.show-more-posts');
    console.log(showMoreButtons);

    for (let i = 0; i < showMoreButtons.length; i++){
        showMoreButtons[i].addEventListener("click", unhidePosts);
    }
    function unhidePosts(event){
            let target = event.target.closest('a');
            console.log(target);
            event.preventDefault();
            let wrapper = target.parentNode.closest('section').querySelector('.show-more-posts-wrapper');
            let height = wrapper.offsetHeight;
            console.log(height);
            wrapper.style.height = height + 'px';
            wrapper.classList.remove('show-more-hide');
            height = wrapper.scrollHeight;
            wrapper.style.height = height + 'px';
            //reset after transition
            setTimeout(function(){
                wrapper.style.height = "";
            }, 700);
            let showAllText = target.getAttribute("show-all-text");
            target.innerHTML = showAllText + '<svg class="icon-square ms-2"><use xlink:href="#icon-arrow-right"></use></svg>';
            target.removeEventListener("click", unhidePosts);
    }
}