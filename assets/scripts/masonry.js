import Masonry from 'masonry-layout';

const gallery = document.querySelectorAll('.kapital-gallery .masonry');

gallery.forEach((element)=>{
    console.log(element);
    new Masonry(element, {
                itemSelector: '.col-masonry',
                columnWidth: '.col-masonry',
                percentPosition: true,
                horizontalOrder: true
    });

});