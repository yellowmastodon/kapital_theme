<div id="kapital-gallery-modal" class="modal fade modal-fullscreen" tabindex="-1" aria-hidden="true" data-bs-keyboard="true">
    <a type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <svg class="h1 mb-0 icon-square">
            <use xlink:href="#icon-close"></use>
        </svg><span class="visually-hidden"><?= __("Zavrieť galériu", "kapital") ?></span>
    </a>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content bg-transparent border-0">

            <div id="kapital-gallery-carousel" class="carousel slide px-sm-5" data-ride="false" data-interval="false" data-bs-keyboard="true">
                <div class="carousel-inner rounded"></div>
                <a class="position-absolute carousel-control-prev p-3 opacity-100" type="button" data-bs-target="#kapital-gallery-carousel" data-bs-slide="prev">
                    <span class="carousel-control-btn">
                        <svg class="mb-0">
                            <use xlink:href="#icon-page-prev"></use>
                        </svg><span class="visually-hidden"><?= __("Predošlé", "kapital") ?></span>
                    </span>
                </a>
                <a class="position-absolute carousel-control-next p-3 opacity-100" type="button" data-bs-target="#kapital-gallery-carousel" data-bs-slide="next">
                    <span class="carousel-control-btn">
                        <svg class="mb-0">
                            <use xlink:href="#icon-page-next"></use>
                        </svg><span class="visually-hidden"><?= __("Ďalšie", "kapital") ?></span>
                    </a>
                </span>
            </div>
        </div>
    </div>
</div>