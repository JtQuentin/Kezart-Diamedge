<?php
/*
Template Name: Home
*/
?>

<?php get_header(); ?>

<main id="main">
    <div class="home_slider" >
        <div class="swiper-wrapper">
        <?php if( have_rows('slider') ): ?>
            <?php while( have_rows('slider') ): the_row(); 
                $picture = get_sub_field('slider_picture');
                $title = get_sub_field('slider_title');
                $baseline = get_sub_field('slider_baseline');
                $button = get_sub_field('slider_url-button');
                $textButton = get_sub_field('slider_text-button');
            ?>

                <div class="home_slider_item swiper-slide text-center text-sm-left d-flex align-items-center align-items-sm-start" style="background-image: url('<?php echo $picture ?>')">
                    <div class="container">
                        <div class="home_slider_baseline">
                            <h3><?php echo $title ?></h3>
                            <?php if( $baseline ):?>
                                <span><?php echo $baseline ?></span>
                            <?php endif; ?>
                            <?php if( $button ):?>
                                <a href="<?php echo $button ?>" class="btn btn-primary">
                                    <?php echo $textButton; ?> <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
        </div>
        <div class="swiper-button-prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </div>
        <div class="swiper-button-next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </div>
    </div>

    <div class="home_cards container">
        <div class="row card-animation">
            <?php if( have_rows('arguments') ): ?>
                <?php while( have_rows('arguments') ): the_row();
                    $picture = get_sub_field('picture');
                    $nameCategory = get_sub_field('name_category');
                    $baseline = get_sub_field('baseline');
                    // Transform category name for collapse and search
                    // TODO Delete accent and characters
                    $nameCategoryLower = strtolower($nameCategory);
                ?>

                    <div class="col-md-4 mb-5">
                        <figure class="home_card" style="background-image: url('<?php echo $picture ?>')" data-toggle="collapse" data-target="#<?php echo $nameCategoryLower ?>" aria-expanded="false" aria-controls="<?php echo $nameCategoryLower ?>">
                            <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                            <img src="<?php echo $picture ?>" alt="<?php echo $name_category ?>">
                            <figcaption class="home_card_legend">
                                <h2><?php echo $nameCategory ?></h2>
                                <p><?php echo $baseline ?></p>
                            </figcaption>
                        </figure>
                        <div class="home_card_collapse collapse" id="<?php echo $nameCategoryLower ?>">
                            <ul class="home_card_subcategory">

                                <li>
                                    <a class="card-innovation" href="<?php echo get_the_permalink(212) ?>"><?php echo get_the_title(icl_object_id(212,'post')) ?></a>
                                </li>
                                <?php
                                //Give him the name, it find your children
                                $idCategory = get_category_by_slug($nameCategoryLower)->term_id;
                                $categoriesChild = get_categories(
                                    array( 'parent' => $idCategory )
                                );
                                foreach( $categoriesChild as $categoryCurrent ):
                                    echo '<li><a href="'. get_category_link($categoryCurrent->term_id) .'">'. $categoryCurrent->name .'</a></li>';
                                endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</main>


<?php get_footer(); ?>
