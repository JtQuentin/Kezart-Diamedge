<?php
if( function_exists( 'acf_add_options_page' ) ) {
    // acf_add_options_page( get_bloginfo() );
	// acf_add_options_page( 'Menu' );

	acf_add_options_page(array(
		'page_title' 	=> get_bloginfo(),
		'menu_slug'		=> 'parent',
		'icon_url'      => 'dashicons-welcome-widgets-menus'
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'À propos',
		'menu_title' 	=> 'À propos',
		'parent_slug' 	=> 'parent',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Réseaux sociaux',
		'menu_title' 	=> 'Réseaux sociaux',
		'parent_slug' 	=> 'parent',
	));

    acf_add_options_sub_page(array(
		'page_title' 	=> 'Témoignages',
		'menu_title' 	=> 'Témoignages',
		'parent_slug' 	=> 'parent',
	));
}

function my_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/assets/plugins/config/acf';

    return $path;
}
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point') ;

function my_acf_json_load_point( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/assets/plugins/config/acf';

    return $paths;
}
add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );
