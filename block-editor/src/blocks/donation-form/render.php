<?php 

$attributes;
$show_collapsed = true;
$show_title = true;
if (!$attributes["showCollapsed"]){
    $show_collapsed = false;
}
if (!$attributes["showTitle"]){
    $show_title = false;
}
get_template_part('template-parts/donation-form', null, array("collapsed" => $show_collapsed, "show_title" => $show_title));
