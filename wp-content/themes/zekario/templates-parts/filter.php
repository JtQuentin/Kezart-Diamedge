<?php if(have_posts()) : ?>
<div class="toolBar-tools">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 searchbar--toolbar hidden-xs-down">
                <?php get_search_form( ); ?>
            </div>
            <div class="col-md-6 text-right">
                <p class="toolBar-tools_title">
                    <span><?php echo __('FILTER OUR PRODUCTS','zekario'); ?></span>
                    <em class="icon-show">
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </em>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="filter_sticky">
    <div class="filter">
        <div class="toolBar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="offset-md-6 col-md-6 text-right">
                        <p class="toolBar_title toolBar_title--category">
                            <span><?php echo __('FILTER OUR PRODUCTS','zekario'); ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="filterExpanded" class="filterExpanded">
            <ul class="container filterExpanded_wrapper">
                <li class="row align-items-center">
                    <div class="col-md-2 text-center text-md-left">
                        <h5 class="filterExpanded_title"><?php echo __("Machine's Types",'zekario'); ?></h5>
                    </div>
                    <div class="col-md-10 d-flex justify-content-between align-items-center">
                        <div class="filter_wrapper">
                            <div class="filter_group filter_group--machine">
                                <div class="filter_carrousel filter_carrousel--machine">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $listMachines = array();
                                        $machines = get_terms( 'machines',
                                            array(
                                                'hide_empty' => true,
                                            )
                                        );

                                        foreach($machines as $machine) {
                                            $posts = get_posts(
                                                array(
                                                    'category_name' => get_the_category()[0]->slug,
                                                    'post_type'		=> 'post',
                                                    "tax_query" => array(
                                                        array(
                                                            "taxonomy" => "machines",
                                                            "field"    => "slug",
                                                            "terms"    => $machine->slug, // Replace with a term from member_tax
                                                        )
                                                    )
                                                )
                                            );
                                            if(count($posts)){
                                                $listMachines[$machine->slug] = $machine->name;
                                            }
                                        }
                                        if( $listMachines ): ?>
                                                <div class="filter_carrousel_item swiper-slide">
                                                    <button class="filter_group_button filter_group_button--all filter_all--machine">
                                                        <?php echo __('All','zekario'); ?>
                                                    </button>
                                                </div>
                                            <?php foreach( $listMachines as $key => $listMachine ): ?>
                                                <div class="filter_carrousel_item swiper-slide">
                                                    <div class="filter_group_button" data-filter="<?php echo $key ?>">
                                                        <?php echo file_get_contents("wp-content/themes/zekario/assets/img/". $key .".svg"); ?>
                                                        <span><?php echo $listMachine ?></span>
                                                        <div class="filter_group_state">
                                                            <i class="filter_group_state--hover"></i>
                                                            <svg class="undo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47.971 47.971">
                                                                <path d="M28.228 23.986L47.092 5.122c1.172-1.17 1.172-3.07 0-4.242-1.172-1.172-3.07-1.172-4.242 0L23.986 19.744 5.12.88C3.95-.292 2.05-.292.88.88-.294 2.05-.294 3.95.88 5.122l18.864 18.864L.88 42.85c-1.173 1.17-1.173 3.07 0 4.242.585.585 1.353.878 2.12.878s1.535-.293 2.12-.88l18.866-18.863L42.85 47.09c.586.587 1.354.88 2.12.88s1.536-.293 2.122-.88c1.172-1.17 1.172-3.07 0-4.24L28.228 23.985z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="swiper-button-prev--machine">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                </div>
                                <div class="swiper-button-next--machine">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="row align-items-center">
                    <div class="col-md-2">
                        <h5 class="filterExpanded_title text-center text-md-left"><?php echo __('Applications','zekario'); ?></h5>
                    </div>
                    <div class="col-md-10 d-flex justify-content-between align-items-center">
                        <div class="filter_wrapper">
                            <div class="filter_group filter_group--application">
                                <div class="filter_carrousel filter_carrousel--application">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $listApplications = array();
                                        $applications = get_terms( 'applications',
                                            array(
                                                'hide_empty' => true,
                                            )
                                        );

                                        foreach($applications as $application) {
                                            $posts = get_posts(
                                                array(
                                                    'category_name' => get_the_category()[0]->slug,
                                                    'post_type'		=> 'post',
                                                    "tax_query" => array(
                                                        array(
                                                            "taxonomy" => "applications",
                                                            "field"    => "slug",
                                                            "terms"    => $application->slug, // Replace with a term from member_tax
                                                        )
                                                    )
                                                )
                                            );
                                            if(count($posts)){
                                                $listApplications[$application->slug] = $application->name;
                                            }
                                        }
                                        if($listApplications): ?>
                                                <div class="filter_carrousel_item swiper-slide">
                                                    <button class="filter_group_button filter_group_button--all filter_all--application">
                                                        <?php echo __('All','zekario'); ?>
                                                    </button>
                                                </div>
                                            <?php foreach( $listApplications as $key => $application ): ?>
                                                <div class="filter_carrousel_item swiper-slide">
                                                    <!--<button class="filter_group_button" data-filter=".<?php /*echo $application->slug */?>"><?php /*echo $application->name; */?></button>-->
                                                    <div class="filter_group_button" data-filter="<?php echo $key ?>">
                                                        <span><?php echo $application ?></span>
                                                        <div class="filter_group_state">
                                                            <i class="filter_group_state--hover"></i>
                                                            <svg class="undo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47.971 47.971">
                                                                <path d="M28.228 23.986L47.092 5.122c1.172-1.17 1.172-3.07 0-4.242-1.172-1.172-3.07-1.172-4.242 0L23.986 19.744 5.12.88C3.95-.292 2.05-.292.88.88-.294 2.05-.294 3.95.88 5.122l18.864 18.864L.88 42.85c-1.173 1.17-1.173 3.07 0 4.242.585.585 1.353.878 2.12.878s1.535-.293 2.12-.88l18.866-18.863L42.85 47.09c.586.587 1.354.88 2.12.88s1.536-.293 2.122-.88c1.172-1.17 1.172-3.07 0-4.24L28.228 23.985z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="swiper-button-prev--application">
                                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                                </div>
                                <div class="swiper-button-next--application">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
