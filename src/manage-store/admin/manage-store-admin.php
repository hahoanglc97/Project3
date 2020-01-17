<?php
namespace admin;

ini_set('display_errors', 1);

class StoreManageAdmin
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('init', array($this, 'managestore_setup'));
        add_action('add_meta_boxes', array($this, 'boxes_manage_stores_settings'));

    }
    function managestore_setup()
    {
        register_post_type('manage_store', array(
            'label' => 'Manage Store',
            'labels' => array(
                'name' => 'Manage Store',
                'menu_name' => 'Manage Store',
                'singular_name' => 'Store',
                'add_new' => 'Add New Store',
                'all_items' => 'Stores',
                'add_new_item' => 'Add New Store',
                'edit_item' => 'Edit Store',
                'new_item' => 'New Store',
                'view_item' => 'View Store',
                'search_items' => 'Search Store',
                'not_found' => 'No store found',
                'not_found_in_trash' => 'No store found in Trash'
            ),
            'hierarchical' => false,
            'public' => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'show_in_menu' => true,
            'capability_type' => 'page',
            'supports' => array('title'),
            'menu_position' => 207
        ));

    }

    public function boxes_manage_stores_settings()
    {
        add_meta_box('manage-store-add-new', __('Setting Info', 'managestore'), array($this, 'manage_store_add_new'), 'manage_store');
        add_meta_box('manage_store_assign_products', __('Products Assign', 'managestore'), array($this, 'manage_store_assign_products'), 'manage_store');
    }

    public function manage_store_add_new($post, $metabox)
    {
        include_once MANAGESTORE_PATH . 'admin/view/html-add-new-store.php';
    }

    public function manage_store_assign_products($post, $metabox)
    {
//        include_once MANAGESTORE_PATH . 'admin/view/html-assign-products-store.php';
        include_once MANAGESTORE_PATH . 'admin/view/html-table-products-assign.php';
    }

}
new StoreManageAdmin();