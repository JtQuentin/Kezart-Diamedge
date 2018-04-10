<?php
/**
 * Zékario Theme functions and definitions
 */

require_once dirname( __FILE__ ) . '/inc/class/class-tgm-plugin-activation.php';

require get_template_directory() . '/inc/load-scripts.php';
require get_template_directory() . '/inc/load-plugins.php';
require get_template_directory() . '/inc/load-acf.php';
require get_template_directory() . '/inc/load-gf.php';
require get_template_directory() . '/inc/navbar.php';
require get_template_directory() . '/inc/breadcrumb.php';
require get_template_directory() . '/inc/load-autocomplete.php';
require get_template_directory() . '/inc/load-filter.php';
require get_template_directory() . '/inc/load-template.php';
require get_template_directory() . '/inc/load-customQuery.php';
require get_template_directory() . '/inc/debug.php'; // Debug function for pre var_dump

add_filter( 'show_admin_bar', '__return_false' );
add_filter( 'sanitize_file_name', 'remove_accents' );
add_filter( 'get_the_excerpt', 'wpautop' );
remove_shortcode( 'wpv-post-excerpt' );
add_shortcode( 'wpv-post-excerpt', 'get_the_excerpt' );

/**
 * Zékario Theme only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
    require get_template_directory() . '/inc/back-compat.php';
    return;
}

function zekario_setup() {
    load_theme_textdomain( 'zekario', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-thumbnails' );

    add_image_size( 'image-sm', 576, 'auto', true );
    add_image_size( 'image-md', 768, 'auto', true );
    add_image_size( 'image-lg', 992, 'auto', true );
    add_image_size( 'image-xl', 1200, 'auto', true );

    add_image_size( 'meta-fb-image', 1200, 630, true );
    add_image_size( 'meta-tw-image', 1024, 512, true );

    register_nav_menus( array(
        'menu-top'    => __( 'Menu Top', 'zekario' ),
        'menu-bottom' => __( 'Menu Bottom', 'zekario' ),
        'menu-mobile' => __( 'Menu Mobile', 'zekario' ),
    ) );

    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    add_theme_support( 'custom-logo', array(
        'width'       => 250,
        'height'      => 250,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'zekario_setup' );

/*
 * Custom filter to remove default image sizes from WordPress.
 */
function remove_default_image_sizes( $sizes ) {

  /* Default WordPress */
  unset( $sizes[ 'medium' ]);          // Remove Thumbnail (150 x 150 hard cropped)
  unset( $sizes[ 'medium' ]);          // Remove Medium resolution (300 x 300 max height 300px)
  unset( $sizes[ 'medium_large' ]);    // Remove Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
  unset( $sizes[ 'large' ]);           // Remove Large resolution (1024 x 1024 max height 1024px)

  /* With WooCommerce */
  unset( $sizes[ 'shop_thumbnail' ]);  // Remove Shop thumbnail (180 x 180 hard cropped)
  unset( $sizes[ 'shop_catalog' ]);    // Remove Shop catalog (300 x 300 hard cropped)
  unset( $sizes[ 'shop_single' ]);     // Shop single (600 x 600 hard cropped)

  return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'remove_default_image_sizes' );

function zekario_excerpt_more( $link ) {
    if ( is_admin() ) {
        return $link;
    }

    $link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
        esc_url( get_permalink( get_the_ID() ) ),
        sprintf( __( 'En savoir plus<span class="screen-reader-text"> "%s"</span>', 'zekario' ), get_the_title( get_the_ID() ) )
    );
    return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'zekario_excerpt_more' );

function zekario_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'zekario_javascript_detection', 0 );

function zekario_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
    }
}
add_action( 'wp_head', 'zekario_pingback_header' );

function cc_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'add_excerpts_to_pages' );

function srcset_responsive_image($image_id,$image_size,$max_width){
    if($image_id != '') {
        $image_src = wp_get_attachment_image_url( $image_id, $image_size );
        $image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );
        echo 'src="'.$image_src.'" srcset="'.$image_srcset.'" sizes="(max-width: '.$max_width.') 100vw, '.$max_width.'"';
    }
}


function my_acf_admin_enqueue_scripts() {
	// register style
    wp_register_style( 'my-acf-input-css', get_stylesheet_directory_uri() . '/assets/css/acf.css', false, '1.0.0' );
    wp_enqueue_style( 'my-acf-input-css' );
}

add_action( 'acf/input/admin_enqueue_scripts', 'my_acf_admin_enqueue_scripts' );

