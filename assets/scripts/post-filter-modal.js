export default function postFilterModal() {
    const filterInstances = document.querySelectorAll(".post-filters");
    //fix top position in eshop when notices present
    let horizontalNav = document.querySelector('.horizontal-nav-wrapper');
    updateFilterTop();
    const resizeObserver = new ResizeObserver(() => {
                updateFilterTop()        
    });
    if (filterInstances.length > 0){
        resizeObserver.observe(horizontalNav);
    }

    function updateFilterTop() {
        filterInstances.forEach((element)=>{
        if (document.body.classList.contains('admin-bar')){
            element.style.top = (horizontalNav.getBoundingClientRect().height + 44) + 'px';
        } else {
            element.style.top = (horizontalNav.getBoundingClientRect().height + 12) + 'px';
        }
    })
    }

    filterInstances.forEach((element)=>{
        if (element.classList.contains('position-sticky')){
            element.querySelector('.btn-filter-toggle').addEventListener('click', toggleModal);
            element.querySelector('.btn-close').addEventListener('click', closeModal);  
 
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    if (document.body.classList.contains('modal-open')) {
                        for (let i = 0; i < filterInstances.length; i++) {
                            filterInstances[i].querySelector('.filters-modal').classList.remove('open');
                            document.body.classList.remove('modal-open');
                        }
                    }
                }
            });
        }
    });

    function closeModal(event) {
        let filterModal = event.target.closest('.filters-modal');
        filterModal.classList.remove('open');
        document.body.classList.remove('modal-open');
    }

    function toggleModal(event) {
        let filterModal = event.target.closest(".post-filters").querySelector('.filters-modal');
        if (filterModal.classList.contains('open')) {
            filterModal.classList.remove('open');
            document.body.classList.remove('modal-open');
        } else {
            filterModal.classList.add('open');
            document.body.classList.add('modal-open');
        }
    }

}