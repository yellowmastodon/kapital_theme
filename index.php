<?php $load = locate_template('archive.php', true);
     if ($load) {
        exit(); // just exit if template was found and loaded
     }