<?php
/**
 * Zékario Theme load scripts functionality
 */

function zekario_scripts() {
    wp_enqueue_script( 'jquery-js', get_theme_file_uri( '/assets/library/jquery/jquery-3.1.1.min.js' ), array(), '3.1.1' );
    wp_enqueue_script( 'jquery-ui', get_theme_file_uri( '/assets/library/jquery/jquery.auto-complete.min.js' ), array(), '' );

    wp_enqueue_style( 'tether-css', get_theme_file_uri( '/assets/library/tether/css/tether.min.css' ), array(), '1.3.3' );
    wp_enqueue_script( 'tether-js', get_theme_file_uri( '/assets/library/tether/js/tether.min.js' ), array(), '1.3.3', true );

    wp_enqueue_style( 'bootstrap-css', get_theme_file_uri( '/assets/library/bootstrap/css/bootstrap.min.css' ), array(), '4.0.6' );
    wp_enqueue_script( 'bootstrap-js', get_theme_file_uri( '/assets/library/bootstrap/js/bootstrap.min.js' ), array(), '4.0.6', true );

    wp_enqueue_style( 'font-awesome-css', get_theme_file_uri( '/assets/library/font-awesome/css/font-awesome.min.css' ), array(), '4.7' );

    wp_enqueue_style( 'swiper-css', get_theme_file_uri( '/assets/library/swiper/css/swiper.min.css' ), array(), '4.0.0' );
    wp_enqueue_script( 'swiper-js', get_theme_file_uri( '/assets/library/swiper/js/swiper.min.js' ), array(), '4.0.0', true );

    wp_enqueue_style( 'fancybox-css', get_theme_file_uri( '/assets/library/fancybox/jquery.fancybox.min.css' ), array(), '3.0.0' );
    wp_enqueue_script( 'fancybox-js', get_theme_file_uri( '/assets/library/fancybox/jquery.fancybox.min.js' ), array(), '3.0.0', true );

    wp_enqueue_script( 'shake-js', get_theme_file_uri( '/assets/library/shake/shake.min.js' ), array(), '1.0.0', true );

    wp_enqueue_script( 'gmap3', get_theme_file_uri( '/assets/library/gmap3/gmap3.min.js' ), array(), '3', true );

    wp_enqueue_script( 'barba', get_theme_file_uri( '/assets/library/barba/barba.min.js' ), array(), '', true );
    wp_enqueue_script( 'isotope', get_theme_file_uri( '/assets/library/isotope/isotope.min.js' ), array(), '', true );

    wp_enqueue_script( 'zekario-js', get_theme_file_uri( '/assets/js/theme.min.js' ), array(), '1.0',true );
}
add_action( 'wp_enqueue_scripts', 'zekario_scripts' );

function zekario_scripts_gsap() {
    wp_enqueue_script('GSAP-TweenMax', get_theme_file_uri().'/assets/library/gsap/TweenMax.min.js', array(), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'zekario_scripts_gsap' );

function zekario_scripts_priority() {
    wp_enqueue_style( 'default-style', get_stylesheet_uri() );
    wp_enqueue_style( 'zekario-css', get_theme_file_uri( '/assets/css/theme.min.css' ), array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'zekario_scripts_priority', 11 );

function jra_editor_fontawesome() {
    add_editor_style( get_theme_file_uri( '/assets/library/font-awesome/css/font-awesome.min.css' ) );
}
add_action( 'admin_init', 'jra_editor_fontawesome' );

 function footer() {
      $base = get_stylesheet_directory_uri();
      wp_enqueue_style( 'footer', $base.'/assets/css/footer.min.css' );
 }
 add_action('wp_enqueue_scripts', 'footer', 11 );