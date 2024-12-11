<?php 

$attributes;
if ($attributes["showCollapsed"]){
    get_template_part('template-parts/donation-form', null, array("collapsed" => true));
} else {
    get_template_part('template-parts/donation-form', null, array("collapsed" => false));
}
