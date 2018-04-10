<?php if(is_category() || is_single()) :// Verify if is the single page or category page ?>
        <?php
            $picture_parentCategory = get_field('category_picture', get_the_category()[0]->taxonomy . '_' .get_the_category()[0]->category_parent);
            $picture_currentCategory = get_field('category_picture', get_the_category()[0]->taxonomy . '_' .get_the_category()[0]->term_id);
        ?>
        <?php if($picture_currentCategory == true) : ?>
            <div id="<?php echo get_the_category()[0]->slug ?>" class="headband" style="background-image: url('<?php echo $picture_currentCategory ?>')">
        <?php elseif($picture_currentCategory == false && $picture_parentCategory) :  ?>
            <div id="<?php echo get_the_category()[0]->slug ?>" class="headband" style="background-image: url('<?php echo $picture_parentCategory ?>')">
        <?php else : ?>
            <div class="headband" style="background-color: #000000">
        <?php endif; ?>
    <?php elseif(is_page() && get_the_post_thumbnail_url()) : ?>
        <div class="headband" style="background-image: url('<?php echo get_the_post_thumbnail_url() ?>')">
<?php else : ?>
    <div class="headband" style="background-color: #000000">
<?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 headband_logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/header_logo-category.png" alt="">
            </div>
        </div>

        <div class="row align-items-end">
            <div class="col-md-6 text-center text-md-left mb-3 mb-sm-0">
                <?php if(is_page()) :  ?>
                    <div class="breadcrumbs">
                        <span class="current"><?php echo get_the_title(); ?></span>
                    </div>
                <?php else : the_breadcrumb(); endif;?>
            </div>
            <div class="col-md-6 text-md-right searchbar--headband">
                <?php if(!is_page()) :  ?>
                    <?php get_search_form(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>