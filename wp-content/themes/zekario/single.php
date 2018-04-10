<?php
/*
Page sigle
*/
?>

<?php get_header(); ?>

<?php get_template_part("templates-parts/headband") ?>

<?php $cat_parent = get_category(get_category(get_cat_ID(get_the_category()[0]->name))->parent)->slug; ?>

<?php if ( $cat_parent == 'construction' ) : ?>
    <div class="toolBar" data-toggle="collapse" data-target="#filterExpanded" aria-expanded="false" aria-controls="filterExpanded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="toolBar_title toolBar_title--single">
                        <a href="<?php echo get_category_link(get_the_category()[0]->term_id) ?>">
                            <i data-toggle="toggle" data-target="#filterExpanded" class="fa fa-angle-left" aria-hidden="true"></i>
                        </a>
                        <span><?php the_title(); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="single_wrapper">
        <div class="container">
            <article class="single_pin">
                <div class="row">
                    <div class="col-md-4 col-lg-5 single_pin_image">
                        <a href="<?php echo get_the_post_thumbnail_url(); ?>" data-fancybox data-caption="<?php the_title(); ?>" class="d-flex justify-content-center align-items-center">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"/>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-5 d-flex align-items-end single_pin_describe">
                        <div>
                            <strong class="single_pin_title single_pin_title--no-mt"><?php _e('Specification','zekario'); ?></strong>
                            <div class="wp-content">
                                <?php echo get_field( "specification" ); ?>
                            </div>

                            <strong class="single_pin_title"><?php _e('Application','zekario'); ?></strong>
                            <ul class="single_pin_tags">
                                <?php
                                foreach( get_the_terms( get_the_ID(), 'applications') as $applicationCurrent ): ?>
                                    <li><?php echo $applicationCurrent->name; ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <strong class="single_pin_title"><?php _e('Welding types','zekario'); ?></strong>
                            <ul class="single_pin_types">
                                <?php foreach(get_the_terms( get_the_ID(), 'welding') as $weldingCurrent ): ?>
                                    <li data-toggle="tooltip" data-placement="bottom" title="<?php echo $weldingCurrent->name ?>">
                                        <div class="mb-2" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/<?php echo $weldingCurrent->slug ?>.svg ')">
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2 single_rating">
                        <ul class="single_pin_category">
                            <?php if( get_the_terms( get_the_ID(), 'machines')) :  ?>
                                <?php foreach( get_the_terms( get_the_ID(), 'machines') as $machine ):  ?>
                                    <li data-toggle="tooltip" data-placement="top" title="<?php echo $applicationCurrent->name ?>" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/<?php echo $machine->slug?>.svg')"></li>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </ul>
                        <ul class="single_pin_grade hidden-sm-down">
                            <?php foreach(get_field("grade_selection") as $grade) : ?>
                                <li data-toggle="tooltip" data-placement="top" title="<?php echo $grade["label"] ?>">
                                    <?php for ($x = 0; $x < intval($grade["value"]); $x++){  ?>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    <?php } ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <?php if(have_rows('dimension_choice')): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="single_pin_table table table-responsive">
                                <tbody>
                                <?php
                                    if(have_rows('dimension_choice')){
                                        // Fields ACF name
                                        $headColumns = get_field_object('dimension_choice');

                                        //Array with column
                                        $allColumns = array();
                                        foreach($headColumns['sub_fields'] as $key => $column){
                                            $tmp = array(
                                                    'label' => $column['name'],
                                                    'column'  => array(
                                                        $column['label']
                                                    )
                                            );
                                            array_push($allColumns, $tmp);
                                        }

                                        //Parse the fields ACF and add into the columns
                                        while (have_rows('dimension_choice')) : the_row();
                                            foreach($allColumns as $key => $value) :
                                                array_push($allColumns[$key]['column'], get_sub_field($value['label']));
                                            endforeach;
                                        endwhile;
                                    }

                                    //Verify if the column is empty or not
                                    $columnsForConstruct = array();
                                    foreach($allColumns as $column) :
                                        $deleteSpace = array_filter($column['column']);
                                        if(count($deleteSpace) > 1):
                                            array_push($columnsForConstruct, $column['column']);
                                        endif;
                                    endforeach;

                                    //Construct columns
                                    for($i = 0; $i < count($columnsForConstruct[0]); $i++){
                                        echo '<tr>';
                                            foreach ($columnsForConstruct as $index => $column){
                                                echo '<td>' . $column[$i] . '</td>';
                                            }
                                        echo '</tr>';
                                    }
                            ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(have_rows('dimension_choice_drilling')): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="single_pin_table table table-responsive">
                                <tbody>
                                <?php
                                    if(have_rows('dimension_choice_drilling')){
                                        // Fields ACF name
                                        $headColumns = get_field_object('dimension_choice_drilling');

                                        //Array with column
                                        $allColumns = array();
                                        foreach($headColumns['sub_fields'] as $key => $column){
                                            $tmp = array(
                                                    'label' => $column['name'],
                                                    'column'  => array(
                                                        $column['label']
                                                    )
                                            );
                                            array_push($allColumns, $tmp);
                                        }

                                        //Parse the fields ACF and add into the columns
                                        while (have_rows('dimension_choice_drilling')) : the_row();
                                            foreach($allColumns as $key => $value) :
                                                array_push($allColumns[$key]['column'], get_sub_field($value['label']));
                                            endforeach;
                                        endwhile;
                                    }

                                    //Verify if the column is empty or not
                                    $columnsForConstruct = array();
                                    foreach($allColumns as $column) :
                                        $deleteSpace = array_filter($column['column']);
                                        if(count($deleteSpace) > 1):
                                            array_push($columnsForConstruct, $column['column']);
                                        endif;
                                    endforeach;

                                    //Construct columns
                                    for($i = 0; $i < count($columnsForConstruct[0]); $i++){
                                        echo '<tr>';
                                            foreach ($columnsForConstruct as $index => $column){
                                                echo '<td>' . $column[$i] . '</td>';
                                            }
                                        echo '</tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </article>


            <?php
                $posts = get_field('related_product');
            ?>
            <?php if($posts) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="single_relation"><?php _e('related product(s)','zekario'); ?></h4>
                    </div>
                </div>

                <section class="row">
                    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
                        <?php setup_postdata($post); ?>
                            <?php get_template_part("templates-parts/list-product") ?>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata();  ?>
                </section>
            <?php endif ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
<?php elseif ( $cat_parent == 'industry' ) : ?>

<?php elseif ( $cat_parent == 'carbides' ) : ?>

<?php endif; ?>

<?php get_footer(); ?>