// Register Taxonomy Machine
function machines() {

    $labels = array(
        'name'                       => _x( 'Machines', 'Taxonomy General Name', 'hierarchical_tags' ),
        'singular_name'              => _x( 'Machines', 'Taxonomy Singular Name', 'hierarchical_tags' ),
        'menu_name'                  => __( 'Machines', 'hierarchical_tags' ),
        'all_items'                  => __( 'Toutes', 'hierarchical_tags' ),
        'add_new_item'               => __( 'Ajouter une nouvelle machine', 'hierarchical_tags' ),
        'edit_item'                  => __( 'Modifier la machine', 'hierarchical_tags' ),
        'update_item'                => __( 'Mettre à jour la machine', 'hierarchical_tags' ),
        'view_item'                  => __( 'Voir la machine', 'hierarchical_tags' ),
        'add_or_remove_items'        => __( 'Ajouter / supprimer des machines', 'hierarchical_tags' ),
        'search_items'               => __( 'Search Items', 'hierarchical_tags' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'machines', array( 'post' ), $args );

}

add_action( 'init', 'machines', 0 );




// Register Taxonomy Applications
function applications() {

    $labels = array(
        'name'                       => _x( 'Applications', 'Taxonomy General Name', 'hierarchical_tags' ),
        'singular_name'              => _x( 'Applications', 'Taxonomy Singular Name', 'hierarchical_tags' ),
        'menu_name'                  => __( 'Applications', 'hierarchical_tags' ),
        'all_items'                  => __( 'Toutes', 'hierarchical_tags' ),
        'add_new_item'               => __( 'Ajouter une nouvelle application', 'hierarchical_tags' ),
        'edit_item'                  => __( 'Modifier l\'application', 'hierarchical_tags' ),
        'update_item'                => __( 'Mettre à jour l\'application', 'hierarchical_tags' ),
        'view_item'                  => __( 'Voir l\'application', 'hierarchical_tags' ),
        'add_or_remove_items'        => __( 'Ajouter / supprimer des applications', 'hierarchical_tags' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'applications', array( 'post' ), $args );

}
add_action( 'init', 'applications', 0 );



// Register Taxonomy Welding Type
function welding() {

    $labels = array(
        'name'                       => _x( 'Welding type', 'Taxonomy General Name', 'hierarchical_tags' ),
        'singular_name'              => _x( 'Welding type', 'Taxonomy Singular Name', 'hierarchical_tags' ),
        'menu_name'                  => __( 'Welding type', 'hierarchical_tags' ),
        'all_items'                  => __( 'All Welding type', 'hierarchical_tags' ),
        'add_new_item'               => __( 'Add Welding type', 'hierarchical_tags' ),
        'edit_item'                  => __( 'Edit Welding type', 'hierarchical_tags' ),
        'update_item'                => __( 'UpdateWelding type', 'hierarchical_tags' ),
        'view_item'                  => __( 'View Welding type', 'hierarchical_tags' ),
        'add_or_remove_items'        => __( 'Add or remove Welding type', 'hierarchical_tags' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'welding', array( 'post' ), $args );

}
add_action( 'init', 'welding', 0 );




// Remove Taxonomy post_tag (etiquettes)
add_action('init', function(){
    global $wp_taxonomies;
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
    if ( taxonomy_exists( 'post_tag'))
        unset( $wp_taxonomies['post_tag']);
    unregister_taxonomy('post_tag');
});

// Remove Taxonomy post_tag (etiquettes)
add_action('init', function(){
    global $wp_taxonomies;
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
    if ( taxonomy_exists( 'post_tag'))
        unset( $wp_taxonomies['post_tag']);
    unregister_taxonomy('post_tag');
});




add_filter( 'post_gallery', 'bootstrap_gallery', 10, 3 );

function bootstrap_gallery( $output = '', $atts, $instance )
{
    $images = explode(',', $atts['ids']);
    $return = '<div class="swiper-container wp_gallery"><div class="swiper-wrapper">';

    foreach ($images as $key => $value) {
        $image_attributes = wp_get_attachment_image_src($value, 'full');
        $return .= '
                        <div class="swiper-slide">
                            <a href="'.$image_attributes[0].'" data-fancybox="carousel" data-caption="' . get_post($value)->post_excerpt . '">
                                <img src="'.$image_attributes[0].'" alt="' . get_post($value)->post_excerpt . '">
                            </a>
                            <p>' . get_post($value)->post_excerpt . '</p>
                        </div>
                    ';
    }

    $return .= '</div><div class="swiper-pagination"></div></div>';

    return $return;
}




?>