export default function productCarousel() {
    document.addEventListener('DOMContentLoaded', function () {
        var firstClone = true;

        // Select all carousel items inside #post-carousel
        const productCarousel = document.getElementById('product-carousel');
        var carouselItems = productCarousel.querySelectorAll('.carousel-item');
        let galleryLinks = document.querySelectorAll('.product-gallery .gallery-link');
        galleryLinks.forEach(
            function (link) {
                link.addEventListener("click", function (event) {
                    event.preventDefault();
                    if (firstClone) {
                        // Select the modal content and carousel inner container
                        const modalContent = document.getElementById('product-modal-content');
                        const modalInner = modalContent.querySelector('.carousel-inner');

                        // Clone each carousel item from the post carousel and append it to modal's carousel-inner
                        galleryLinks.forEach(function (link) {
                            var clonedItem = link.querySelector('img').cloneNode();
                            clonedItem.classList.remove('w-100');
                            clonedItem.setAttribute("sizes", "95vw");
                            let imageWrapper = document.createElement('div');
                            imageWrapper.classList.add('carousel-img-wrapper');
                            imageWrapper.appendChild(clonedItem);
                            let carouselItemWrapperDiv = document.createElement('div');
                            carouselItemWrapperDiv.classList.add('carousel-item');
                            carouselItemWrapperDiv.appendChild(imageWrapper);
                            modalInner.appendChild(carouselItemWrapperDiv);
                        });

                        firstClone = false;  // Prevent cloning multiple times
                    }
                    // Get the active index from the event target (you'll need to pass the event here)
                    var activeIndex = Array.from(galleryLinks).indexOf(event.target.closest('a'));
                    
                    // Get the currently active carousel item and remove the active class
                    var activeItem = productCarousel.querySelector('.carousel-item.active');
                    if (activeItem !== undefined && activeItem !== null) {
                        activeItem.classList.remove('active');
                    }
                    // Find the new active item based on the active index
                    activeItem = productCarousel.querySelectorAll('.carousel-item')[activeIndex];
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
    });
}