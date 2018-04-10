<?php
/*
Page default
*/
?>

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
              <div class="col-md-10 offset-md-1 wp-content">
                  <?php the_content(); ?>
              </div>
          </div>
    <?php endwhile; ?>

    <?php else : ?>
      <!-- There are not posts here :'( -->
    <?php endif; ?>
    
</div>

<?php get_footer(); ?>