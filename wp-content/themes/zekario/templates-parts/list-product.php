<?php
// Construct List (tag li) with Machine's Icon and Application's Tags
$listSuitable_machine = "";
$listApplication = "";

// Add Class List for Filter
$filterApplication = array();
$filterMachine = array();
?>
<?php foreach( get_the_terms( get_the_ID(), 'machines') as $machineCurrent ):
    $filterMachine[] = $machineCurrent->slug;
    $listSuitable_machine .= '<li data-toggle="tooltip" data-placement="top" title="'. $machineCurrent->name .'" style="background-image: url(\'' . get_template_directory_uri() . '/assets/img/' . $machineCurrent->slug. '.svg\')"></li>';
endforeach; ?>

<?php foreach( get_the_terms( get_the_ID(), 'applications') as $applicationCurrent ):
    $filterApplication[] = $applicationCurrent->slug;
    $listApplication[] = '<li>'. $applicationCurrent->name .'</li>';
endforeach; ?>

<div class="col-sm-6 col-md-4 col-lg-3 mb-5 mt-5 <?php echo join(' ', $filterApplication). ' ' . join(' ', $filterMachine) ?>" data-category="">
    <div class="product">
        <a class="product_link" href="<?php the_permalink(); ?>"></a>
        <h1 class="product_title">
            <?php echo (strlen(get_the_title()) > 20) ? substr(get_the_title(),0,15).'...' : get_the_title(); ?>
        </h1>
        <div class="product_picture">
            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
        </div>
        <ul class="product_category">
            <?php echo $listSuitable_machine ?>
        </ul>
        <div class="product_application">
            <strong><?php echo __('Application','zekario'); ?></strong>
            <ul class="product_application_tags">
                        <?php if(count($listApplication) > 3): $beContined = '<li>...</li>'; else: $beContined = ''; endif;?>
                <?php echo implode("", array_slice($listApplication, 0, 3)) . $beContined ?>
            </ul>
        </div>
        <a href="<?php the_permalink(); ?>" class="product_button">
           	<?php echo __('+ details','zekario'); ?>
        </a>
    </div>
</div>
