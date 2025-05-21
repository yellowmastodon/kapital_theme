import Modal from 'bootstrap/js/dist/modal';


export default function postFilterModal() {
    //selects only sticky navigation, as non sticky does not need to collapse to modal
    const filterInstances = document.querySelectorAll(".filters-modal.position-sticky");
    const filterTogglerWrapperInstances = document.querySelectorAll(".btn-filter-toggle-wrapper");
    //fix top position in eshop when notices present
    let horizontalNav = document.querySelector('.horizontal-nav-wrapper');
    //never show spread out filters for events archive
    //let isEventsArchive = document.body.classList.contains('post-type-archive-event');
    let isEventsArchive = false;
    
    /** 
     * arbitrary size where filters do not cover the whole screen 
     * remove display none
    */
    let displayFiltersAsModal = false;

    if (window.screen.height > 500 && window.screen.width > 500 && !isEventsArchive){
        filterInstances.forEach((element) => {
            element.style.display = "";
        });
    } else {
        displayFiltersAsModal = true;
        filterTogglerWrapperInstances.forEach((element)=>{
            element.style.display = "";
        });
        filterInstances.forEach((filters)=>{
            filters.classList.add('modal', 'fade', 'modal-fullscreen', 'bg-primary', 'py-3');
            filters.classList.remove('alignwider');

            filters.querySelector('.close').style.display = "";
        })
    }
    updateFilterTop();
    const resizeObserver = new ResizeObserver(() => {
                updateFilterTop()        
    });
    if (filterInstances.length > 0){
        resizeObserver.observe(horizontalNav);
    }
    
    function updateFilterTop() {
        /** add top position according to horizontal nav height to filters wrapper or toggle button
        */
        let elementsTop = displayFiltersAsModal ? filterTogglerWrapperInstances : filterInstances;
        elementsTop.forEach((element)=>{
        if (document.body.classList.contains('admin-bar')){
            element.style.top = (horizontalNav.getBoundingClientRect().height + 44) + 'px';
        } else {
            element.style.top = (horizontalNav.getBoundingClientRect().height + 12) + 'px';
        }
    });
    }
    
    if (filterTogglerWrapperInstances.length > 0)
    filterTogglerWrapperInstances.forEach((wrapper => {
        let toggle = wrapper.querySelector('.btn-filter-toggle');
        let firstClick = true;
        let modal;
        toggle.addEventListener('click', (event)=>{
            if (firstClick){
                let options = {
                    show: true
                }
                //modal is sibling of toggle 
                
                //console.log(wrapper.parentNode.querySelector('.filters-modal'));
                let modalElement = wrapper.parentNode.querySelector('.filters-modal');
                modalElement.classList.remove('position-sticky');
                modal = new Modal(modalElement, options);
                firstClick = false;
            }
            //console.log(modal);
            modal.toggle();
        });
    }))
}