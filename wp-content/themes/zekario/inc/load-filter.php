<?php
//get listings for 'works at' on submit listing page
add_action('wp_ajax_nopriv_filter_products', 'ajax_filter');
add_action('wp_ajax_filter_products', 'ajax_filter');

function ajax_filter() {
    global $machines;
    global $applications;
    global $category;
    global $show_all;
    global $tags;
    global $firstPass;
    global $max_displayPosts;
    global $current_maxPosts;

    $max_displayPosts = get_option( 'posts_per_page' );

    $applications = $_POST["applications"];
    $machines = $_POST["machines"];
    $category = $_POST["category"];
    $show_all = $_POST["showAll"];

    function init(){
        global $machines;
        global $applications;
        global $tags;
        global $show_all;

        $displayResult = "";
        $tags = array();

        if($show_all == 'false'){
            // First past apply condition AND with all applications and machines
            $queryApplications = count($applications) > 0 ? constructQueryApplication($applications) : false;
            $queryMachines = count($machines) > 0 ? constructQueryMachine($machines) : false;
            $prepare_query = prepareQuery($queryMachines, $queryApplications);
            $result_query = doQuery($prepare_query);
            $displayResult .= constructResponse($result_query);

            // Parse the others array
            if(
                (count($applications) > 1 && count($machines) == 0)     ||
                (count($applications) == 0 && count($machines) > 1)     ||
                (count($applications) == 1 && count($machines) == 1)    ||
                (count($applications) >= 1 && count($machines) >= 1)
            ){

                if(count($applications) > 0){
                    foreach ($applications as $application){
                        $queryApplications = constructQueryApplication($application, false);
                        $prepare_query = prepareQuery(false, $queryApplications);
                        $result_query = doQuery($prepare_query);
                        $displayResult .= constructResponse($result_query);
                    }
                }

                if(count($machines) > 0){
                    foreach ($machines as $machine){
                        $queryMachines = constructQueryMachine($machine, false);
                        $prepare_query = prepareQuery($queryMachines, false);
                        $result_query = doQuery($prepare_query);
                        $displayResult .= constructResponse($result_query);
                    }
                }
            }

        }
        else{
            $queryApplications = count($applications) > 0 ? constructQueryApplication($applications) : false;
            $queryMachines = count($machines) > 0 ? constructQueryMachine($machines) : false;
            $prepare_query = prepareQuery($queryMachines, $queryApplications);
            $result_query = doQuery($prepare_query);
            $displayResult .= constructResponse($result_query);
        }

        return $displayResult;
    }


    function constructQueryApplication($applications, $multi = true){
        global $tags;
        global $firstPass;

        $application_query = array('');

        if($multi){
            $firstPass = true;
            foreach ($applications as $application){
                $condition = array(
                    'taxonomy' => 'applications',
                    'field'    => 'slug',
                    'terms'    => $application["key"]
                );
                array_push($application_query, $condition);
                array_push($tags, array($application["key"] => $application["value"]));
            }
        }
        else{
            $firstPass = false;
            $condition = array(
                'taxonomy' => 'applications',
                'field'    => 'slug',
                'terms'    => $applications["key"]
            );
            array_push($application_query, $condition);
            array_push($tags, array($applications["key"] => $applications["value"]));
        }

        return $application_query;
    }

    function constructQueryMachine($machines, $multi = true){
        global $tags;
        global $firstPass;

        $machine_query = array();
        if($multi) {
            $firstPass = true;
            foreach ($machines as $machine) {
                $condition = array(
                    'taxonomy' => 'machines',
                    'field'    => 'slug',
                    'terms'    => $machine["key"]
                );
                array_push($machine_query, $condition);
                array_push($tags, array($machine["key"] => $machine["value"]));
            }
        }
        else{
            $firstPass = false;
            $condition = array(
                'taxonomy' => 'machines',
                'field'    => 'slug',
                'terms'    => $machines["key"]
            );
            array_push($machine_query, $condition);
            array_push($tags, array($machines["key"] => $machines["value"]));
        }

        return $machine_query;
    }

    // Inject query
    function prepareQuery($machines = false, $applications = false){
        global $category;
        global $show_all;
        global $firstPass;
        global $max_displayPosts;
        global $current_maxPosts;

        $prepare = array(
            'category_name' => $category,
            'post_type'		=> 'post',
            'order' => 'ASC',
            'orderby' => 'date'
        );

        if($show_all == 'false' && $firstPass == true){
            $current_maxPosts = $max_displayPosts;
            $prepare['posts_per_page'] = $current_maxPosts;
            $prepare['tax_query'] = array(
                'relation' => 'AND',
            );
        }
        else if($show_all == 'false' && $firstPass == false && !is_null($firstPass)){
            $current_maxPosts = $max_displayPosts / 2;
            $prepare['posts_per_page'] = $current_maxPosts;
            $prepare['tax_query'] = array(
                'relation' => 'AND',
            );
        }
        else if($show_all == 'true' && $firstPass == true){
            $current_maxPosts = -1;
            $prepare['posts_per_page'] = $current_maxPosts;
            $prepare['tax_query'] = array(
                'relation' => 'AND',
            );
        }
        else if($show_all == 'true' && $machines == false && $applications == false){
            $current_maxPosts = -1;
            $prepare['posts_per_page'] = $current_maxPosts;
            $prepare['tax_query'] = array(
                'relation' => 'AND',
            );
        }else if($machines == false && $applications == false){
            $current_maxPosts = -1;
        }

        if($machines != false){
            array_push($prepare['tax_query'], $machines);
        }
        if($applications != false){
            array_push($prepare['tax_query'], $applications);
        }
        return $prepare;
    }

    function doQuery($prepare){
        $result_query = new WP_Query($prepare);
        wp_reset_postdata();
        return $result_query;
    }

    function constructResponse($result_query){
        global $tags;
        global $show_all;
        global $current_maxPosts;


        $result = "";
        $key_more = array();

        if ($result_query){
            $list_tags = "";
            //Construct List
            foreach($tags as $key){
                foreach($key as $newkey => $value ){
                    array_push($key_more, $newkey);
                    $list_tags .= "<li id='" . $newkey . "' class='filter_button_grid'><i class=\"fa fa-times-circle\" aria-hidden=\"true\"></i>" . $value . "</li>";
                }
            }

            if($result_query->found_posts > 0){
                $result .= "<div class='col-md-12 category_headband d-flex'><div class='w-50 text-left'><ul>" .  $list_tags . "</ul></div> <div class='w-50 text-right category_headband_title'>" . $result_query->found_posts .  " " . __(' RESULT(S)','zekario') . "</div></div>";
                while ( $result_query->have_posts() ) : $result_query->the_post();
                    $result .= call_template("templates-parts/list-product");
                endwhile;
                if($result_query->found_posts > $current_maxPosts && $show_all == 'false' && !is_null($current_maxPosts)){
                    $result .= "<div class='col-md-12 text-center'><button categories='" . join(' ', $key_more) . "' class='category_button'> " . __('See all','zekario') . " </button></div>";
                }
            }
            else{
                $result .= "<div class='col-md-12 category_headband category_headband--noResult text-center'><span> " . __('sorry, no results found','zekario') . " </span><ul>" .  $list_tags . "</ul></div>";
            }
        }
        // Empty Array
        $tags = array();
        return $result;
    }

    echo json_encode(init());

    die(); //stop "0" from being output
}