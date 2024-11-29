export default function postFilterModal() {

    const filterInstances = document.querySelectorAll(".post-filters");
    for (let i = 0; i < filterInstances.length; i++) {
        filterInstances[i].querySelector('.btn-filter-toggle').addEventListener('click', toggleModal);
        filterInstances[i].querySelector('.btn-close').addEventListener('click', closeModal);
    }

    function closeModal(event) {
        let filterModal = event.target.closest('.filters-modal');
        filterModal.classList.remove('open');
        document.body.classList.remove('modal-open');
    }

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