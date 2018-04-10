<?php
function adding_register_query_vars( $vars ) {
    $vars[] = 'applications';
    $vars[] = 'products';
    return $vars;
}
add_filter( 'query_vars', 'adding_register_query_vars' );

function ds_swap_search_parameter($query_string) {

    $query_string_array = array();

    // convert the query string to an array
    parse_str($query_string, $query_string_array);

    // if "search" is in the query string
    if(isset($query_string_array['products'])){
        $query_string_array['s'] = $query_string_array['products']; // replace "s" with value of "search"
        unset($query_string_array['products']); // delete "search" from query string
    }
    if(isset($query_string_array['applications'])){
        $query_string_array['s'] = $query_string_array['applications']; // replace "s" with value of "search"
        unset($query_string_array['applications']); // delete "search" from query string
    }

    return http_build_query($query_string_array, '', '&'); // Return our modified query variables
}
add_filter('query_string', 'ds_swap_search_parameter');