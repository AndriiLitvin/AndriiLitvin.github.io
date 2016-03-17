<?php

if ( is_front_page() && mega_option( 'show_front' ))
	get_template_part( 'template', 'home' );
else
	get_template_part( 'index' );