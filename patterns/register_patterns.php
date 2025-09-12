<?php

add_action( 'init', 'kapital_register_patterns' );

function kapital_register_patterns() {
    $template_dir = get_template_directory();
    //wp_die($template_dir);

    register_block_pattern_category( 
        'kapital/recordings',
        array(
            'label'       => __( 'Záznamy a galéria', 'kapital' ),
            'description' => __( 'Templaty pre vkladanie do podujatí.', 'kapital' )
        )

    );

 	register_block_pattern( 'kapital/event-recording-audio', array(
		'title'      => __( 'Audio záznam podujatia', 'kapital' ),
		'categories' => array( 'kapital/recordings' ),
        'keywords'  => array('zaznam', 'recording', 'audio', 'event', 'podcast', 'podujatie', 'podujatia'),
		'content'    => file_get_contents("$template_dir/patterns/event-recording-audio.html"),
        'viewportWidth' => 900,
        'source' => 'theme'
	) ); 

    
 	register_block_pattern( 'kapital/event-recording-gallery', array(
		'title'      => __( 'Galéria podujatia', 'kapital' ),
		'categories' => array( 'kapital/recordings' ),
        'keywords'  => array('zaznam', 'recording', 'foto', 'pictures', 'pics', 'fotografie', 'galéria', 'obrázky', 'podujatia', 'podujatie'),
		'content'    => file_get_contents("$template_dir/patterns/event-recording-gallery.html"),
        'viewportWidth' => 900,
        'source' => 'theme',
        'blockTypes' => array('core/gallery')
	) ); 

    register_block_pattern( 'kapital/event-recording-video', array(
		'title'      => __( 'Galéria podujatia', 'kapital' ),
		'categories' => array( 'kapital/recordings' ),
        'keywords'  => array('zaznam', 'recording', 'video', 'film', 'podujatia', 'podujatie'),
		'content'    => file_get_contents("$template_dir/patterns/event-recording-video.html"),
        'viewportWidth' => 900,
        'source' => 'theme',
	) ); 
}