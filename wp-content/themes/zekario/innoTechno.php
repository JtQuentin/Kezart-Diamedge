<?php /* Template Name: Innovation and Technology */ ?>

<?php get_header(); ?>
<?php get_template_part("templates-parts/headband") ?>

<div class="container">
    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
    <div class="row page-simple">
        <div class="col-md-12">
            <h1>
                <?php echo get_the_title(); ?>
            </h1>
        </div>
    </div>
    <?php endwhile; ?>

    <?php else : ?>
    <!-- There are not posts here :'( -->
    <?php endif; ?>
</div>

<div class="container images">
    <div class="row">
        <div class="diagonal left col-12">
            <div class="skew">
                <a class="background left-image"  style=" background-image: url('<?php the_field('left-image') ?>')"></a>
            </div>
        </div>
        <div class="diagonal right col-12">
            <div class="skew">
                <a class="background right-image"  style=" background-image: url('<?php the_field('right-image') ?>')"></a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1 wp-content">
            <div id="collapseLeft" class="collapse">
                <?php the_field('left')?>
            </div>
            <div id="collapseRight" class="collapse">
                <?php the_field('right')?>
            </div>
        </div>

        <div class="col-md-10 offset-md-1 wp-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>



<?php get_footer(); ?>
