<?php /* Template Name: Template that displays lists of authors (autorstvo) */
get_header();

echo kapital_breadcrumbs(array(
    [__('Články', 'kapital'), get_post_type_archive_link('post')],
    [get_the_title(), "", true]

), "container");

$authors = new WP_Term_Query(array(
    'taxonomy'   => 'autorstvo',
    'hide_empty' => true,
    'order' => 'ASC',
    'get' => '',
)); ?>
<main class="main container" role="main" id="main">
    <header class="mb-6" style="max-width: 500px; margin: auto">
        <?php echo kapital_bubble_title(__("Zoznam autorstva", "kapital"), 1);?>
        <div class="term-description h4 text-center ff-grotesk fw-bold lh-sm">
            <?=__("Zobrazuje len autorstvo s počtom článkov väčším ako 2.", "kapital")?>
        </div>

    </header>
    <table class="alignnormal" style="max-width: 500px;">
        <tbody>
            <tr valign="top" class="ff-grotesk lh-sm"><th><?=__("Meno", "kapital");?></th><th class="text-end"><?=__("Počet článkov", "kapital");?></th></tr>
            <?php
            foreach ($authors->terms as $author) {
                if ($author->count > 2){

                
                echo '<tr>';
                echo '<td><a class="ff-grotesk h4 mb-1 fw-normal d-block" href="' . get_term_link($author) . '">' . $author->name . '</a></td>';
                echo '<td class="text-end">' . $author->count . '</td>';
                echo '<tr>';
            }

           } ?>
        </tbody>
    </table>
</main>

<?php
get_footer();
?>