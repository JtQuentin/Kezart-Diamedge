<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 */
?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?> class="no-js no-svg">

    <head>
        <link rel="alternate" hreflang="fr" href="<?php echo get_site_url(); ?>">
        <link rel="canonical" href="<?php the_permalink(); ?>" />
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/favicon-16.png" sizes="16x16" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/favicon-24.png" sizes="24x24" sizes="24x24">
        <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/favicon-32.png" sizes="32x32" sizes="32x32">
        <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/favicon-96x96.png" sizes="96x96">
        
        <!-- Icons Apple iOS / Google Android -->
        <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/android-chrome-192x192.png" sizes="192x192">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-180.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/apple-icon-180.png">
        <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/manifest.json">
        
        <!-- Icons Microsoft -->
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/assets/icons/microsoft-icon-144.png">
        <meta name="theme-color" content="#000000">
        <meta name="apple-mobile-web-app-title" content="<?php the_field('site', 'option'); ?>">
        <meta name="application-name" content="<?php the_field('nom', 'option'); ?>">
        
        <!-- ACF SEO -->
        <?php
            /*The category have a parent ?*/
            if( is_single() || get_query_var('cat') ){
                $currentCategory = get_the_category();
                if($currentCategory[0]->category_parent > 0) {
                    $category_name = get_cat_name($currentCategory[0]->category_parent) . " / " . $currentCategory[0]->name;
                }else{
                    $category_name = $currentCategory[0]->name;
                }
            }

            /*The category have a parent ?*/
            if( get_query_var('cat') ){
                $currentCategory = get_the_category();
                if(!empty($currentCategory[0]->category_description)){
                    $describe_page = $currentCategory[0]->category_description;
                }else{
                    $describe_page = "Category : " . $category_name;
                }
            }else{
                if(get_field('meta-description')){
                    $describe_page = get_field('meta-description');
                }
                else{
                    $describe_page = get_the_title();
                }
            }

            /*Attribute the title*/
            if( is_front_page() ) :
                    $meta_title = get_field('entreprise_nom', 'option') . " | Accueil";
                elseif( get_query_var('cat') ) :
                    $meta_title = get_field('entreprise_nom', 'option') . " | " . $category_name;
                elseif( get_search_query() ) :
                    $meta_title = get_field('entreprise_nom', 'option') . " | Recherche";
                elseif( is_single() &&  get_field('meta-title') ) :
                    $meta_title = get_field('entreprise_nom', 'option') . " | " . get_field('meta-title') . " | " . $category_name;
                elseif( is_page() ) :
                    $meta_title = get_field('entreprise_nom', 'option') . " | " . get_field('meta-title');
                else :
                    $meta_title = get_field('entreprise_nom', 'option') . " | " . get_the_title() . " | " . $category_name;
            endif;
        ?>
        
        <title><?php echo $meta_title; ?></title>
        
        <meta name="description" content="<?php echo $describe_page; ?>" />
        <meta name="robots" content="noodp" />
        <meta property="fb:app_id" content="990594961070570" />
        <meta property="og:locale" content="fr_FR" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo $meta_title; ?>" />
        <meta property="og:description" content="<?php the_field('meta-description'); ?>" />
        <meta property="og:url" content="<?php echo get_site_url(); ?>" />
        <meta property="og:site_name" content="<?php the_field('nom', 'option'); ?>" />
        <meta property="og:image" content="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'meta-fb-image')[0]; ?>" />
        <?php $image_social = get_field('image', 89); ?>
        <?php if( $image_social ) : ?>
            <meta property="og:image" content="<?php echo $image_social['sizes']['meta-fb-image'];  ?>" />
        <?php endif; ?>
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@<?php the_field( "twitter", 89 ); ?>">
        <meta name="twitter:creator" content="@<?php the_field( "twitter", 89 ); ?>">
        <meta name="twitter:description" content="<?php the_field('meta-description'); ?>">
        <meta name="twitter:title" content="<?php echo $meta_title; ?>">
        <?php if( wp_get_attachment_image_src(get_post_thumbnail_id($post->ID)) ) : ?>
            <meta name="twitter:image" content="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'meta-tw-image')[0]; ?>">
        <?php elseif( $image_social ) : ?>
            <meta name="twitter:image" content="<?php echo $image_social['sizes']['meta-tw-image']; ?>">
        <?php endif; ?>
        
       
        <script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"WebSite","@id":"#website","url":"<?php echo get_site_url(); ?>","name":"<?php the_field('nom', 'option'); ?>","potentialAction":{"@type":"SearchAction","target":"<?php echo get_site_url(); ?>?s={search_term_string}","query-input":"required name=search_term_string"}}</script>
        
               
        <?php wp_head(); ?>
        
        <!-- force load gravity_form  -->
        <?php gravity_form_enqueue_scripts( 4, true ); ?>
        
        <!-- script Google Maps  -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFqA0klyWuqKmSvUHlpBpFh4lpO0VW1qw&region=FR"></script>
        
        <!-- script Google Analytics  -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-XXXXXX-X', 'auto');
            ga('send', 'pageview');
        </script>
    </head>
    
    <body <?php body_class(); ?> id="barba-wrapper">
       <div class="barba-container">
            <header class="site-header" role="banner">
                <div class="topbar">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center text-md-right">
                                <span class="topbar_choice"><?php _e('choose your language','zekario'); ?></span>
                                <ul class="topbar_language">
								<?php if(ICL_LANGUAGE_CODE=='fr'){ ?>
                                    <li class="topbar_language--active">
                                        <a href="http://diamedge.kezart.com/fr/">FR</a>
                                    </li>
                                    <li>
									<?php 
										$url = get_the_permalink();
										$wpml_permalink_en = apply_filters( 'wpml_permalink', $url , 'en' );
										echo '<a href="' . $wpml_permalink_en . '">EN</a>'?>
									</li>
                                    <li>
									<?php 
										$url = get_the_permalink();
										$wpml_permalink_de = apply_filters( 'wpml_permalink', $url , 'de' );
										echo '<a href="' . $wpml_permalink_de . '">DE</a>'?>
									</li>
                                    <li>
                                        RU
                                    </li>
                                
								<?php } 
								if(ICL_LANGUAGE_CODE=='en'){ ?>
									<li>
									<?php 
										$url = get_the_permalink();
										$wpml_permalink_fr = apply_filters( 'wpml_permalink', $url , 'fr' );
										echo '<a href="' . $wpml_permalink_fr . '">FR</a>'?>
									</li>
                                    <li class="topbar_language--active">
                                        <a href="http://diamedge.kezart.com/en/">EN</a>
                                    </li>
                                    <li>
									<?php 
										$url = get_the_permalink();
										$wpml_permalink_de = apply_filters( 'wpml_permalink', $url , 'de' );
										echo '<a href="' . $wpml_permalink_de . '">DE</a>'?>
									</li>
                                    <li>
                                        RU
                                    </li>
								<?php } 
								if(ICL_LANGUAGE_CODE=='de'){ ?>
									<li>
									<?php 
										$url = get_the_permalink();
										$wpml_permalink_fr = apply_filters( 'wpml_permalink', $url , 'fr' );
										echo '<a href="' . $wpml_permalink_fr . '">FR</a>'?>
									</li>
                                    <li>
									<?php 
										$url = get_the_permalink();
										$wpml_permalink_en = apply_filters( 'wpml_permalink', $url , 'en' );
										echo '<a href="' . $wpml_permalink_en . '">EN</a>'?>
									</li>
                                    <li class="topbar_language--active">
                                        <a href="http://diamedge.kezart.com/de/">DE</a>
                                    </li>
                                    <li>
                                        RU
                                    </li>
								<?php } ?>
								</ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="menu-top" class="container">
                    <nav class="navbar navbar-toggleable-md navbar-light">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo home_url("/") ?>">
                        <img class="hidden-md-down navbar_brand-big" src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png" alt="<?php the_field('entreprise_nom', 'option'); ?>">
                        <img class="hidden-lg-up navbar_brand-small" src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo_mini.png" alt="<?php the_field('entreprise_nom', 'option'); ?>">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <?php
                        wp_nav_menu( array(
                            'theme_location'	=> 'menu-top',
                            'container'         => false,
                            'menu_class'		=> '',
                            'items_wrap'        => '<ul id="%1$s" class="navbar-nav %2$s">%3$s</ul>',
                            'depth'             => 3,
                            'walker'            => new b4st_walker_nav_menu()
                        ) );
                        ?>
                    </div>
                    </nav>
                </div>
                
            </header>