<?php
function call_template($template_name) {
    ob_start();
    get_template_part($template_name);
    return ob_get_clean();
}
add_shortcode( 'call_template', 'call_template' );