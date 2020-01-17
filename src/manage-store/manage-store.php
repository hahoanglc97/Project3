<?php
/*
  Plugin Name: Manage Store
  Description: Awesome Manage Store for Your WordPress!
  Version: 1.0.0
  Author: HoangHongHa
 */

/**
 *
 */

use admin\view\order_details\AddFieldSelectStore;

ini_set('display_errors', 1);

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!defined('MANAGESTORE_TEXT_DOMAIN')) {
    define('MANAGESTORE_TEXT_DOMAIN', 'managestore');
}

// Plugin Folder Path
if (!defined('MANAGESTORE_PATH')) {
    define('MANAGESTORE_PATH', plugin_dir_path(__FILE__));
}

// Plugin Folder URL
if (!defined('MANAGESTORE_URL')) {
    define('MANAGESTORE_URL', plugin_dir_url(__FILE__));
}

// Plugin Root File
if (!defined('MANAGESTORE_FILE')) {
    define('MANAGESTORE_FILE', plugin_basename(__FILE__));
}

class ManageStore
{
    /** plugin version number */
    const VERSION = '1.0.0';
    /** plugin text domain */
    const TEXT_DOMAIN = 'managestore';
    private static $managestore_instance;


    public function __construct()
    {
        global $wpdb;
        register_activation_hook(MANAGESTORE_FILE, array($this, 'install'));
        $this->include_for_backend();
        if (is_admin()) {
//            require_once plugin_dir_path(__FILE__) . 'admin/manage-store-setting.php';
//            require_once(plugin_dir_path(__FILE__) . '/admin/init.php');
            require_once(plugin_dir_path(__FILE__) . '/admin/manage-store-admin.php');
            add_action('save_post', array($this, 'save_store_postmeta'),10,2);
            add_action('delete_post', array($this, 'delete_store_postmeta'),10,2);

            //call ajax
            add_action( 'wp_ajax_get_data_product_in_store', array($this,'get_store_data') );
            add_action( 'wp_ajax_nopriv_get_data_product_in_store',  array($this,'get_store_data') );

        }
    }

    public static function getInstance()
    {
        if (!self::$managestore_instance) {
            self::$managestore_instance = new ManageStore();
        }

        return self::$managestore_instance;
    }


    public function include_for_backend()
    {
        include_once MANAGESTORE_PATH . 'model/manage-store-model.php';
        //get field select store
        include_once MANAGESTORE_PATH . 'admin/view/order_details/add-select-store.php';

        //get column option item
        include_once MANAGESTORE_PATH . 'admin/view/order_details/add-column-option-item.php';
    }


    public function install()
    {
        //create Gift Registry page
        $this->create_pages();
        global $wpdb;
        // get current version to check for upgrade
        $installed_version = get_option('managestore_version');
        // install
        if (!$installed_version) {

            $prefix = $wpdb->prefix;

            include_once(ABSPATH . 'wp-admin/includes/upgrade.php');


            //create table manage_store_location
            $query = "CREATE TABLE IF NOT EXISTS `{$prefix}manage_store_location` (
			`location_id` int(11) unsigned NOT NULL auto_increment,
			`post_meta_id` int (1) NOT NULL,
			`post_title` varchar (250)  NOT NULL,
			`status` VARCHAR(50) NOT NULL,
			`name` varchar (250)  NOT NULL,
			`description` varchar (250) NULL,
			`address` VARCHAR(250)  NULL,
			`phone_number` VARCHAR(250)  NULL,
			PRIMARY KEY (`location_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            include_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($query);


            //create table manage_store_product
            $query = "CREATE TABLE IF NOT EXISTS `{$prefix}manage_store_product` (
			`store_product_id` int(11) unsigned NOT NULL auto_increment,
			`post_meta_id` int (11) NOT NULL,
			`product_id` int (1) NOT NULL,
			`import_date` VARCHAR(250)  NULL,
			`out_date` VARCHAR(250)  NULL,
			`qty` varchar (255) NULL,
			PRIMARY KEY (`store_product_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;";
            include_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($query);
        }

    }

    /**
     * create gift registry pages for plugin
     */
    public function create_pages()
    {
        if (!function_exists('wc_create_page')) {
            include_once dirname(__DIR__) . '/woocommerce/includes/admin/wc-admin-functions.php';
        }
        $pages = array(
            'managestore' => array(
                'name' => _x('managestore', 'Page slug', 'woocommerce'),
                'title' => _x('Manage Store', 'Page title', 'woocommerce'),
                'content' => ' [magenest_view_managestore]
                               [manage_search_managestore]
                               [manage_header_managestore_public_view]
                               [manage_table_managestore_public_view]'
            )
        );
        foreach ($pages as $key => $page) {
            wc_create_page(esc_sql($page ['name']), 'follow_up_email' . $key . '_page_id', $page ['title'], $page ['content'], !empty ($page ['parent']) ? wc_get_page_id($page ['parent']) : '');
        }
    }

    public function save_store_postmeta($post_id, $post)
    {
        $type = $post->post_type;
        if ($type == 'manage_store') {
            include_once MANAGESTORE_PATH . 'admin/controllers/addstore-savemeta.php';
            $metakey = new \Manage_AddStore_Savemeta();
            $metakey->updateStore($post_id, $post);
        }
    }

    public function delete_store_postmeta($post_id)
    {
        $type = get_post_type($post_id);
        if ($type == 'manage_store') {
            include_once MANAGESTORE_PATH . 'admin/controllers/managestore-deletedata.php';
            $metakey = new \ManageStore_DeleteData();
            $metakey->deleteStore($post_id);
        }
    }

    //ajax function
    function get_store_data() {
        $product_id = (isset($_POST['productId']))?esc_attr($_POST['productId']) : '';
        $store_id =(isset($_POST['storeId']))?esc_attr($_POST['storeId']) : '';
        $data=[];
        if($product_id != '' && $store_id != ''){
            include_once MANAGESTORE_PATH . 'model/manage-store-product-model.php';
            $model = new Manage_Store_Product_Model();
            $data = $model->get_product_meta_data($store_id,$product_id);
            wp_send_json_success($data);
        }
        wp_send_json_error();
        die();
    }

}

$managestore_loaded = ManageStore::getInstance();
$GLOBAl['managestoreresult'] = array();
?>