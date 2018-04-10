<?php
/*
Page category
*/
?>

<?php get_header();?>
<?php get_template_part("templates-parts/headband") ?>

<?php $cat_parent = get_category(get_category(get_cat_ID(get_the_category()[0]->name))->parent)->slug; ?>

<?php if ( $cat_parent == 'construction' ) : ?>
   
   <?php get_template_part("templates-parts/filter") ?>

    <section class="product_wrapper">
        <div class="container">
            <div class="row grid">
                <?php
                    $the_posts = new WP_Query(array(
                        'category_name' => get_the_category()[0]->slug,
                        'post_type'		=> 'post',
                        'order' => 'ASC',
                        'orderby' => 'date'
                    ));
                ?>
                <?php if ( $the_posts->have_posts() ) : while ( $the_posts->have_posts() ) : $the_posts->the_post(); ?>
                    <?php get_template_part("templates-parts/list-product") ?>
                <?php endwhile; ?>
                    <?php if($wp_query->found_posts > get_option( 'posts_per_page' )) : ?>
                        <div class="col-md-12 text-center"><button categories="" class="category_button"><?php echo __('See all','zekario'); ?></button></div>
                    <?php endif; ?>
                <?php else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php elseif ( $cat_parent == 'industry' ) : ?>

<?php elseif ( $cat_parent == 'carbides' ) : ?>

<?php endif; ?>

<?php get_footer(); ?> 