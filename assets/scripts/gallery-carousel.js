/**
 * creates one carousel from all the gallery blocks
 */
export default function galleryCarousel() {
    document.addEventListener('DOMContentLoaded', function () {
        var firstClone = true;
        const galleryLinks = document.querySelectorAll('.gallery-with-lightbox .btn-gallery');
        if (galleryLinks.length){
             const modal = document.getElementById('kapital-gallery-modal');
        const modalContent = modal.querySelector('.modal-content');
        const galleryCarousel = modalContent.querySelector('#kapital-gallery-carousel');
        const galleryInner = galleryCarousel.querySelector('.carousel-inner');

        // Select all carousel items inside #post-carousel
        const carouselItems = galleryCarousel.querySelectorAll('.carousel-item');
        galleryLinks.forEach(
            function (link) {
                link.addEventListener("click", function (event) {
                    event.preventDefault();
                    if (firstClone) {
                        // Select the modal content and carousel inner container

                        // Clone each carousel item from the gallery and append it to modal's carousel-inner
                        galleryLinks.forEach(function (link) {
                            const clonedItem = link.querySelector('img').cloneNode();
                            const originalFigcaptionEl = link.querySelector('figcaption');
                            let figcaption = null;
                            if (originalFigcaptionEl){
                                figcaption = originalFigcaptionEl.innerHTML;
                            } else if (clonedItem.hasAttribute('data-caption')){
                                figcaption = clonedItem.getAttribute('data-caption');
                            }
                            clonedItem.classList.remove('w-100');
                            clonedItem.setAttribute("sizes", "95vw");
                            const imageWrapper = document.createElement('figure');
                            imageWrapper.classList.add('carousel-img-wrapper', 'mb-0');
                            imageWrapper.appendChild(clonedItem);
                            if (figcaption){
                                const newFigcaption = document.createElement('figcaption');
                                newFigcaption.innerHTML = figcaption;
                                imageWrapper.appendChild(newFigcaption);
                            }
                            let carouselItemWrapperDiv = document.createElement('div');
                            carouselItemWrapperDiv.classList.add('carousel-item');
                            carouselItemWrapperDiv.appendChild(imageWrapper);
                            galleryInner.appendChild(carouselItemWrapperDiv);
                        });

                        firstClone = false;  // Prevent cloning multiple times
                    }
                    // Get the active index from the event target (you'll need to pass the event here)
                    var activeIndex = Array.from(galleryLinks).indexOf(event.target.closest('a'));
                    
                    // Get the currently active carousel item and remove the active class
                    var activeItem = galleryCarousel.querySelector('.carousel-item.active');
                    if (activeItem !== undefined && activeItem !== null) {
                        activeItem.classList.remove('active');
                    }
                    // Find the new active item based on the active index
                    activeItem = galleryCarousel.querySelectorAll('.carousel-item')[activeIndex];
                    activeItem.classList.add('active');
                })
            }
        )

        carouselItems.forEach(function (item) {
            item.addEventListener('click', function () {

                // Optionally, you can handle any active item updates here.
                // e.g., you might want to show image captions or any other logic.

            });
        });
        }
       
    });
}