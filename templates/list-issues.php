<?php /* Template Name: Template that displays lists of issues (cisla) */

global $kapital_taxonomies_with_list_pages;

//this template is assigned automatically at theme activation by function in custom_taxonomies, that allows us to do this
$current_taxonomy = array_search($post->post_name, $kapital_taxonomies_with_list_pages);
get_header();

/** terms follow naming convention YYYY MM {name} */
$last_issue = get_terms( array(
    'taxonomy'   => $current_taxonomy,
    'hide_empty' => true,
    'order_by' => 'name',
    'order' => 'DESC',
    'number' => 1,
    'paged' => true
    ) );

$last_issue_year = array();
preg_match('/[0-9]{4}/', $last_issue[0]->name, $last_issue_year);
$last_issue_year = (int) $last_issue_year[0];

//fallback to manually set date, actually this would suffice
if (!$last_issue_year){
    $last_issue_year = 2024;
}



$first_issue = get_terms( array(
    'taxonomy'   => $current_taxonomy,
    'hide_empty' => true,
    'order_by' => 'name',
    'order' => 'ASC',
    'number' => 1,
    'paged' => true
    ) );
$first_issue_year = array();


preg_match('/[0-9]{4}/', $first_issue[0]->name, $first_issue_year);

//fallback to manually set date, actually this would suffice
$first_issue_year = (int) $first_issue_year[0];
if (!$first_issue_year){
    $first_issue_year = 2017;
}

$query_year = (int)get_query_var('rok');

//if wrong or no var "rok" (year) passed, get latest issue
if ($query_year > $last_issue_year || $query_year < $first_issue_year){
    $query_year = $last_issue_year;
}

/** render breadcrubms */?>
<?php echo kapital_breadcrumbs(array(
        [__('Články', 'kapital'), get_post_type_archive_link('post')],
        [get_the_title(), "", true]

    ), "container");?>

<main class="main container" role="main" id="main">

    <header class="mb-5">
        <?php echo kapital_bubble_title(__('Archív', 'kapital') . ' ' . $first_issue_year . '-' . $last_issue_year, 1, 'term-list-title ' );?>
    </header>
    
    <nav aria-label="<?php echo __('Navigácia rokov čísel.', 'kapital')?>" class="row gx-2 justify-content-center">
        <?php
        $base_url = get_permalink();
        for ($i = $last_issue_year; $i >= $first_issue_year; $i--):
            if($i === $query_year):?>
                <div class="col-auto mb-2"><div aria-current="page" class="btn btn-outline active"><?php echo $i ?></div></div>
            <?php else:?>
                <div class="col-auto mb-2"><a href="<?php echo $base_url . 'rok/' . $i;?>"class="btn btn-outline"><?php echo $i ?></a></div>
            <?php endif;?>
        <?php endfor;?>
    </nav>
    <?php
    $issues = get_terms( array(
        'taxonomy'   => $current_taxonomy,
        'hide_empty' => true,
        'order_by' => 'name',
        'order' => 'DESC',
        'paged' => false,
        'name__like' => strval($query_year),
        'get' => '',
    ));
    //var_dump($issues);
    if (!empty($issues)):?>
        <section class="row alignwider mt-5">
            <?php foreach($issues as $issue):?>
                <div class="archive-item col-12 archive-item col-sm-6 col-md-4 ff-grotesk text-center text-uppercase mb-6">
                    <a class="archive-item-link text-decoration-none" href="<?php echo get_term_link($issue);?>">
                    <?php
                        $featured_image = get_field('featured_image', $current_taxonomy . '_' . $issue->term_id);
                        //var_dump($featured_image);
                        if (!$featured_image) $featured_image = get_field('cover', $current_taxonomy . '_' . $issue->term_id);
                        if (isset($featured_image) && $featured_image):
                            echo kapital_responsive_image($featured_image, "(max-width: 599px) 96vw, (max-width: 899px) 48vw, (max-width: 1199px) 33vw, (max-width: 1399px) 300px, 350px", false, "rounded archive-item-image w-100");
                        endif;
                        ?>
                        <?php $formatted_title = kapital_get_issue_title_year_month($issue->name, false);
                        if ($formatted_title[1] !== ""):?>
                            <p class="h3 red-color-hover fw-normal mt-2 mb-0" data-text="<?=$formatted_title[1]?>"><?=$formatted_title[1]?></p>
                            <h2 class="h3 mb-0 red-outline-hover" data-text="<?= $formatted_title[0]?>"><?=$formatted_title[0]?></h2>
                        <?php else:?>
                            <h2 class="h3 mt-2 mb-0 red-outline-hover" data-text="<?=$formatted_title[0]?>"><?=$formatted_title[0]?></h2>                      
                        <?php endif;?>
                    </a>
                </div>

            <?php endforeach; ?>
        </section>
    <?php endif;

    //issues use custom navigation?>
    <nav class="pagination issues py-1 d-flex ff-sans justify-content-center" aria_label="<?php echo __('Stránkovanie rokov čísel.', 'kapital')?>">
        
        <?php
        $max_page_links = 5;
        if($query_year === $last_issue_year){
            $end_size = 2;
            $start_size = 0;
        } elseif($query_year === $first_issue_year) {
            $end_size = 0;
            $start_size = 2;
        } else{
            $end_size = 1;
            $start_size = 1;
        }
        //last issue link
        if ($query_year && $last_issue_year - 1 > $query_year):?>
            <a class="first page-chevrons rounded-pill" href="<?php echo $base_url . 'rok/' . $last_issue_year;?>"><span class="visually-hidden"><?php echo $last_issue_year;?></span><svg><use xlink:href="#icon-page-first"></use></svg></a>
        <?php endif;
        //newer issue link
        if ($query_year && $last_issue_year > $query_year):?>
            <a class="prev page-chevrons rounded-pill" href="<?php echo $base_url . 'rok/' . $query_year + 1;?>"><span class="visually-hidden"><?php echo $query_year + 1;?></span><svg><use xlink:href="#icon-page-prev"></use></svg></a>
        <?php endif;
        //issue links
        for ($i = $last_issue_year; $i >= $first_issue_year; $i--):
            if ( $query_year && $i <= $query_year + $start_size && $i >= $query_year - $end_size ) :
                if($i === $query_year):?>
                    <div aria-current="page" class="page-numbers current bg-primary rounded-pill d-inline-block mx-1"><?php echo $i ?></div>
                <?php else:?>
                    <a class="page-numbers bg-secondary rounded-pill text-decoration-none d-inline-block mx-1" href="<?php echo $base_url . 'rok/' . $i;?>"><?php echo $i;?></a>
                <?php endif;
            endif;
        endfor;

        //older issue link
        if ( $query_year && $query_year > $first_issue_year):?>
            <a class="next page-chevrons rounded-pill" href="<?php echo $base_url . 'rok/' . $query_year - 1;?>"><span class="visually-hidden"><?php echo $query_year - 1;?></span><svg><use xlink:href="#icon-page-next"></use></svg></a>
        <?php endif;

        //first issue link
        if ($query_year && $query_year > $first_issue_year + 1):?>
            <a class="last page-chevrons rounded-pill" href="<?php echo $base_url . 'rok/' . $first_issue_year;?>"><span class="visually-hidden"><?php echo $first_issue_year;?></span><svg><use xlink:href="#icon-page-last"></use></svg></a>
        <?php endif;
        
        
        ?>
        

    </nav>



</main>
<?php
//var_dump($first_issue);


get_footer();

?>

