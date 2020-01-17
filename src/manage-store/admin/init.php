<?php
function managestore_settings()
{
    wp_redirect(add_query_arg( array( 'page' => 'wc-settings','tab'=>'managestore'), admin_url( 'admin.php' ) ));
}

function managestore_plugin_menu()
{
    add_submenu_page('edit.php?post_type=manage_store', 'Settings', 'Settings', 'manage_options', 'managestore_settings', 'managestore_settings');
}

add_action('admin_menu', 'managestore_plugin_menu');
