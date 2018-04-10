<?php
define( 'GF_THEME_IMPORT_FILE', get_theme_file_uri() . '/assets/plugins/config/gf/gf_import.json' );

function add_gf_caps() {
    $role = get_role( 'editor' );
    $role->add_cap( 'gravityforms_view_entries' );
    $role->add_cap( 'gravityforms_edit_entries' );
    $role->add_cap( 'gravityforms_delete_entries' );
}
add_action( 'admin_init', 'add_gf_caps');