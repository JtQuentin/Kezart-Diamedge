<?php
/*
Template Name: Search Page
*/
?>

<?php get_header();?>
<?php


?>
<?php get_template_part("templates-parts/headband") ?>
<?php //get_template_part("templates-parts/filter") ?>
<?php
    //https://www.smashingmagazine.com/2016/03/advanced-wordpress-search-with-wp_query/
?>

<?php

if(isset($_GET['applications']) || isset($_GET['products'])) :
    if(isset($_GET['applications']) && !empty($_GET['applications'])) :
        $querySearch = array(
            'post_type' => 'post',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'applications',
                    'field'    => 'slug',
                    'terms'    => $_GET['applications']
                )
            )
        );
    elseif(isset($_GET['products']) && !empty($_GET['products'])) :
        $querySearch = array(
            'post_type' => 'post',
            's'         => $_GET['products']
        );
    else:
    endif;
    $query = new WP_Query($querySearch);
endif;


?>
<section class="product_wrapper">
    <div class="container">
        <div class="row grid">
            <?php $havePost = false; ?>
            <?php if ($query->have_posts()) : ?>
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php if(get_post_type() === "post") : ?>
                        <?php $havePost = true; ?>
                        <?php get_template_part("templates-parts/list-product") ?>
                    <?php endif; ?>
                <?php endwhile; ?>
                <?php if($havePost === false) : ?>
                    <h6 class="search_no-found text-center">Sorry, we don't have results</h6>
                <?php endif; ?>
            <?php else : ?>
                <h6 class="search_no-found text-center">Sorry, we don't have results</h6>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?> 