<?php
//get listings for 'works at' on submit listing page
add_action('wp_ajax_nopriv_get_listing_names', 'ajax_listings');
add_action('wp_ajax_get_listing_names', 'ajax_listings');

function ajax_listings() {
    $searchValue = $_POST['name']['term'];

    $queryTerms = array(
        'taxonomy'   => 'applications',
        'hide_empty' => true,
        'name__like' => $searchValue
    );

    $queryProducts = array(
        'post_type' => 'post',
        's'         => $searchValue
    );

    $resultsProducts = new WP_Query($queryProducts);
    wp_reset_postdata();

    $resultsApplications = get_terms($queryTerms);

    $jsonDatas = array();
    foreach($resultsProducts->posts as $result){
        array_push($jsonDatas, array('value' => $result->post_title, 'category' => 'Product(s)'));
    }

    foreach($resultsApplications as $result){
        array_push($jsonDatas, array('value' => $result->name, 'category' => 'Application(s)'));
    }
    echo json_encode($jsonDatas); //encode into JSON format and output

    die(); //stop "0" from being output
}