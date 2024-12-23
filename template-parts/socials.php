<?php
/**
 * Renders social icons
 * expects theme options as argument as link to social media are saved in theme options
 */
defined('ABSPATH') || exit;

if (isset($args["theme_options"])){
    $kptl_theme_options = $args["theme_options"];
}

if (isset($kptl_theme_options["facebook"]) || isset($kptl_theme_options["instagram"]) || isset($kptl_theme_options["youtube"])): ?>

    <div class="kptl-socials d-inline-block">
        <?php
        if (isset($kptl_theme_options["facebook"])): ?>
            <a class="btn border-0 rounded-pill" href="<?= $kptl_theme_options["facebook"] ?>">
                <svg>

                    <use xlink:href="#icon-facebook" />
                </svg>
                <span class="visually-hidden">Facebook</span>

            </a>
        <?php endif; ?>
        <?php
        if (isset($kptl_theme_options["instagram"])): ?>
            <a class="btn border-0 rounded-pill" href="<?= $kptl_theme_options["instagram"] ?>">
                <svg>
                    <use xlink:href="#icon-instagram" />
                </svg>
                <span class="visually-hidden">Instagram</span>

            </a>
        <?php endif; ?>
        <?php
        if (isset($kptl_theme_options["youtube"])): ?>
            <a class="btn border-0 rounded-pill" href="<?= $kptl_theme_options["youtube"] ?>">
                <svg>
                    <use xlink:href="#icon-youtube" />
                </svg>
                <span class="visually-hidden">Youtube</span>

            </a>
        <?php endif; ?>

    </div>

<?php endif; ?>