<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 */
?>

        <footer class="footer" role="contentinfo">
            <div class="footer_address">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-map-marker" aria-hidden="true"></i> <?php the_field('entreprise_adresse', 'option'); ?>, <?php the_field('entreprise_code_postal', 'option'); ?> <?php the_field('entreprise_ville', 'option'); ?> <?php the_field('entreprise__ville', 'option'); ?> <span class="hidden-xs-down">|</span> <span class="break-line"><i class="fa fa-phone" aria-hidden="true"></i> <?php the_field('entreprise_telephone', 'option'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_information">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-left">
                            <?php 
                                wp_nav_menu( array(
                                    'theme_location'	=> 'menu-bottom',
                                    'container'         => false,
                                    'menu_class'		=> 'footer_navbar'
                                ) );
                            ?>
                        </div>
                        <div class="col-md-6 text-center text-md-right">
                            Copyright © <?php echo date('Y'); ?> Kézart | <a href="/mentions-legales/"><?php _e('Legal Notice','zekario'); ?></a> | <?php _e('Powered by','zekario'); ?> <a href="http://kezart.com" target="_blank">Kézart</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        </div> <!--wrapper-barba-->
        <div class="transition">
            <div class="transition_panel_top"></div>
            <div class="transition_panel_bottom"></div>
            <div class="transition_animation">
                <canvas width="200" height="200" class="transition_logo"></canvas>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo_animation.svg" alt="">
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>